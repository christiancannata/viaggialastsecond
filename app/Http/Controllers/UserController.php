<?php

namespace Meritocracy\Http\Controllers;

use Cache;
use Illuminate\Support\Facades\App;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{


    /**
     * Instantiate a new UserController instance.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['setOneSignalPushId']]);

    }


    public function deleteUser($id)
    {
        $client = App::make('client.api');


        $method = "PATCH";
        $route = "/api/user/" . $id;

        $response = $client->request($method, $route, ['form_params' => [["status" => 0]]]);


        if ($response->getStatusCode() == 201 || $response->getStatusCode() == 204) {


            $resp = $response->getHeader("Location");
            $resp = explode("/", $resp[0]);

            $method = "GET";
            $route = "/api/user/" . $id;

            $resp = $client->request($method, $route);
            $user = $resp->getBody()->getContents();

            $user = json_decode($user, true);

            $sendTime = new \DateTime();


            $subject = str_replace("%c", $user['first_name'], trans('common.disabled_account_subject'));
            $msg = [
                "title" => $subject,
                "text" => str_replace("%c", $user['first_name'], trans('common.disabled_account_msg'))
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
                "send_at" => $sendTime->format("Y-m-d H:i"),
                "recipient" => [
                    "name" => $user['first_name'],
                    "email" => $user['email']
                ],
                "user" => [
                    "id" => $user['id']
                ],
                "method" => "INTERN",
                "template" => "SIMPLE_MAIL_TEMPLATE",
            ];


            $client = App::make('client.api');

            $response = $client->request("POST", "/api/email-queue", ['form_params' => $emailData]);


            $method = "POST";
            $route = "/api/event-user";

            $eventParams[] = [
                "user" => [
                    "id" => $user['id']
                ],
                "author" => [
                    "id" => $user['id']
                ],
                "status" => "DELETE",
                "title" => "Utente eliminato",
                "comment" => "Utente eliminato"
            ];


            $response = $client->request($method, $route, ['form_params' => $eventParams]);


            return response()->json(["id" => end($resp)], 204);
        } else {
            return response()->json([], 500);
        }

    }


    public function getUser()
    {
        if (Auth::check()) {
            return redirect('/user/dashboard');
        } else {
            return redirect('/login');
        }

    }


    public function getUserDashboard()
    {
        $id = Auth::id();
        if ($id) {

            $user = Auth::user();

            if (\Illuminate\Support\Facades\Auth::user()->type == "ADMINISTRATOR") {
                return redirect('/admin/dashboard');
            }

            if ($user->type == "COMPANY" || $user->type == "ANALYTICS") {
                return redirect('/hr');
            }
            return redirect('/user/profile');

        } else {
            return redirect('/');

        }
        $client = App::make('client.api');

        $response = $client->request('GET', "/api/user/" . $id);
        $user = json_decode($response->getBody()->getContents(), true);


        return View::make('admin.dashboard', array("user" => $user, "route" => "dashboard", "title" => "Dashboard", "description" => ""));

    }

    public function getUserActivities()
    {
        $user = Auth::user();

        $client = App::make('client.api');

        $response = $client->request('GET', "/api/user/" . $user->id . "/activities");
        $user = json_decode($response->getBody()->getContents(), true);


        return View::make('admin.dashboard', array("events" => $user, "route" => "activities", "title" => "Dashboard", "description" => ""));

    }


    public function getUserSettings()
    {
        $id = Auth::id();

        $client = App::make('client.api');

        $response = $client->request('GET', "/api/user/" . $id);
        $user = json_decode($response->getBody()->getContents(), true);

        if (Input::get("companyId")) {
            $response = $client->request('GET', "/api/company/" . Input::get("companyId") . "?serializerGroup[]=auth");
            $company = json_decode($response->getBody()->getContents(), true);
            Auth::user()->company = $company;

        }
        return View::make('admin.settings', array("user" => $user, "route" => "settings", "title" => "Dashboard", "description" => ""));

    }


    public function getUserApplications()
    {
        $id = Auth::id();

        $client = App::make('client.api');

        $response = $client->request('GET', "/api/user/" . $id);
        $user = json_decode($response->getBody()->getContents(), true);


        return View::make('admin.applications', array("user" => $user, "applications" => $user['applications'], "route" => "applications", "title" => "Applications", "description" => ""));

    }

    public function getUserAttachments()
    {
        $id = Auth::id();

        $client = App::make('client.api');

        $response = $client->request('GET', "/api/user/" . $id);
        $user = json_decode($response->getBody()->getContents(), true);

        return View::make('admin.attachments', array("user" => $user, "attachments" => $user['attachments'], "route" => "attachments", "title" => "Your Attachments", "description" => ""));

    }


    public function getUserApplicationDetail($appId)
    {

        if (Auth::check()) {

            $id = Auth::id();
            $user = Auth::user();

            $client = App::make('client.api');

            $response = $client->request('GET', "/api/application/" . $appId);
            $application = json_decode($response->getBody()->getContents(), true);

            if ($application['user']['id'] == $user->id) {
                return View::make('admin.application-detail', array("user" => $application['user'], "application" => $application, "route" => "application", "title" => "Le tue Candidature", "description" => ""));

            } else {
                die("Jjj");
            }
        } else {
            return redirect('/login');

        }

    }
    public function getLanguages()
    {
        $client = App::make('client.api');

        $response = $client->request('GET', "/api/user/" . Auth::id());
        $user = json_decode($response->getBody()->getContents(), true);
        usort($user['educations'], [$this, 'date_compare']);
        
      
        return View::make('template.profile-languages', ["languages" => $user["languages"]]);


    }

    public function getEducation()
    {
        $client = App::make('client.api');

        $response = $client->request('GET', "/api/user/" . Auth::id());
        $user = json_decode($response->getBody()->getContents(), true);
        usort($user['educations'], [$this, 'date_compare']);

        
        if (!Cache::has("systemDegree")) {
            $response = $client->request('GET', "/api/degree");
            $res = json_decode($response->getBody()->getContents(), true);
            $degrees = [];
            foreach ($res as $degree) {
                if (App::getLocale() == "it" && $degree['is_visible_it']) {
                    $degrees[] = [
                        "id" => $degree['id'],
                        "name" => $degree['name']
                    ];
                }

                if (App::getLocale() != "it" && $degree['is_visible_en']) {
                    $degrees[] = [
                        "id" => $degree['id'],
                        "name" => $degree['name']
                    ];
                }

            }
            usort($degrees, [$this, 'compareByName']);
            Cache::add("systemDegree", $degrees, 60);

        } else {
            $degrees = Cache::get("systemDegree");
        }

        if (!Cache::has("systemStudyFields")) {
            $response = $client->request('GET', "/api/tags/category/STUDYFIELD");
            $res = json_decode($response->getBody()->getContents(), true);

            $studyFields = [];
            foreach ($res as $studyField) {
                if (App::getLocale() == "it") {
                    $studyFields[] = [
                        "id" => $studyField['id'],
                        "name" => $studyField['name_it']
                    ];
                } else {
                    $studyFields[] = [
                        "id" => $studyField['id'],
                        "name" => $studyField['name']
                    ];
                }
            }
            usort($studyFields, [$this, 'compareByName']);
            Cache::add("systemStudyFields", $studyFields, 60);

        } else {
            $studyFields = Cache::get("systemStudyFields");
        }


        usort($degrees, [$this, 'compareByName']);
        return View::make('template.profile-education', ["degrees" => $degrees, "studyFields" => $studyFields, "education" => $user["educations"]]);


    }

    public function getWorkExperiences()
    {
        $client = App::make('client.api');

        $response = $client->request('GET', "/api/user/" . Auth::id());
        $user = json_decode($response->getBody()->getContents(), true);


        if (!Cache::has("systemJobFunctions")) {
            $response = $client->request('GET', "/api/tags/category/JOBFUNCTION");
            $res = json_decode($response->getBody()->getContents(), true);
            $jobFunctions = [];
            foreach ($res as $industry) {
                if (App::getLocale() == "it") {
                    $jobFunctions[] = [
                        "id" => $industry['id'],
                        "name" => $industry['name_it']
                    ];
                } else {
                    $jobFunctions[] = [
                        "id" => $industry['id'],
                        "name" => $industry['name']
                    ];
                }
            }
            usort($jobFunctions, [$this, 'compareByName']);
            Cache::add("systemJobFunctions", $jobFunctions, 60);

        } else {
            $jobFunctions = Cache::get("systemJobFunctions");
        }

        if (!Cache::has("systemIndustries")) {
            $response = $client->request('GET', "/api/tags/category/INDUSTRY");
            $res = json_decode($response->getBody()->getContents(), true);
            $industries = [];
            foreach ($res as $industry) {
                if (App::getLocale() == "it") {
                    $industries[] = [
                        "id" => $industry['id'],
                        "name" => $industry['name_it']
                    ];
                } else {
                    $industries[] = [
                        "id" => $industry['id'],
                        "name" => $industry['name']
                    ];
                }
            }
            usort($industries, [$this, 'compareByName']);
            Cache::add("systemIndustries", $industries, 60);

        } else {
            $industries = Cache::get("systemIndustries");
        }

        usort($user['work_experiences'], [$this, 'date_compare']);
        return View::make('template.profile-work-experiences', ["industries" => $industries, "jobFunctions" => $jobFunctions, "workExperiences" => $user["work_experiences"]]);

    }

    public function getUserProfile()
    {
        $id = Auth::id();

        $client = App::make('client.api');

        $response = $client->request('GET', "/api/user/" . $id);
        $user = json_decode($response->getBody()->getContents(), true);


        usort($user['educations'], [$this, 'date_compare']);

        usort($user['work_experiences'], [$this, 'date_compare']);

        $appoApplications = [];
        foreach ($user['applications'] as $application) {
            if ($application['status'] == "SENT" || $application['status'] == "UNCOMPLETED") {
                $appoApplications[] = $application;
            }
        }
        usort($appoApplications, [$this, 'date_compare']);

        $user['applications'] = $appoApplications;


        if (!Cache::has("systemJobFunctions")) {
            $response = $client->request('GET', "/api/tags/category/JOBFUNCTION");
            $res = json_decode($response->getBody()->getContents(), true);
            $jobFunctions = [];
            foreach ($res as $industry) {
                if (App::getLocale() == "it") {
                    $jobFunctions[] = [
                        "id" => $industry['id'],
                        "name" => $industry['name_it']
                    ];
                } else {
                    $jobFunctions[] = [
                        "id" => $industry['id'],
                        "name" => $industry['name']
                    ];
                }
            }
            usort($jobFunctions, [$this, 'compareByName']);
            Cache::add("systemJobFunctions", $jobFunctions, 60);

        } else {
            $jobFunctions = Cache::get("systemJobFunctions");
        }

        if (!Cache::has("systemIndustries")) {
            $response = $client->request('GET', "/api/tags/category/INDUSTRY");
            $res = json_decode($response->getBody()->getContents(), true);
            $industries = [];
            foreach ($res as $industry) {
                if (App::getLocale() == "it") {
                    $industries[] = [
                        "id" => $industry['id'],
                        "name" => $industry['name_it']
                    ];
                } else {
                    $industries[] = [
                        "id" => $industry['id'],
                        "name" => $industry['name']
                    ];
                }
            }
            usort($industries, [$this, 'compareByName']);
            Cache::add("systemIndustries", $industries, 60);

        } else {
            $industries = Cache::get("systemIndustries");
        }
        if (!Cache::has("systemDegree")) {
            $response = $client->request('GET', "/api/degree");
            $res = json_decode($response->getBody()->getContents(), true);
            $degrees = [];
            foreach ($res as $degree) {
                if (App::getLocale() == "it" && $degree['is_visible_it']) {
                    $degrees[] = [
                        "id" => $degree['id'],
                        "name" => $degree['name']
                    ];
                }

                if (App::getLocale() != "it" && $degree['is_visible_en']) {
                    $degrees[] = [
                        "id" => $degree['id'],
                        "name" => $degree['name']
                    ];
                }

            }
            usort($degrees, [$this, 'compareByName']);
            Cache::add("systemDegree", $degrees, 60);

        } else {
            $degrees = Cache::get("systemDegree");
        }

        if (!Cache::has("systemStudyFields")) {
            $response = $client->request('GET', "/api/tags/category/STUDYFIELD");
            $res = json_decode($response->getBody()->getContents(), true);

            $studyFields = [];
            foreach ($res as $studyField) {
                if (App::getLocale() == "it") {
                    $studyFields[] = [
                        "id" => $studyField['id'],
                        "name" => $studyField['name_it']
                    ];
                } else {
                    $studyFields[] = [
                        "id" => $studyField['id'],
                        "name" => $studyField['name']
                    ];
                }
            }
            usort($studyFields, [$this, 'compareByName']);
            Cache::add("systemStudyFields", $studyFields, 60);

        } else {
            $studyFields = Cache::get("systemStudyFields");
        }



        return View::make('admin.profile', ["degrees" => $degrees, "studyFields" => $studyFields, "industries" => $industries, "jobFunctions" => $jobFunctions, "user" => $user, "route" => "profile", "title" => "Dashboard", "description" => ""]);

    }

    public function setOneSignalPushId()
    {

        if (Auth::check() && Input::get("pushId") && Input::get("pushId") > 0) {
            $client = App::make('client.api');

            $inputs[] = [
                "push_id" => Input::get("pushId")
            ];

            $response = $client->request("PATCH", "/api/user/" . Auth::user()->id, ['form_params' => $inputs]);


            if ($response->getStatusCode() == 204) {
                $resp = $response->getHeader("Location");
                $resp = explode("/", $resp[0]);
                return response()->json(["id" => end($resp)], 204);
            }
        } else {
            return response()->json("Not logged - gentle not throwed error", 200);

        }

    }

    public function updateUser($id)
    {

        $client = App::make('client.api');

        $inputs[] = Input::all();

        unset($inputs[0]["__ga"]);
        unset($inputs[0]["user"]);

        $response = $client->request("PATCH", "/api/user/" . $id, ['form_params' => $inputs]);


        if ($response->getStatusCode() == 204) {
            $resp = $response->getHeader("Location");
            $resp = explode("/", $resp[0]);


            if (Input::get("__ga") == 1 && Input::get("user")) {
                $userCompany = Input::get("user");


                $params = [];
                $user = $this->make_get("/api/user/$id");

                $email = $this->generateRandomString(8) . "@meritocracy.is";
                $password = $this->generateRandomString(8);


                $params[] = [
                    "first_name" => $userCompany['first_name'],
                    "last_name" => $userCompany['last_name'],
                    "telephone" => (isset($user['telephone'])) ? $user['telephone'] : "",
                    "mobile_phone" => (isset($user['mobile'])) ? $user['mobile'] : "",
                    "email" => $email,
                    "address" => "",
                    "status" => 1,
                    "gender" => null,
                    "type" => "ANALYTICS",
                    "birthdate" => null,
                    "password" => Hash::make($password),
                    "city_plain_text" => "",
                    "company" => [
                        "id" => $user["company"]["id"]
                    ]
                ];

                $client->request("POST", "/api/user", ['form_params' => $params]);

                if ($response->getStatusCode() == 204) {

                    $template = "REGISTRATION_USER_MAIL_COMPANY";


                    $subject = "Your registration has been confirmed";
                    if (\Illuminate\Support\Facades\App::getLocale() == "it") {
                        $subject = "La tua registrazione è avvenuta correttamente";
                    }

                    $msgUser = [
                        "title" => $user["company"]['name'],
                        "email" => $userCompany["email"],
                        "name" => $userCompany['first_name'],
                        "password" => $userCompany['password'],
                        "companyName" => $user["company"]['name'],
                    ];


                    $emailData[] = [
                        "status" => "ENQUEUED",
                        "params" => $msgUser,
                        "subject" => $subject,
                        "sender" => [
                            "name" => "Meritocracy",
                            "email" => 'account@meritocracy.is'
                        ],
                        "language" => strtoupper(\Illuminate\Support\Facades\App::getLocale()),
                        "cc" => [],
                        "bcc" => [],
                        "recipient" => [
                            "name" => $user['first_name'],
                            "email" => $user['email']
                        ],
                        "user" => [
                            "id" => $user["id"]
                        ],
                        "method" => "INTERN",
                        "template" => $template,
                    ];


                    $msg = [
                        "title" => $user["company"]['name'],
                        "email" => $email,
                        "regMail" => $userCompany["email"],
                        "name" => $user['first_name'],
                        "password" => $password,
                        "companyName" => $user["company"]['name'],
                        "reference" => $user["first_name"] . " " . $user["last_name"],
                        "source" => isset($user["referer_url"]) ? $user["referer_url"] : "",
                        "phone" => isset($user["mobile_phone"]) ? $user["mobile_phone"] : ""
                    ];

                    $emailData[] = [
                        "status" => "ENQUEUED",
                        "params" => $msg,
                        "subject" => $user["company"]["name"] . " has been signed up",
                        "recipient" => [
                            "name" => "Meritocracy",
                            "email" => 'company-registration@meritocracy.is'
                        ],
                        "cc" => [],
                        "bcc" => [],
                        "language" => strtoupper(\Illuminate\Support\Facades\App::getLocale()),
                        "sender" => [
                            "name" => "Meritocracy",
                            "email" => 'account@meritocracy.is'
                        ],
                        "method" => "INTERN",
                        "template" => "REGISTRATION_MAIL_COMPANY_INTERNAL",
                    ];


                    $idUser = $user['id'];

                    $subject = $user['company']['name'] . "'s Branding Page is almost ready!";
                    if (\Illuminate\Support\Facades\App::getLocale() == "it") {
                        $subject = "La Branding Page di " . $user['company']['name'] . " è quasi pronta!";
                    }

                    $sendTime = new \DateTime();
                    $sendTime->add(new \DateInterval("PT6H"));

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
                            "name" => $user['first_name'],
                            "email" => $user['email']
                        ],
                        "user" => [
                            "id" => $user["id"]
                        ],
                        "method" => "INTERN",
                        "template" => "UNCOMPLETE_COMPANY_PAGE_FIRST_ALERT",
                        "send_at" => $sendTime->format("Y-m-d H:i"),

                    ];


                    $subject = "Add additional content to " . $user['company']['name'] . "'s Branding Page";
                    if (\Illuminate\Support\Facades\App::getLocale() == "it") {
                        $subject = "Aggiungi nuovi contenuti alla Branding Page di " . $user['company']['name'];
                    }


                    $sendTime = new \DateTime();
                    $sendTime->add(new \DateInterval("P1D"));
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
                        "send_at" => $sendTime->format("Y-m-d H:i"),
                        "bcc" => [],
                        "recipient" => [
                            "name" => reset($params)['first_name'],
                            "email" => reset($params)['email']
                        ],
                        "user" => [
                            "id" => $idUser
                        ],
                        "method" => "INTERN",
                        "template" => "UNCOMPLETE_COMPANY_PAGE",
                    ];

                    $subject = "" . $user['company']['name'] . "'s Branding Page is incomplete";
                    if (\Illuminate\Support\Facades\App::getLocale() == "it") {
                        $subject = "La branding page di " . $user['company']['name'] . " risulta incompleta";
                    }
                    $sendTime = new \DateTime();
                    $sendTime->add(new \DateInterval("P2D"));
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
                        "send_at" => $sendTime->format("Y-m-d H:i"),
                        "recipient" => [
                            "name" => reset($params)['first_name'],
                            "email" => reset($params)['email']
                        ],
                        "user" => [
                            "id" => $idUser
                        ],
                        "method" => "INTERN",
                        "template" => "UNCOMPLETE_COMPANY_PAGE",
                    ];


                    $client = App::make('client.api');
                    try {
                        $response = $client->request("POST", "/api/email-queue", ['form_params' => $emailData]);
                    } catch (\Exception $e) {

                    }

                    return response()->json(["id" => end($resp)], 204);

                } else {
                    return response()->json(["Error"], 500);

                }
            }
            return response()->json(["id" => end($resp)], 204);

        }
    }


    public function getUserWorkExperience($id)
    {
        $client = App::make('client.api');

        $response = $client->request('GET', "/api/work-experience/" . $id);
        $workExperience = json_decode($response->getBody()->getContents(), true);


        $response = $client->request('GET', "/api/tags/category/JOBFUNCTION");
        $res = json_decode($response->getBody()->getContents(), true);

        $jobFunctions = [];
        foreach ($res as $industry) {
            if (App::getLocale() == "it") {
                $jobFunctions[] = [
                    "id" => $industry['id'],
                    "name" => $industry['name_it']
                ];
            } else {
                $jobFunctions[] = [
                    "id" => $industry['id'],
                    "name" => $industry['name']
                ];
            }
        }

        usort($jobFunctions, [$this, 'compareByName']);


        $response = $client->request('GET', "/api/tags/category/INDUSTRY");
        $res = json_decode($response->getBody()->getContents(), true);

        $industries = [];
        foreach ($res as $industry) {
            if (App::getLocale() == "it") {
                $industries[] = [
                    "id" => $industry['id'],
                    "name" => $industry['name_it']
                ];
            } else {
                $industries[] = [
                    "id" => $industry['id'],
                    "name" => $industry['name']
                ];
            }
        }


        usort($industries, [$this, 'compareByName']);


        return View::make('partial.work-experience', array("jobFunctions" => $jobFunctions, "industries" => $industries, "work" => $workExperience));
    }

    public function getUserEducation($id)
    {
        $client = App::make('client.api');

        $response = $client->request('GET', "/api/education/" . $id);
        $workExperience = json_decode($response->getBody()->getContents(), true);


        $response = $client->request('GET', "/api/degree");
        $res = json_decode($response->getBody()->getContents(), true);


        $degrees = [];
        foreach ($res as $degree) {
            if (App::getLocale() == "it" && $degree['is_visible_it']) {
                $degrees[] = [
                    "id" => $degree['id'],
                    "name" => $degree['name']
                ];
            }

            if (App::getLocale() != "it" && $degree['is_visible_en']) {
                $degrees[] = [
                    "id" => $degree['id'],
                    "name" => $degree['name']
                ];
            }

        }


        $response = $client->request('GET', "/api/tags/category/STUDYFIELD");
        $res = json_decode($response->getBody()->getContents(), true);

        $studyFields = [];
        foreach ($res as $studyField) {
            if (App::getLocale() == "it") {
                $studyFields[] = [
                    "id" => $studyField['id'],
                    "name" => $studyField['name_it']
                ];
            } else {
                $studyFields[] = [
                    "id" => $studyField['id'],
                    "name" => $studyField['name']
                ];
            }
        }


        usort($studyFields, [$this, 'compareByName']);
        return View::make('partial.education', array("work" => $workExperience, "degrees" => $degrees, "studyFields" => $studyFields));
    }


    public function getUserLanguage($id)
    {
        $client = App::make('client.api');

        $response = $client->request('GET', "/api/language-user/" . $id);
        $workExperience = json_decode($response->getBody()->getContents(), true);


        return View::make('partial.language', array("language" => $workExperience));
    }


}
