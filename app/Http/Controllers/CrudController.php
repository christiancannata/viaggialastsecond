<?php

namespace Meritocracy\Http\Controllers;

use Illuminate\Support\Facades\App;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class CrudController extends Controller
{


    /**
     * Instantiate a new UserController instance.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['registerUserOrCompanyUser', 'createContactRequest']]);
        $this->middleware('referer');
    }

    function make_post($apiRoute, $params)
    {
        $client = App::make('client.api');
        $response = $client->request("POST", $apiRoute, ['form_params' => $params]);

        if ($response->getStatusCode() == 201 || $response->getStatusCode() == 204) {

            $resp = $response->getHeader("Location");
            $resp = explode("/", $resp[0]);
            return ["success" => 1, "statusCode" => $response->getStatusCode(), "id" => end($resp)];
        } else {
            return ["success" => 0, "statusCode" => $response->getStatusCode()];
        }
    }


    function reverse_geocode($address)
    {
        $address = str_replace(" ", "+", "$address");
        $url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false";
        $result = file_get_contents("$url");
        $json = json_decode($result);
        $city = "";
        $country = "";
        foreach ($json->results as $result) {
            foreach ($result->address_components as $addressPart) {
                if ((in_array('locality', $addressPart->types)) && (in_array('political', $addressPart->types)))
                    $city = $addressPart->long_name;
                else if ((in_array('administrative_area_level_1', $addressPart->types)) && (in_array('political', $addressPart->types)))
                    $state = $addressPart->long_name;
                else if ((in_array('country', $addressPart->types)) && (in_array('political', $addressPart->types)))
                    $country = $addressPart->short_name;
            }
        }


        return ["city" => $city, "country" => $country];
    }


    public function searchCodiceSconto(Request $r)
    {


        $codiceSconto = $this->make_get("/api/codice-sconto?isActive=true&name=" . Input::get("codiceSconto"));

        if (!empty($codiceSconto)) {
            return response()->json($codiceSconto, 200);

        } else {
            return response()->json([], 200);

        }


    }


    public function patchCompany($id)
    {

        $client = App::make('client.api');

        $inputs[] = Input::all();


        $dequeue = false;

        $companyOldStatus = (isset(Auth::user()->company['is_complete'])) ? Auth::user()->company['is_complete'] : true;
        $companyOldVisible = (isset(Auth::user()->company['is_visible'])) ? Auth::user()->company['is_visible'] : false;


        $method = "PATCH";
        $route = "/api/company/" . $id;


        if (isset($inputs[0]['city']['id']) && $inputs[0]['city']['id'] == "") {
            unset($inputs[0]['city']);
        }
        if (isset($inputs[0]["story"])) {
            $inputs[0]["story"] = preg_replace('/<!--(.|\s)*?-->/', '', strip_tags($inputs[0]["story"], "<p><br><strong><i><b><u><ol><li><blockquote><italic>"));
            $inputs[0]["story"] = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $inputs[0]["story"]);

        }
        if (isset($inputs[0]["vision"])) {
            $inputs[0]["vision"] = preg_replace('/<!--(.|\s)*?-->/', '', strip_tags($inputs[0]["vision"], "<p><br><strong><i><b><u><ol><li><blockquote><italic>"));
            $inputs[0]["vision"] = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $inputs[0]["vision"]);

        }
        if (isset($inputs[0]["mission"])) {
            $inputs[0]["mission"] = preg_replace('/<!--(.|\s)*?-->/', '', strip_tags($inputs[0]["mission"], "<p><br><strong><i><b><u><ol><li><blockquote><italic>"));
            $inputs[0]["mission"] = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $inputs[0]["mission"]);

        }


        if (isset($inputs[0]['benefit'])) {
            $benefits = $inputs[0]['benefit'];
            unset($inputs[0]['benefit']);
        }

        if (isset($inputs[0]['assistenza_gratuita'])) {
            unset($inputs[0]['assistenza_gratuita']);
        }


        if (isset($inputs[0]['address'])) {

            $addresses = $inputs[0]['address'];
            unset($inputs[0]['address']);
        }


        foreach ($inputs[0] as $key => $input) {
            if ($input == "true" || $input == "false") {
                $inputs[0][$key] = $input === 'true' ? true : false;
            }
        }

        if (Auth::user()->company['is_visible'] == false && isset($inputs[0]["is_visible"]) && $inputs[0]["is_visible"] == true) {

            $date = new \DateTime();
            $inputs[0]['publish_date'] = $date->format("Y-m-d H:i");
        }


        $response = $client->request($method, $route, ['form_params' => $inputs]);


        if ($response->getStatusCode() == 204) {
            $resp = $response->getHeader("Location");
            $resp = explode("/", $resp[0]);


            if (!empty($benefits)) {
                $params = [];
                foreach ($benefits as $benefit) {
                    $params[] = [
                        "company" => ["id" => $id],
                        "benefit" => $benefit
                    ];
                }
                $client->request("POST", "/api/company/{$id}/benefits", ['form_params' => $params]);
            }


            if (!empty($addresses)) {
                $params = [];
                foreach ($addresses['name'] as $key => $address) {

                    if (trim($address) != "" && $addresses['city_plain_text'][$key] != "") {
                        $appo = [
                            "company" => ["id" => $id],
                            "name" => $address,
                            "city_plain_text" => trim($addresses['city_plain_text'][$key])
                        ];

                        if (isset($addresses['city_id'][$key]) && $addresses['city_id'][$key] != "") {
                            $appo["city"] = ["id" => $addresses['city_id'][$key]];

                        }
                        if (isset($addresses['postal_code'][$key]) && $addresses['postal_code'][$key] != "") {
                            $appo["postal_code"] = $addresses['postal_code'][$key];

                        }

                        $params[] = $appo;
                    }


                }
                $client->request("POST", "/api/company/{$id}/addresses", ['form_params' => $params]);
            }
            $responseCompany = $client->request("GET", "/api/company/{$id}?serializerGroup[]=react");
            $newCompany = json_decode($responseCompany->getBody()->getContents(), true);

            if (isset($inputs[0]["is_visible"]) && $companyOldVisible == false && $newCompany['is_visible'] == true) {
                $subject = $newCompany["name"] . " is now public on Meritocracy";
                $msg = [
                    "title" => $subject,
                    "text" => $newCompany["name"] . " is now public on Meritocracy.<br>Link:  https://meritocracy.is/" . $newCompany["permalink"]
                ];

                $emailData[] = [
                    "status" => "ENQUEUED",
                    "params" => $msg,
                    "subject" => $subject,
                    "sender" => [
                        "name" => "Meritocracy",
                        "email" => 'account@meritocracy.is'
                    ],
                    "language" => strtoupper(\Illuminate\Support\Facades\App::getLocale()),
                    "cc" => [],
                    "bcc" => [],
                    "send_at" => (new \DateTime())->format("Y-m-d H:i"),
                    "recipient" => [
                        "name" => "Meritocracy Company",
                        "email" => "info@meritocracy.is"
                    ],
                    "method" => "INTERN",
                    "template" => "SIMPLE_MAIL_TEMPLATE",
                ];


                $client = App::make('client.api');

                $response = $client->request("POST", "/api/email-queue", ['form_params' => $emailData]);


            }
            if ($companyOldStatus == false) {

                if ($newCompany['is_complete'] == true) {
                    $params = [
                        "templates" => "UNCOMPLETE_COMPANY_PAGE_FIRST_ALERT,UNCOMPLETE_COMPANY_PAGE"
                    ];
                    try {
                        $client->request("POST", "/api/email-queue/dequeue/user/" . Auth::user()->id, ['form_params' => $params]);
                    } catch (\Exception $e) {

                    }
                }

            }


            return response()->json(["id" => end($resp)], 204);
        } else {
            return response()->json([], 401);
        }
    }

    public function patchSliderCompany($id)
    {
        if (Auth::check()) {
            $client = App::make('client.api');

            $inputs = Input::all();

            $method = "PATCH";

            $route = "/api/slider/" . implode(",", $inputs['id']);

            $params = [];
            foreach ($inputs['order'] as $order) {
                $params[] = [
                    "ordering" => $order
                ];
            }


            $response = $client->request($method, $route, ['form_params' => $params]);


            if ($response->getStatusCode() == 204) {
                $resp = $response->getHeader("Location");
                $resp = explode("/", $resp[0]);


                return response()->json(["id" => end($resp)], 204);
            } else {
                return response()->json([], 401);
            }
        } else {
            return response()->json([], 401);

        }

    }

    public function requestCv($id)
    {
        if (Auth::check()) {
            $client = App::make('client.api');

            $inputs[] = Input::all();

            $eventParams[] = ["status" => "REQUEST-CV", "title" => "CV requested", "comment" => "The CV has been requested for upload", "application" => ["id" => $id], "author" => ["id" => Auth::user()->id]];
            $response = $client->request("POST", "/api/event-application", ['form_params' => $eventParams]);


            if ($response->getStatusCode() == 201 || $response->getStatusCode() == 204) {
                $resp = $response->getHeader("Location");
                $resp = explode("/", $resp[0]);


                if (Input::get("comment")) {

                    $response = $client->request('GET', "/api/application/" . $id);
                    $application = json_decode($response->getBody()->getContents(), true);

                    $msg = [
                        "title" => Auth::user()->company["name"],
                        "content" => Input::get("comment")
                    ];


                    $subject = 'Feedback application ' . Auth::user()->company["name"];

                    if (App::getLocale() == "it") {
                        $subject = 'Feedback candidatura ' . Auth::user()->company["name"];
                    }

                    $emailData = [
                        "status" => "ENQUEUED",
                        "params" => $msg,
                        "subject" => $subject,
                        "sender" => [
                            "name" => Auth::user()->company["name"],
                            "email" => 'feedback@meritocracy.is'
                        ],
                        "recipient" => [
                            "name" => $application["user"]["first_name"],
                            "email" => $application["user"]["email"]
                        ],
                        "language" => strtoupper(\Illuminate\Support\Facades\App::getLocale()),
                        "cc" => [],
                        "bcc" => [],
                        "method" => "INTERN",
                        "template" => "MESSAGE_APPLICATION_MAIL",
                        "user" => [
                            "id" => $application["user"]["id"]
                        ],
                        "application" => [
                            "id" => $application['id']
                        ]
                    ];

                    try {
                        $client->request("POST", "/api/email-queue", ['form_params' => [$emailData]]);
                    } catch (\Exception $e) {

                    }
                }

                return response()->json(["id" => end($resp)], 204);
            } else {
                return response()->json([], 401);
            }
        } else {
            return response()->json([], 401);

        }

    }

    public function getApplication($applicationId)
    {
        if (Auth::check()) {
            $client = App::make('client.api');

            $response = $client->request('GET', "api/application/" . $applicationId);
            $application = json_decode($response->getBody()->getContents(), true);
            return response()->json($application, 200);
        } else {
            return response()->json([], 401);

        }
    }

    public function addCommentApplication($applicationId)
    {
        if (Auth::check()) {
            $client = App::make('client.api');


            $eventParams[] = ["status" => "COMMENT", "title" => "Comment sent", "comment" => Input::get("comment"), "application" => ["id" => $applicationId], "author" => ["id" => Auth::user()->id]];
            $response = $client->request("POST", "/api/event-application", ['form_params' => $eventParams]);


            if ($response->getStatusCode() == 201 || $response->getStatusCode() == 204) {


                $resp = $response->getHeader("Location");
                $resp = explode("/", $resp[0]);

                return response()->json(["id" => end($resp)], $response->getStatusCode());
            } else {
                return response()->json([], 401);
            }


        } else {
            return response()->json([], 401);

        }
    }

    public function getWaitingFeedbackList($id, $type)
    {

        $client = App::make('client.api');

        $response = $client->request('GET', "/api/vacancy/" . $id . "/applications/" . strtoupper($type) . "?serializerGroup=summary");
        $applications = json_decode($response->getBody()->getContents(), true);

        $ids = [];
        if (!empty($applications)) {
            $user = Auth::user();

            foreach ($applications as $i => $application) {
                $contacted = false;
                foreach ($application["events"] as $event) {

                    if ($event["status"] == "CONTACT" && $event["author"]["id"] == $user->id) {
                        $contacted = true;
                        continue;
                    }
                }

                if (!$contacted) {
                    $ids[] = $application['id'];
                }

            }


        }
        return response()->json($ids, 200);
    }


    public function updateEventApplication($type, $id)
    {


        $client = App::make('client.api');


        $inputs[] = Input::all();


        $applId = $inputs[0]['application_id'];
        if (isset($inputs[0]['application_id'])) {
            unset($inputs[0]['application_id']);
            unset($inputs[0]["_feedbackSelect"]);
            unset($inputs[0]["feedbackSave"]);

        }

        $application = null;
        $resp = [];
        if ($type == "application") {
            $response = $client->request('GET', "/api/application/" . $id . "?serializerGroup[]=summary");
            $application = json_decode($response->getBody()->getContents(), true);

            $event = end($application['events']);


            $idEvent = $event['id'];

            if ($idEvent) {

                $inputs[0]["author"] = ["id" => Auth::user()->id];


                $response = $client->request("PATCH", "/api/event-$type/" . $id, ['form_params' => $inputs]);

                $resp = $response->getHeader("Location");
                $resp = explode("/", $resp[0]);

            }
        }


        if ($type == "application" && Input::get("comment")) {


            $eventParams[] = ["status" => "CONTACT", "title" => "Feedback sent", "comment" => Input::get("comment"), "application" => ["id" => $id], "author" => ["id" => Auth::user()->id]];
            $client->request("POST", "/api/event-application", ['form_params' => $eventParams]);


            $sendTime = new \DateTime();
            $sendTime->add(new \DateInterval("PT30M"));


            $msg = [
                "title" => Auth::user()->company["name"],
                "content" => nl2br(Input::get("comment"))
            ];


            $params = [
                "templates" => "MISSING_FEEDBACK,APPLICATION_AUTOMATIC_REJECTED"
            ];
            try {
                $client->request("POST", "/api/email-queue/dequeue/application/" . $application['id'], ['form_params' => $params]);
            } catch (\Exception $e) {

            }
            $subject = 'Feedback application ' . Auth::user()->company["name"];
            if (\Illuminate\Support\Facades\App::getLocale() == "it") {
                $subject = 'Feedback candidatura ' . Auth::user()->company["name"];
            }

            $emailData = [
                "status" => "ENQUEUED",
                "params" => $msg,
                "subject" => $subject,
                "sender" => [
                    "name" => Auth::user()->company["name"],
                    "email" => 'feedback@meritocracy.is'
                ],
                "recipient" => [
                    "name" => $application["user"]["first_name"],
                    "email" => (getenv('APP_ENV') == "local") ? "lorenzo@meritocracy.is" : $application["user"]["email"]
                ],
                "language" => strtoupper(\Illuminate\Support\Facades\App::getLocale()),
                "cc" => [],
                "reply_to" => [
                    "name" => Auth::user()->first_name,
                    "email" => Auth::user()->email
                ],
                "bcc" => [],
                "send_at" => $sendTime->format("Y-m-d H:i"),
                "method" => "INTERN",
                "template" => "MESSAGE_APPLICATION_MAIL",
                "user" => [
                    "id" => $application["user"]["id"]
                ],
                "application" => [
                    "id" => $application['id']
                ]
            ];

            try {
                $client->request("POST", "/api/email-queue", ['form_params' => [$emailData]]);
            } catch (\Exception $e) {

            }
        }

        return response()->json(["id" => end($resp)], 204);


    }


    public function patchUser()
    {

        if (Auth::check()) {
            $client = App::make('client.api');

            $inputs = Input::all();


            $method = "PATCH";
            $route = "/api/user/" . $inputs['pk'];

            unset($inputs['pk']);

            $params = [];
            if (isset($inputs['value']) && !is_string($inputs['value'])) {
                foreach ($inputs['value'] as $key => $val) {
                    $params[$key] = $val;

                }
            } else {
                if (isset($inputs['value']) && is_string($inputs['value'])) {
                    $params[$inputs['name']] = $inputs['value'];
                } else {
                    $params = $inputs;

                }

            }


            if (isset($params['city_plain_text']) && !isset($params['city'])) {

                $response = $client->request('GET', "/api/city/search?key=" . $params['city_plain_text']);
                $res = $response->getBody()->getContents();
                $city = json_decode($res, true);

                if (count($city) > 0) {
                    $params['city'] = [
                        "id" => $city[0]['id']
                    ];

                } else {

                    try {
                        $myLocation = $this->reverse_geocode($params['city_plain_text']);
                        if (isset($myLocation["city"], $myLocation["country"])) {
                            $params_new = [];
                            $params_new[] = [
                                "name" => $myLocation["city"],
                                "country_code" => $myLocation["country"]

                            ];

                            $response = $client->request("POST", "/api/city", ['form_params' => $params_new]);
                            if ($response->getStatusCode() == 201 || $response->getStatusCode() == 204) {
                                $resp = $response->getHeader("Location");
                                $resp = explode("/", $resp[0]);
                                $params['city'] = [
                                    "id" => end($resp)
                                ];
                            }

                        }
                    } catch (\Exception $ee) {

                    }


                }


            }

            if (isset($params['birthdate'])) {
                $birthdate = new \DateTime($params['birthdate']);
                $params['birthdate'] = $birthdate->format("Y-m-d");
            }


            $response = $client->request($method, $route, ['form_params' => [$params]]);


            if ($response->getStatusCode() == 201 || $response->getStatusCode() == 204) {
                $resp = $response->getHeader("Location");
                $resp = explode("/", $resp[0]);

                return response()->json(["id" => end($resp)], 201);
            } else {
                return response()->json([], 401);
            }
        } else {
            return response()->json([], 401);

        }
    }


    public function createCompany()
    {

        $client = App::make('client.api');

        $inputs = Input::all();


        $client = App::make('client.api');


        $company[] = $inputs;

        $company[0]['name'] = ucwords(strtolower($company[0]['name']));
        $company[0]['is_visible'] = false;
        $company[0]['is_premium'] = false;
        $company[0]['is_system_company'] = true;

        $response = $client->request("POST", "/api/company", ['form_params' => $company]);


        if ($response->getStatusCode() == 201 || $response->getStatusCode() == 204) {
            $resp = $response->getHeader("Location");
            $resp = explode("/", $resp[0]);

            $response = $client->request('GET', "/api/company/" . end($resp));
            $company = json_decode($response->getBody()->getContents(), true);


            return response()->json(["id" => end($resp)], 201);
        }
    }


    public function createSlideCompany()
    {


        $inputs = Input::all();


        $client = App::make('client.api');


        $response = $client->request("POST", "/api/slider", ['form_params' => $inputs]);

        if ($response->getStatusCode() == 201 || $response->getStatusCode() == 204) {
            $resp = $response->getHeader("Location");
            $resp = explode("/", $resp[0]);

            $response = $client->request("GET", "/api/slider/" . end($resp));
            $slide = json_decode($response->getBody()->getContents(), true);


            $response = $client->request('GET', "/api/company/" . $inputs[0]['company']['id']);
            $company = json_decode($response->getBody()->getContents(), true);

            if (count($company['sliders']) >= 3 && $company['is_visible'] == false) {
                $msg = [
                    "title" => "",
                    "text" => $company["name"] . " ha inserito la fotogallery ed è possibile renderla visibile sul sito."
                ];
                $emailData[] = [
                    "status" => "ENQUEUED",
                    "params" => $msg,
                    "subject" => $company['name'] . " ha inserito la fotogallery",
                    "sender" => [
                        "name" => "Meritocracy",
                        "email" => 'account@meritocracy.is'
                    ],
                    "language" => strtoupper(\Illuminate\Support\Facades\App::getLocale()),
                    "cc" => [],
                    "bcc" => [],
                    "send_at" => (new \DateTime())->format("Y-m-d H:i"),
                    "recipient" => [
                        "name" => "Meritocracy Company",
                        "email" => "info@meritocracy.is"
                    ],
                    "method" => "INTERN",
                    "template" => "SIMPLE_MAIL_TEMPLATE",
                ];


                $client = App::make('client.api');

                $response = $client->request("POST", "/api/email-queue", ['form_params' => $emailData]);

            }

            return View::make('partial.slide', array("slide" => $slide));

            //return response()->json(["id" => end($resp)], 201);
        }
    }

    public function createWorkExperience()
    {
        if (Auth::check()) {
            $client = App::make('client.api');

            $inputs = Input::all();


            $user = Auth::user();


            $dal = null;
            $al = null;

            $validDataExploded = explode("/", $inputs['data_inizio']);

            if (count($validDataExploded) == 2) {


                $dal = new \DateTime(str_replace("/", "-", "01/" . $inputs['data_inizio']));

            } else {

                if (isset($validDataExploded[1]) && $validDataExploded[1] > 12) {
                    $giorno = $validDataExploded[1];
                    $validDataExploded[1] = $validDataExploded[0];
                    $validDataExploded[0] = $giorno;
                    $inputs['data_inizio'] = implode("/", $validDataExploded);
                }
                $dal = new \DateTime(str_replace("/", "-", $inputs['data_inizio']));
            }


            if (isset($inputs['lavoro_attuale']) && $inputs['lavoro_attuale'] == "on") {
                $al = new \DateTime("2100-01-01");
                $isCurrent = true;
            } else {


                $validDataExploded = explode("/", $inputs['data_fine']);

                if (count($validDataExploded) == 2) {


                    $al = new \DateTime(str_replace("/", "-", "01/" . $inputs['data_fine']));

                } else {


                    if (isset($validDataExploded[1]) && $validDataExploded[1] > 12) {
                        $giorno = $validDataExploded[1];
                        $validDataExploded[1] = $validDataExploded[0];
                        $validDataExploded[0] = $giorno;
                        $inputs['data_fine'] = implode("/", $validDataExploded);
                    }

                    $dataFine = str_replace("/", "-", $inputs['data_fine']);
                    $dataFine = explode("-", $dataFine);
                    if (isset($dataFine[1]) && $dataFine[1] > 12) {
                        $giorno = $dataFine[1];
                        $dataFine[1] = $dataFine[0];
                        $dataFine[0] = $giorno;
                    }

                    $al = new \DateTime(implode("-", $dataFine));
                }

                $isCurrent = false;
            }


            $method = "POST";
            $route = "/api/work-experience";
            if (isset($inputs['id_work_experience']) && $inputs['id_work_experience'] != "") {
                $method = "PATCH";
                $route .= "/" . $inputs['id_work_experience'];
                $params = [

                    "user" => [
                        "id" => $user->id
                    ],

                    "comment" => $inputs['comment'],
                    "role" => $inputs['role'],
                    "is_current" => $isCurrent,
                    "company_plain_text" => $inputs['nome_azienda'],
                    "city_plain_text" => $inputs['luogo_lavoro'],
                    "start_date" => $dal->format("Y-m-d"),
                    "end_date" => $al->format("Y-m-d")
                ];
            } else {
                $params = [

                    "user" => [
                        "id" => $user->id
                    ],

                    "job_function" => null,
                    "comment" => $inputs['comment'],
                    "role" => $inputs['role'],
                    "company_plain_text" => $inputs['nome_azienda'],
                    "city_plain_text" => $inputs['luogo_lavoro'],
                    "is_current" => $isCurrent,
                    "start_date" => $dal->format("Y-m-d"),
                    "end_date" => $al->format("Y-m-d")
                ];


            }


            if (isset($inputs['job_function'])) {
                $params['job_function'] = [
                    "id" => $inputs['job_function']
                ];
            }


            if (isset($inputs['industry'])) {
                $params['industry'] = [
                    "id" => $inputs['industry']
                ];
            }


            $response = $client->request($method, $route, ['form_params' => [$params]]);


            if ($response->getStatusCode() == 201 || $response->getStatusCode() == 204) {
                $resp = $response->getHeader("Location");
                $resp = explode("/", $resp[0]);


                $response = $client->request('PATCH', "/api/user/{$user->id}/update-applications");


                if (Input::get("check_email")) {
                    $params = [
                        "templates" => "USER_APPLICATION_UNCOMPLETED"
                    ];
                    $client->request("POST", "/api/email-queue/dequeue/user/" . $user->id, ['form_params' => $params]);
                }


                return response()->json(["id" => end($resp), "azienda_id" => $inputs['azienda_id']], 201);
            } else {
                return response()->json([], 401);
            }
        } else {
            return response()->json([], 401);

        }
    }


    public function createEducation()
    {
        if (Auth::check()) {
            $client = App::make('client.api');

            $inputs = Input::all();

            if (!isset($inputs['school_id']) || $inputs['school_id'] == "") {

                $type = "UNIVERSITY";

                $company[] = [
                    "name" => $inputs['school'],
                    "type" => $type
                ];

                $response = $client->request("POST", "/api/school", ['form_params' => $company]);


                if ($response->getStatusCode() == 201 || $response->getStatusCode() == 204) {
                    $resp = $response->getHeader("Location");
                    $resp = explode("/", $resp[0]);

                    $inputs['school_id'] = end($resp);
                }
            }

            $user = Auth::user();

            $validDataExploded = explode("/", $inputs['data_inizio_education']);


            if (count($validDataExploded) == 2) {
                $dal = new \DateTime(str_replace("/", "-", "01/" . $inputs['data_inizio_education']));

            } else {
                $dal = new \DateTime(str_replace("/", "-", $inputs['data_inizio_education']));
            }

            if (isset($inputs['studio_attuale']) && $inputs['studio_attuale'] == "on") {
                $al = new \DateTime("2100-01-01");
                $isCurrent = true;
            } else {
                $validDataExploded = explode("/", $inputs['data_fine_education']);
                if (count($validDataExploded) == 2) {
                    $al = new \DateTime(str_replace("/", "-", "01/" . $inputs['data_fine_education']));

                } else {
                    $al = new \DateTime(str_replace("/", "-", $inputs['data_fine_education']));

                }
                $isCurrent = false;
            }

            $params = [
                "school" => [
                    "id" => $inputs['school_id']
                ],
                "school_plain_text" => $inputs['school'],
                "user" => [
                    "id" => $user->id
                ],

                "comment" => (isset($inputs['titolo_studio'])) ? $inputs['titolo_studio'] : "",
                "is_current" => $isCurrent,
                "start_date" => $dal->format("Y-m-d"),
                "end_date" => $al->format("Y-m-d"),
                "grade" => (!$isCurrent && isset($inputs['grade_min']) && $inputs['grade_max'] > $inputs['grade_min']) ? $inputs['grade_min'] . "/" . $inputs['grade_max'] : null
            ];


            if (isset($inputs['education_id']) && $inputs['education_id'] != "") {
                $params["study_field"] = [
                    "id" => $inputs['education_id']
                ];
            }

            $method = "POST";
            $route = "/api/education";
            if (isset($inputs['id_education']) && $inputs['id_education'] != "") {
                $method = "PATCH";
                $route .= "/" . $inputs['id_education'];
            }

            $response = $client->request($method, $route, ['form_params' => [$params]]);


            if ($response->getStatusCode() == 201 || $response->getStatusCode() == 204) {


                if (Input::get("check_email")) {
                    $params = [
                        "templates" => "USER_APPLICATION_UNCOMPLETED"
                    ];
                    $client->request("POST", "/api/email-queue/dequeue/user/" . $user->id, ['form_params' => $params]);
                }


                $resp = $response->getHeader("Location");
                $resp = explode("/", $resp[0]);
                $response = $client->request('PATCH', "/api/user/{$user->id}/update-applications");

                return response()->json(["id" => end($resp), "school_id" => $inputs['school_id']], 201);
            } else {
                return response()->json([], 401);
            }
        } else {
            return response()->json([], 401);

        }
    }


    public function updateEducation()
    {
        if (Auth::check()) {
            $client = App::make('client.api');

            $inputs = Input::all();


            $method = "PATCH";
            $route = "/api/education/" . $inputs['id_education'];


            if (isset($inputs['start_date'])) {
                $validDataExploded = explode("/", $inputs['start_date']);

                if (count($validDataExploded) == 2) {
                    $dal = new \DateTime(str_replace("/", "-", "01/" . $inputs['start_date']));

                } else {
                    $dal = new \DateTime(str_replace("/", "-", $inputs['start_date']));
                }

                $inputs['start_date'] = $dal->format("Y-m-d");
            }
            $isCurrent = false;
            if (isset($inputs['end_date'])) {

                if (isset($inputs['studio_attuale']) && $inputs['studio_attuale'] == "on") {
                    $al = new \DateTime("2100-01-01");
                    $isCurrent = true;
                } else {


                    $validDataExploded = explode("/", $inputs['end_date']);

                    if (count($validDataExploded) == 2) {
                        $al = new \DateTime(str_replace("/", "-", "01/" . $inputs['end_date']));

                    } else {
                        $al = new \DateTime(str_replace("/", "-", $inputs['end_date']));
                    }

                    $isCurrent = false;
                }

                $inputs['end_date'] = $al->format("Y-m-d");

                $inputs['is_current'] = $isCurrent;

            }

            $inputs["grade"] = (!$isCurrent && isset($inputs['grade_min']) && $inputs['grade_max'] > $inputs['grade_min']) ? $inputs['grade_min'] . "/" . $inputs['grade_max'] : null;


            unset($inputs['grade_min']);
            unset($inputs['grade_max']);
            unset($inputs['id_education']);
            unset($inputs['studio_attuale']);


            $response = $client->request($method, $route, ['form_params' => [$inputs]]);


            if ($response->getStatusCode() == 201 || $response->getStatusCode() == 204) {
                $resp = $response->getHeader("Location");
                $resp = explode("/", $resp[0]);

                return response()->json(["id" => end($resp)], 201);
            } else {
                return response()->json([], 401);
            }
        } else {
            return response()->json([], 401);

        }
    }


    public function createLanguageUser()
    {
        if (Auth::check()) {
            $client = App::make('client.api');

            $inputs = Input::all();


            $user = Auth::user();

            $params = [];

            foreach ($inputs['lingua'] as $key => $value) {
                if (isset($inputs['lingua_id'][$key]) && $inputs['lingua_id'][$key] != "") {
                    $params[] = [
                        "system_language" => [
                            "id" => $inputs['lingua_id'][$key]
                        ],
                        "user" => [
                            "id" => $user->id
                        ],
                        "grade_read" => $inputs['lettura'][$key],
                        "grade_write" => $inputs['scrittura'][$key],
                        "grade_speak" => $inputs['dialogo'][$key],
                        "type=" => "USER"
                    ];
                }

            }

            if (!empty($params)) {
                $method = "POST";
                $route = "/api/language-user";

                $response = $client->request($method, $route, ['form_params' => $params]);


                if ($response->getStatusCode() == 201 || $response->getStatusCode() == 204) {

                    if (Input::get("check_email")) {
                        $params = [
                            "templates" => "USER_APPLICATION_UNCOMPLETED"
                        ];
                        $client->request("POST", "/api/email-queue/dequeue/user/" . $user->id, ['form_params' => $params]);
                    }

                    $resp = $response->getHeader("Location");
                    $resp = explode("/", $resp[0]);
                    $response = $client->request('PATCH', "/api/user/{$user->id}/update-applications");
                    return response()->json(["id" => end($resp)], 201);
                } else {
                    return response()->json([], 401);
                }
            }

        } else {
            return response()->json([], 401);

        }
    }


    public function createAttachment()
    {
        $client = App::make('client.api');

        $user = Auth::user();
        $now = new \DateTime();
        $nameFile = $user->first_name . "_" . $user->last_name . "_" . $now->format("dmY");

        $params = Input::all();
        $params['name'] = $nameFile;
        $response = $client->request('POST', "/api/attachment", ['form_params' => [$params]]);


        if ($response->getStatusCode() == 201) {
            $resp = $response->getHeader("Location");
            $resp = explode("/", $resp[0]);


            return response()->json(["id" => end($resp)], 201);
        } else {


        }

    }


    public function updateApplication($id)
    {
        if (Auth::check()) {
            $client = App::make('client.api');

            $params[] = Input::all();
            $method = "PATCH";
            $route = "/api/application/" . $id;


            $response = $client->request($method, $route, ['form_params' => $params]);

            if ($response->getStatusCode() == 204) {
                $resp = $response->getHeader("Location");
                $resp = explode("/", $resp[0]);


                if (Input::get("active")) {


                    $params = [
                        "templates" => "USER_APPLICATION_UNCOMPLETED"
                    ];
                    $client->request("POST", "/api/email-queue/dequeue/user/" . Auth::user()->id, ['form_params' => $params]);


                    $response = $client->request('GET', "/api/application/" . $id);
                    $application = json_decode($response->getBody()->getContents(), true);

                    $vacancy = $application['vacancy'];

                    $msg = [
                        "company" => $vacancy["company"]["name"],
                        "vacancy" => $vacancy["name"],
                        "name" => Auth::user()->first_name,
                    ];


                    $subject = "Your application for " . $vacancy["name"] . " has been submitted successfully";

                    if (\Illuminate\Support\Facades\App::getLocale() == "it") {
                        $subject = "Candidatura per " . $vacancy["name"] . " inviata correttamente";
                    }


                    //EMAIL NOTIFICA APPLICATION
                    $emailData[] = [
                        "status" => "ENQUEUED",
                        "params" => $msg,
                        "subject" => $subject,
                        "sender" => [
                            "name" => "Meritocracy",
                            "email" => 'account@meritocracy.is'
                        ],
                        "recipient" => [
                            "name" => Auth::user()->first_name,
                            "email" => Auth::user()->email
                        ],
                        "language" => strtoupper(\Illuminate\Support\Facades\App::getLocale()),
                        "cc" => [],
                        "bcc" => [],
                        "method" => "INTERN",
                        "template" => "USER_APPLICATION_COMPLETED",
                        "user" => [
                            "id" => \Illuminate\Support\Facades\Auth::user()->id
                        ],
                        "application" => [
                            "id" => $id
                        ]
                    ];
                    try {
                        $client->request("POST", "/api/email-queue", ['form_params' => $emailData]);
                    } catch (\Exception $e) {

                    }

                }


                return response()->json(["id" => end($resp)], 201);
            } else {
                return response()->json([], 401);
            }
        } else {
            return response()->json([], 401);

        }
    }


    public function updateWorkExperience()
    {
        if (Auth::check()) {
            $client = App::make('client.api');

            $inputs = Input::all();


            $method = "PATCH";
            $route = "/api/work-experience/" . $inputs['id_work_experience'];


            if (isset($inputs['start_date'])) {
                $validDataExploded = explode("/", $inputs['start_date']);

                if (count($validDataExploded) == 2) {
                    $dal = new \DateTime(str_replace("/", "-", "01/" . $inputs['start_date']));

                } else {
                    $dal = new \DateTime(str_replace("/", "-", $inputs['start_date']));
                }

                $inputs['start_date'] = $dal->format("Y-m-d");
            }


            if (isset($inputs['lavoro_attuale']) && $inputs['lavoro_attuale'] == "on") {
                $al = new \DateTime("2100-01-01");
                $isCurrent = true;
            } else {


                $validDataExploded = explode("/", $inputs['end_date']);

                if (count($validDataExploded) == 2) {
                    $al = new \DateTime(str_replace("/", "-", "01/" . $inputs['end_date']));

                } else {
                    $al = new \DateTime(str_replace("/", "-", $inputs['end_date']));
                }

                $isCurrent = false;
            }

            $inputs['end_date'] = $al->format("Y-m-d");

            $inputs['is_current'] = $isCurrent;


            unset($inputs['id_work_experience']);
            unset($inputs['lavoro_attuale']);


            $response = $client->request($method, $route, ['form_params' => [$inputs]]);


            if ($response->getStatusCode() == 201 || $response->getStatusCode() == 204) {
                $resp = $response->getHeader("Location");
                $resp = explode("/", $resp[0]);

                return response()->json(["id" => end($resp)], 201);
            } else {
                return response()->json([], 401);
            }
        } else {
            return response()->json([], 401);

        }
    }


    public function createContactRequest($type)
    {
        $type = strtolower($type);

        $client = App::make('client.api');

        $url = "/api/contact-request";

        $subject = "Nuova richiesta di contatto";


        if (Input::get("request") == null) {
            $message = "Hai ricevuto una nuova richiesta di contatto azienda, il contatto è stato aggiunto al crm correttamente.";
        } else {
            $message = Input::get("request");
        };

        $lang = (Input::get("lang") != null) ? Input::get("lang") : 'IT';


        $referUrl = Session::get('refererUrl');


        $agent = new \Jenssegers\Agent\Agent();

        $defaultSource = 1;
        if ($agent->isMobile()) {
            $defaultSource = 2;
        }

        $urlRefer = $referUrl;


        $params = [
            "message" => $message,
            "contact" => Input::get("phone"),
            "type" => strtoupper($type),
            "name" => Input::get("name"),
            "company_name" => Input::get("company"),
            "subject" => $subject,
            "language" => $lang,
            "referer_url" => $urlRefer,
            "source" => [
                "id" => (Input::get("source") != null) ? Input::get("source") : $defaultSource
            ]
        ];
        if (Input::get("name") != "" && Input::get("phone") != "") {

            $response = $client->request('POST', $url, ['form_params' => [$params]]);

            if ($response->getStatusCode() == 201) {


                $resp = $response->getHeader("Location");
                $resp = explode("/", $resp[0]);
                $meritocracyId = end($resp);


                $client = new \GuzzleHttp\Client(["base_uri" => "https://app.onepagecrm.com/api/v3/"]);


                $loginOnePage = [
                    "login" => env('API_ONEPAGECRM_USERNAME_' . strtoupper($lang)),
                    "password" => env('API_ONEPAGECRM_PASSWORD_' . strtoupper($lang))
                ];


                $response = $client->request('POST', "login.json", ['form_params' => $loginOnePage]);
                $signUp = $response->getBody()->getContents();
                $signUp = json_decode($signUp, true);


                $key = base64_decode($signUp['data']['auth_key']);
                $uid = $signUp['data']['user_id'];

                $defaultSource = "Desktop";
                if ($agent->isMobile()) {
                    $defaultSource = "Mobile";
                }

                $message = "Sorgente: {$defaultSource}, Url Provenienza: {$urlRefer}, richiesta di chiamata effettuata dal sito";
                if (Input::get("request") != null) {
                    $message .= " " . Input::get("request");
                }


                if (strtolower($type) == "company") {

                    $contact_data = array(
                        'first_name' => Input::get("name"),
                        'last_name' => '',
                        'company_name' => Input::get("company"),
                        'tags' => ["Marketing" . strtoupper($lang), "Assistenza" . strtoupper($lang), $urlRefer, $defaultSource],
                        'type' => 'company',
                        'background' => $message
                    );


                    if (filter_var(Input::get("phone"), FILTER_VALIDATE_EMAIL)) {
                        $contact_data["emails"] = [
                            array('type' => 'work', 'value' => Input::get("phone")),
                        ];
                    } else {
                        $contact_data["phones"] = [
                            array('type' => 'work', 'value' => Input::get("phone")),
                        ];
                    }

                }


                $params["crm_id"] = "Non inserito";
                $params["meritocracy_id"] = $meritocracyId;
                $params["text"] = $message;


                $new_contact = $this->make_api_call('contacts.json', 'POST', $contact_data, $uid, $key);

                if ($new_contact) {
                    $cid = $new_contact->data->contact->id;

                    $params["crm_id"] = $cid;

                }

                if (Input::get("assistance")) {


                    $emailData = [
                        "status" => "ENQUEUED",
                        "params" => $params,
                        "subject" => Input::get("company") . " needs assitance to sign up",
                        "sender" => [
                            "name" => "Meritocracy",
                            "email" => 'info@meritocracy.is'
                        ],
                        "cc" => [],
                        "bcc" => [],
                        "language" => strtoupper(\Illuminate\Support\Facades\App::getLocale()),
                        "recipient" => [
                            "name" => "Meritocracy",
                            "email" => 'company-registration@meritocracy.is'
                        ],
                        "method" => "INTERN",
                        "template" => "REQUEST_CONTACT_MAIL",
                    ];


                } else {
                    $emailData = [
                        "status" => "ENQUEUED",
                        "params" => $params,
                        "subject" => Input::get("company") . " requests information",
                        "sender" => [
                            "name" => "Meritocracy",
                            "email" => 'info@meritocracy.is'
                        ],
                        "cc" => [],
                        "bcc" => [],
                        "language" => strtoupper(\Illuminate\Support\Facades\App::getLocale()),
                        "recipient" => [
                            "name" => "Meritocracy",
                            "email" => 'company-request@meritocracy.is'
                        ],
                        "method" => "INTERN",
                        "template" => "REQUEST_CONTACT_MAIL",
                    ];
                }

                $client = App::make('client.api');

                try {
                    $response = $client->request("POST", "/api/email-queue", ['form_params' => [$emailData]]);

                } catch (\Exception $e) {
                }


                return response()->json(["id" => $meritocracyId, "message" => trans('common.request_success')], 201);
            }


        }

        return response()->json(["message" => trans('common.request_error')], 401);


    }

    public function registerUserOrCompanyUser($type)
    {
        $client = App::make('client.api');

        $agent = new \Jenssegers\Agent\Agent();
        $source = 1;
        if ($agent->isMobile()) {
            $source = 2;
        }


        Auth::logout();
        $cookie = Cookie::forget('logged');


        $referUrl = Session::get('refererUrl');


        $urlRefer = $referUrl;


        $data = Input::all();
        if (isset($data['data'])) {
            $data = $data['data'];
        }
        if (!isset($data['password']) || strlen($data['password']) <= 5) {
            return response()->json(["message" => trans('common.password_6')], 400);
        } else {
            $password = $data['password'];
        }


        if ($type == "company") {


            $params[] = [
                "first_name" => ucwords(strtolower($data["first_name"])),
                "last_name" => ucwords(strtolower($data["last_name"])),
                "telephone" => (isset($data['telephone'])) ? $data['telephone'] : "",
                "mobile_phone" => (isset($data['mobile'])) ? $data['mobile'] : "",
                "email" => $data['email'],
                "address" => "",
                "status" => 1,
                "gender" => null,
                "type" => strtoupper($type),
                "birthdate" => null,
                "password" => Hash::make($password),
                "city_plain_text" => "",
                "linkedin_id" => (isset($data['linkedin_id'])) ? $data['linkedin_id'] : "",
                "facebook_id" => (isset($data['facebook_id'])) ? $data['facebook_id'] : "",
                "source" => [
                    "id" => $source
                ],
                "referer_url" => $urlRefer
            ];
        }

        if ($type == "user") {


            if (!isset($data['email']) || strlen($data['email']) <= 0 || filter_var($data['email'], FILTER_VALIDATE_EMAIL) == false) {
                return response()->json(["message" => trans('common.not_valid_mail')], 400);
            }
            if (!isset($data['name']) || strlen($data['name']) <= 0 || !isset($data['familyName']) || strlen($data['familyName']) <= 0) {
                return response()->json(["message" => trans('common.not_valid_name_surname')], 400);
            }


            $dataNascita = (isset($data['config']['profile']['birthdate'])) ? $data['config']['profile']['birthdate'] : null;

            $dataNascita = new \DateTime($dataNascita);


            $params[] = [
                "first_name" => (ucwords(strtolower($data["name"])) != "") ? ucwords(strtolower($data["name"])) : "Name not provided",
                "last_name" => (ucwords(strtolower($data["familyName"])) != "") ? ucwords(strtolower($data["familyName"])) : "",
                "telephone" => (isset($data['config']['profile']['phone'])) ? $data['config']['profile']['phone'] : "",
                "mobile_phone" => (isset($data['config']['profile']['mobile'])) ? $data['config']['profile']['mobile'] : "",
                "email" => $data['email'],
                "address" => "",
                "status" => 1,
                "gender" => null,
                "linkedin_id" => (isset($data['linkedin_id'])) ? $data['linkedin_id'] : "",
                "facebook_id" => (isset($data['facebook_id'])) ? $data['facebook_id'] : "",
                "type" => strtoupper($type),
                "birthdate" => (isset($data['config']['profile']['birthdate'])) ? $dataNascita->format("Y-m-d") : null,
                "password" => Hash::make($password),
                "city_plain_text" => "",
                "source" => [
                    "id" => $source
                ],
                "referer_url" => $urlRefer
            ];


        }

        $socialRegistration = 0;
        if (isset($data['linkedin_id']) || isset($data['facebook_id'])) {
            $socialRegistration = 1;
        }


        $response = null;
        try {
            $response = $client->request('POST', "/api/user", ['form_params' => $params]);


            if ($response->getStatusCode() == 201) {


                $resp = $response->getHeader("Location");
                $resp = explode("/", $resp[0]);
                $idUser = end($resp);


                if ($idUser) {
                    if (Input::get('cvUrl') && Input::get('cvUrl') != "") {


                        $cv = Input::get('cvUrl');

                        $cvUrl = "";
                        $cvName = "";

                        $now = new \DateTime();

                        $cvUrl = Input::get("cvUrl");
                        $cvName = $params[0]['first_name'] . "_" . $params[0]['last_name'] . "_" . $now->format("dmY");

                        $attach[] = [
                            "comment" => "CV uploaded during registration",
                            "type" => "CV",
                            "name" => $cvName,
                            "link" => $cvUrl,
                            "user" => [
                                "id" => $idUser]
                        ];
                        $response = $client->request('POST', "/api/attachment", ['form_params' => $attach]);
                        $resp = $response->getHeader("Location");
                        $idCv = explode("/", $resp[0]);
                        $idCv = end($idCv);

                    }

                    $response = Auth::attempt(['email' => $data['email'], 'password' => $password]);

                    if ($type == "user") {
                        try {
                            $msg = [
                                "title" => reset($params)['first_name'],
                                "email" => reset($params)['email']
                            ];

                            $template = $socialRegistration == 0 ? "REGISTRATION_MAIL" : "REGISTRATION_MAIL_SOCIAL";
                            $subject = reset($params)['first_name'] . ", registration completed";
                            if (\Illuminate\Support\Facades\App::getLocale() == "it") {
                                $subject = reset($params)['first_name'] . ", registrazione completata";
                            }

                            $emailData[] = [
                                "status" => "ENQUEUED",
                                "params" => $msg,
                                "subject" => $subject,
                                "sender" => [
                                    "name" => "Meritocracy",
                                    "email" => 'account@meritocracy.is'
                                ],
                                "language" => strtoupper(\Illuminate\Support\Facades\App::getLocale()),
                                "cc" => [],
                                "bcc" => [],
                                "recipient" => [
                                    "name" => reset($params)['first_name'],
                                    "email" => reset($params)['email']
                                ],
                                "user" => [
                                    "id" => $idUser
                                ],
                                "method" => "INTERN",
                                "template" => $template,
                            ];


                            $client = App::make('client.api');

                            try {
                                $response = $client->request("POST", "/api/email-queue", ['form_params' => $emailData]);

                            } catch (\Exception $e) {
                            }


                        } catch (\Exception $e) {
                            var_dump($e);
                        }
                    }

                    return response()->json(["id" => $idUser], 201);

                }


            }
        } catch (\Exception $e) {
            if ($e->getCode() == 409) {
                return response()->json(["message" => trans('common.user_exist')], 409);

            }
        }


        return response()->json(["message" => "Unable to continue because a server error occurred: Please contact us at info@meritocracy.is"], 500);

    }


    public function deleteEntity($type, $id)
    {

        $client = App::make('client.api');
        $response = null;
        if ($type != "attachment") {
            try {
                $response = $client->request('DELETE', "/api/" . $type . "/" . $id);
            } catch (\Exception $e) {

            }
        } else {

            $inputs[] = [
                "active" => false
            ];
            try {
                $response = $client->request('PATCH', "/api/" . $type . "/" . $id, ['form_params' => $inputs]);
            } catch (\Exception $e) {

            }


        }


        return response()->json([], 200);

    }


    public function deleteCommentEvent($id)
    {
        $client = App::make('client.api');

        $response = $client->request('DELETE', "/api/event-application/$id");

        if ($response->getStatusCode() == 500) {
            return response()->json([], 500);
        } else {
            return response()->json([], 200);
        }

    }


    public function deleteApplicationFromCategory($id)
    {
        $client = App::make('client.api');
        $response = $client->request('DELETE', "/api/category-application/$id");
        return response()->json([], $response->getStatusCode());
    }


    public function addMemberCompany($id)
    {
        if (Auth::check()) {
            $client = App::make('client.api');

            $inputs = Input::all();

            $response = $client->request("POST", "/api/member-team", ['form_params' => [$inputs]]);


            if ($response->getStatusCode() == 201 || $response->getStatusCode() == 204) {

                $resp = $response->getHeader("Location");
                $resp = explode("/", $resp[0]);

                return response()->json(["id" => end($resp)], 201);
            } else {
                return response()->json([], 401);
            }
        } else {
            return response()->json([], 401);

        }
    }

    public function addBenefit($id)
    {
        if (Auth::check()) {
            $client = App::make('client.api');

            $inputs[] = [
                "name" => Input::get("name"),
                "icon" => Input::get("icon"),
                "language" => App::getLocale()
            ];


            $benefitPost = $this->make_post("/api/benefit", $inputs);
            $benefitId = $benefitPost["success"] == 1 ? $benefitPost["id"] : null;

            if ($benefitId != null) {
                $inputs = null;
                $inputs[] = [
                    "company" => ["id" => Auth::user()->company['id']],
                    "benefit" => ["id" => $benefitId]
                ];

                $benefitPost = $this->make_post("/api/company-has-benefit", $inputs);

                if ($benefitPost["success"] == 1) {
                    return response()->json(["id" => $benefitPost["id"]], 201);
                } else {
                    return response()->json(["message" => "Unable to add company has benefit"], $benefitPost["statusCode"]);
                }
            } else {
                return response()->json(["message" => "Unable to add benefit"], $benefitPost["statusCode"]);
            }


        } else {
            return response()->json([], 401);

        }
    }

    public function addVideo($id)
    {
        if (Auth::check()) {
            $client = App::make('client.api');

            $inputs = Input::all();

            $inputs['company']['id'] = $id;


            $response = $client->request("POST", "/api/video", ['form_params' => [$inputs]]);

            if ($response->getStatusCode() == 201 || $response->getStatusCode() == 204) {

                $resp = $response->getHeader("Location");
                $resp = explode("/", $resp[0]);

                return response()->json(["id" => end($resp)], 201);
            } else {
                return response()->json([], 401);
            }
        } else {
            return response()->json([], 401);

        }
    }

    public function updateMemberCompany($id)
    {
        if (Auth::check()) {
            $client = App::make('client.api');

            $inputs = Input::all();

            $response = $client->request("PATCH", "/api/member-team/" . $id, ['form_params' => [$inputs]]);


            if ($response->getStatusCode() == 201 || $response->getStatusCode() == 204) {

                $resp = $response->getHeader("Location");
                $resp = explode("/", $resp[0]);

                return response()->json(["id" => end($resp)], 201);
            } else {
                return response()->json([], 401);
            }
        } else {
            return response()->json([], 401);

        }
    }

    public function updateVideo($id)
    {
        if (Auth::check()) {
            $client = App::make('client.api');

            $inputs = Input::all();

            $response = $client->request("PATCH", "/api/video/" . $id, ['form_params' => [$inputs]]);


            if ($response->getStatusCode() == 201 || $response->getStatusCode() == 204) {

                $resp = $response->getHeader("Location");
                $resp = explode("/", $resp[0]);

                return response()->json(["id" => end($resp)], 201);
            } else {
                return response()->json([], 401);
            }
        } else {
            return response()->json([], 401);

        }
    }

    public function addEvent($type)
    {
        if (Auth::check() && \Illuminate\Support\Facades\Auth::user()->type == "COMPANY") {


            $client = App::make('client.api');

            $inputs = Input::all();

            $method = "POST";
            $route = "/api/event-" . $type;

            $params[] = $inputs;

            $response = $client->request($method, $route, ['form_params' => $params]);


            if ($response->getStatusCode() == 201 || $response->getStatusCode() == 204) {


                if ($type == "application") {
                    $idApplication = $inputs['application']['id'];
                    $method = "PATCH";
                    $route = "/api/application/" . $idApplication;

                    $paramsPatch[] = [
                        "status" => $inputs['status']
                    ];
                    //     $client->request($method, $route, ['form_params' => $paramsPatch]);

                }

                $resp = $response->getHeader("Location");
                $resp = explode("/", $resp[0]);

                return response()->json(["id" => end($resp)], 201);
            } else {
                return response()->json([], 401);
            }
        } else {
            return response()->json([], 201);

        }
    }


}
