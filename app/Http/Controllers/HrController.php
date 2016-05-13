<?php

namespace Meritocracy\Http\Controllers;

use Cache;
use Illuminate\Support\Facades\App;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class HrController extends Controller
{


    /**
     * Instantiate a new UserController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');

    }


    public function removeFeedback($id)
    {

        $client = App::make('client.api');

        $response = $client->request('DELETE', "/api/feedback/$id");

        if ($response->getStatusCode() == 500) {
            return response()->json([], 500);


        } else {
            return response()->json([], 200);
        }

    }


    public function deteleCategory($id)
    {
        $client = App::make('client.api');
        $response = $client->request('DELETE', "/api/category/$id");
        return response()->json([], $response->getStatusCode());
    }


    public function getHrDashboard()
    {

        $user = Auth::user();
        if ($user->type == "COMPANY" || $user->type == "ANALYTICS" || $user->type == "ADMINISTRATOR") {
            $client = App::make('client.api');


            if (\Illuminate\Support\Facades\Auth::user()->type == "ADMINISTRATOR") {
                return redirect('/admin/dashboard');
            }

            $response = $client->request('GET', "/api/" . "systemLanguage");


            $res = $response->getBody()->getContents();
            $res = json_decode($res, true);


            $languages = [];
            foreach ($res as $language) {

                if (App::getLocale() == "it" && $language['italian_name'] != null) {
                    $languages[] = [
                        "id" => $language['id'],
                        "name" => $language['italian_name']
                    ];

                } else {
                    $languages[] = [
                        "id" => $language['id'],
                        "name" => $language['name']
                    ];
                }
            }


            usort($languages, array($this, "compareByName"));


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


            usort($industries, array($this, "compareByName"));

            $companyIndustry = isset(\Illuminate\Support\Facades\Auth::user()->company["industry"], \Illuminate\Support\Facades\Auth::user()->company["industry"]["id"]) ? \Illuminate\Support\Facades\Auth::user()->company["industry"]["id"] : -1;
            $companyLanguage = isset(\Illuminate\Support\Facades\Auth::user()->company["language"], \Illuminate\Support\Facades\Auth::user()->company["language"]["id"]) ? \Illuminate\Support\Facades\Auth::user()->company["language"]["id"] : -1;


            $videos = "";
            if (isset(Auth::user()->company['videos'])) {
                $videos = Auth::user()->company['videos'];
                usort($videos, array($this, "compareByName"));

            }

            $companies = [];

            if ($user->type == "ADMINISTRATOR") {
                $response = $client->request('GET', "/api/company?isSystemCompany=true&serializerGroup=admin");
                $companies = json_decode($response->getBody()->getContents(), true);

                usort($companies, array($this, "compareByName"));
            }

            $hasCheckout = false;

            if (session()->has("checkout_done")) {
                $hasCheckout = session('checkout_done');

            }


            $hasCancel = false;

            if (session()->has("checkout_fail")) {
                $hasCancel = session('checkout_fail');

            }


            $vat = 22;
            if (\Illuminate\Support\Facades\Auth::user()->company['billing_country'] != "" && strtolower(\Illuminate\Support\Facades\Auth::user()->company['billing_country']) != "italy") {
                $vat = 0;
            }

            $subtotal = env('SPONSORED_VACANCY_PRICE', 259);

            $total = number_format($subtotal + ($subtotal * ($vat / 100)));

            return View::make('admin.hr', array("total" => $total, "subtotal" => $subtotal, "vat" => $vat, "hasCancel" => $hasCancel, "hasCheckout" => $hasCheckout, "companies" => $companies, "companyLanguage" => $companyLanguage, "companyIndustry" => $companyIndustry, "industries" => $industries, "languages" => $languages, "videos" => $videos, "company" => \Illuminate\Support\Facades\Auth::user()->company, "user" => $user, "route" => "dashboard", "title" => "HR Dashboard", "description" => ""));
        } else {
            return redirect('/login');
        }
    }

    public function getCompanyVacanciesList()
    {
        $client = App::make('client.api');
        $vacancies = [];
        if (isset(Auth::user()->company["id"]) && Auth::user()->company["id"] != "") {
            $response = $client->request('GET', "/api/company/" . Auth::user()->company["id"] . "/vacancies");
            $vacancies = json_decode($response->getBody()->getContents(), true);

            if (!empty($vacancies)) {
                usort($vacancies, array($this, "date_compare"));
                $vacancies = array_reverse($vacancies);
            }

            if (!empty($vacancies) && $vacancies[0]['sort'] != null) {
                $this->sortBySubkey($vacancies, 'sort');

            }


        }

        return View::make('partial.vacancies-list', array("vacancies" => $vacancies));


    }


    public function getBenefits()
    {

        $user = Auth::user();
        if ($user->type == "COMPANY" || $user->type == "ANALYTICS" || $user->type == "ADMINISTRATOR") {

            if (Input::get("company-id")) {
                $user->company = ['id' => Input::get("company-id")];
            }

            if ($user->company["id"] == "" || !isset($user->company["id"])) {
                return redirect('/login');

            }
            $client = App::make('client.api');
            $response = $client->request('GET', "/api/company/" . $user->company["id"]."/benefits");
            $benefits = json_decode($response->getBody()->getContents(), true);


            return View::make('admin.benefits-template', array("company" => ($user->company != null) ? $user->company : [], "benefits" => $benefits, "route" => "benefits", "title" => "Manage Benefits", "description" => ""));
        } else {
            return redirect('/login');
        }
    }

    public function getBenefitsView()
    {


        $user = Auth::user();
        if ($user->type == "COMPANY" || $user->type == "ANALYTICS" || $user->type == "ADMINISTRATOR") {

            if (Input::get("company-id")) {
                $user->company = ['id' => Input::get("company-id")];
            }

            if ($user->company["id"] == "" || !isset($user->company["id"])) {
                return redirect('/login');

            }
            $client = App::make('client.api');
            $company = $user->company;


            $companies = [];

            if ($user->type == "ADMINISTRATOR") {
                $response = $client->request('GET', "/api/company?isSystemCompany=true&serializerGroup=admin");
                $companies = json_decode($response->getBody()->getContents(), true);

                usort($companies, array($this, "compareByName"));
            }

            return View::make('admin.benefits', array("companies" => $companies, "company" => ($company != null) ? $company : [], "route" => "benefits", "title" => "Manage Benefits", "description" => ""));
        } else {
            return redirect('/login');
        }
    }

    public function getTeam()
    {


        $user = Auth::user();
        if ($user->type == "COMPANY" || $user->type == "ANALYTICS" || $user->type == "ADMINISTRATOR") {

            if (Input::get("company-id")) {
                $user->company = ['id' => Input::get("company-id")];
            }

            if ($user->company["id"] == "" || !isset($user->company["id"])) {
                return redirect('/login');

            }
            $client = App::make('client.api');
            $response = $client->request('GET', "/api/company/" . $user->company["id"]);
            $company = json_decode($response->getBody()->getContents(), true);


            $companies = [];

            if ($user->type == "ADMINISTRATOR") {
                $response = $client->request('GET', "/api/company?isSystemCompany=true&serializerGroup=admin");
                $companies = json_decode($response->getBody()->getContents(), true);

                usort($companies, array($this, "compareByName"));
            }

            return View::make('admin.team', array("companies" => $companies, "team" => (isset($company["team"])) ? $company["team"] : [], "company" => ($company != null) ? $company : [], "route" => "team", "title" => "Manage Team", "description" => ""));
        } else {
            return redirect('/login');
        }
    }

    public function getPaymentsPage()
    {


        $user = Auth::user();
        if ($user->type == "COMPANY" || $user->type == "ANALYTICS" || $user->type == "ADMINISTRATOR") {

            if (Input::get("company-id")) {
                $user->company = ['id' => Input::get("company-id")];
            }

            if ($user->company["id"] == "" || !isset($user->company["id"])) {
                return redirect('/login');

            }
            $client = App::make('client.api');
            //  $response = $client->request('GET', "/api/company/" . $user->company["id"]);
            //  $company = json_decode($response->getBody()->getContents(), true);
            $company = [];
            $response = $client->request('GET', "/api/company/" . $user->company["id"] . "/vacancies");
            $vacancies = json_decode($response->getBody()->getContents(), true);

            if (!empty($vacancies)) {
                usort($vacancies, array($this, 'date_compare'));
                $vacancies = array_reverse($vacancies);
            }


            $companies = [];

            if ($user->type == "ADMINISTRATOR") {
                $response = $client->request('GET', "/api/company?isSystemCompany=true&serializerGroup=admin");
                $companies = json_decode($response->getBody()->getContents(), true);

                usort($companies, array($this, "compareByName"));
            }

            return View::make('admin.payments', array("companies" => $companies, "vacancies" => $vacancies, "company" => ($company != null) ? $company : [], "route" => "payments", "title" => "Payments", "description" => ""));
        } else {
            return redirect('/login');
        }
    }

    public function getBillingDataPage()
    {


        $user = Auth::user();
        if ($user->type == "COMPANY" || $user->type == "ANALYTICS" || $user->type == "ADMINISTRATOR") {

            if (Input::get("company-id")) {
                $user->company = ['id' => Input::get("company-id")];
            }

            if ($user->company["id"] == "" || !isset($user->company["id"])) {
                return redirect('/login');

            }
            $client = App::make('client.api');

            $company = [];

            $company = Auth::user()->company;

            $response = $client->request('GET', "/api/country");
            $countries = json_decode($response->getBody()->getContents(), true);
            usort($countries, array($this, "compareByName"));


            $companies = [];

            if ($user->type == "ADMINISTRATOR") {
                $response = $client->request('GET', "/api/company?isSystemCompany=true&serializerGroup=admin");
                $companies = json_decode($response->getBody()->getContents(), true);

                usort($companies, array($this, "compareByName"));
            }

            return View::make('admin.billing-data', array("countries" => $countries, "companies" => $companies, "company" => ($company != null) ? $company : [], "route" => "billing-data", "title" => "Billing Data", "description" => ""));
        } else {
            return redirect('/login');
        }
    }

    public function getVideos()
    {


        $user = Auth::user();
        if ($user->type == "COMPANY" || $user->type == "ANALYTICS" || $user->type == "ADMINISTRATOR") {
            if (Input::get("company-id")) {
                $user->company = ['id' => Input::get("company-id")];
            }
            if ($user->company["id"] == "" || !isset($user->company["id"])) {
                return redirect('/login');

            }

            $client = App::make('client.api');
            $response = $client->request('GET', "/api/company/" . $user->company["id"]);
            $company = json_decode($response->getBody()->getContents(), true);


            $companies = [];

            if ($user->type == "ADMINISTRATOR") {
                $response = $client->request('GET', "/api/company?isSystemCompany=true&serializerGroup=admin");
                $companies = json_decode($response->getBody()->getContents(), true);

                usort($companies, array($this, "compareByName"));
            }

            return View::make('admin.videos', array("companies" => $companies, "videos" => (isset($company["videos"])) ? $company["videos"] : [], "company" => ($company != null) ? $company : [], "route" => "videos", "title" => "Manage Videos", "description" => ""));
        } else {
        }
    }

    public function getPhotogallery()
    {

        $user = Auth::user();
        if ($user->type == "COMPANY" || $user->type == "ANALYTICS" || $user->type == "ADMINISTRATOR") {
            if (Input::get("company-id")) {
                $user->company = ['id' => Input::get("company-id")];
            }
            if ($user->company["id"] == "" || !isset($user->company["id"])) {
                return redirect('/login');

            }

            $client = App::make('client.api');
            $response = $client->request('GET', "/api/company/" . $user->company["id"] . "?serializerGroup[]=company");
            $company = json_decode($response->getBody()->getContents(), true);
            if ($company) {
                if (!empty($company['sliders'])) {
                    $this->sortBySubkey($company['sliders'], "ordering");

                }
            }

            $companies = [];

            if ($user->type == "ADMINISTRATOR") {
                $response = $client->request('GET', "/api/company?isSystemCompany=true&serializerGroup=admin");
                $companies = json_decode($response->getBody()->getContents(), true);

                usort($companies, array($this, "compareByName"));
            }
            return View::make('admin.photogallery', array("companies" => $companies, "sliders" => (isset($company["sliders"])) ? $company["sliders"] : [], "company" => ($company != null) ? $company : [], "route" => "photogallery", "title" => "Manage Photogallery", "description" => ""));
        } else {
            return redirect('/?login?err=Session Expired');
        }
    }


    public function getArchiveVacancies()
    {

        $user = Auth::user();
        if ($user->type == "COMPANY" || $user->type == "ANALYTICS" || $user->type == "ADMINISTRATOR") {
            if (Input::get("company-id")) {
                $user->company = ['id' => Input::get("company-id")];
            }
            if ($user->company["id"] == "" || !isset($user->company["id"])) {
                return redirect('/login');

            }

            $client = App::make('client.api');
            $response = $client->request('GET', "/api/company/" . $user->company["id"] . "/vacancies");
            $vacancies = json_decode($response->getBody()->getContents(), true);

            if (!empty($vacancies)) {
                usort($vacancies, array($this, 'date_compare'));
                $vacancies = array_reverse($vacancies);
            }

            if (!empty($vacancies) && $vacancies[0]['sort'] != null) {
                $this->sortBySubkey($vacancies, 'sort');

            }


            $companies = [];

            if ($user->type == "ADMINISTRATOR") {
                $response = $client->request('GET', "/api/company?isSystemCompany=true&serializerGroup=admin");
                $companies = json_decode($response->getBody()->getContents(), true);

                usort($companies, array($this, "compareByName"));
            }

            return View::make('admin.archive-vacancies', array("companies" => $companies, "vacancies" => $vacancies, "route" => "archive-vacancies", "title" => "Archive Vacancies", "description" => ""));
        } else {
            return redirect('/login');
        }

    }


    public function getCompanyPage()
    {

        $user = Auth::user();
        if ($user->type == "COMPANY" || $user->type == "ANALYTICS" || $user->type == "ADMINISTRATOR") {

            $client = App::make('client.api');

            $company = [];
            if (Input::get("company-id")) {
                $user->company = ['id' => Input::get("company-id")];
            }
            if ($user->company["id"]) {
                $response = $client->request('GET', "/api/company/" . $user->company["id"]);
                $company = json_decode($response->getBody()->getContents(), true);
            }


            $response = $client->request('GET', "/api/" . "systemLanguage");


            $res = $response->getBody()->getContents();
            $res = json_decode($res, true);


            $languages = [];
            foreach ($res as $language) {

                if (App::getLocale() == "it" && $language['italian_name'] != null) {
                    $languages[] = [
                        "id" => $language['id'],
                        "name" => $language['italian_name']
                    ];

                } else {
                    $languages[] = [
                        "id" => $language['id'],
                        "name" => $language['name']
                    ];
                }
            }


            usort($languages, array($this, "compareByName"));


            $response = $client->request('GET', "/api/" . "tags" . "/category/" . "industry");


            $res = $response->getBody()->getContents();
            $res = json_decode($res, true);


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


            usort($industries, array($this, "compareByName"));


            $response = $client->request('GET', "/api/benefit");


            $res = $response->getBody()->getContents();
            $benefits = json_decode($res, true);


            usort($benefits, array($this, "compareByName"));

            $arrayBenefits = [];

            if (isset($company['benefits'])) {
                foreach ($company['benefits'] as $benefit) {
                    $arrayBenefits[] = $benefit['id'];
                }
            }


            foreach ($benefits as $key => $benefit) {
                if (in_array($benefit['id'], $arrayBenefits)) {
                    $benefits[$key]['selected'] = "selected";
                } else {
                    $benefits[$key]['selected'] = "";

                }

            }

            $companies = [];

            if ($user->type == "ADMINISTRATOR") {
                $response = $client->request('GET', "/api/company?isSystemCompany=true&serializerGroup=admin");
                $companies = json_decode($response->getBody()->getContents(), true);

                usort($companies, array($this, "compareByName"));
            }

            return View::make('admin.company-page', array("companies" => $companies, "languages" => $languages, "benefits" => $benefits, "industries" => $industries, "company" => $company, "route" => "company-page", "title" => "Modify Company Page", "description" => ""));
        } else {
            return redirect('/login');
        }
    }


    public function getApplicationDetail($id)
    {
        $user = Auth::user();
        if ($user->type == "COMPANY" || $user->type == "ANALYTICS" || $user->type == "ADMINISTRATOR") {

            $companyId = $user->company["id"];
            $company = $user->company;

            $application = $this->make_get("api/application/" . $id . "?serializerGroup[]=detail_hr");


            // if ($companyId == $application["vacancy"]["company"]["id"] || $user->type == "ADMINISTRATOR") {
            if (1) {
                $count = [];

                $applications = $this->make_get("api/application?user=" . $application["user"]["id"] . "");


                foreach ($applications as $appl) {
                    if ($appl["vacancy"]["company"]["id"] == $user->company["id"]) {
                        if ($appl['status'] == "SENT") {
                            $appl['status'] = "APPLIED";
                        }

                        if ($appl['status'] == "STARRED") {
                            $appl['status'] = "ACCEPTED";
                        }


                        $count[] = $appl["status"] . " on " . date('d/m/Y', strtotime($appl["created_at"])) . " for: " . $appl["vacancy"]["name"];
                    }
                }

                if (!empty($application["user"]['birthdate'])) {
                    $from = new \DateTime($application["user"]['birthdate']);
                    $to = new \DateTime('today');
                    $age = $from->diff($to)->y;
                    $application["user"]['age'] = $age;
                }
                if ($user->type == "ANALYTICS") {
                    $application["source"] = $application["user"]["referer_url"];
                    if (isset($application["premium_suggested"]) && $application["premium_suggested"] == 1) {
                        $application["source"] = "<b>Meritocracy Premium</b>";
                    }
                }


                foreach ($application["events"] as $event) {
                    if ($event["status"] == "REQUEST-CV") {
                        $application["requestedCv"] = $event["created_at"];
                    }
                    if ($event["status"] == "CONTACT") {
                        $application["contacted"] = date('d/m/Y', strtotime($event["created_at"]));
                    }
                    if ($event["status"] == "COMMENT") {

                        $comment["id"] = $event["id"];
                        $comment["text"] = $event["comment"];
                        $comment["date"] = date('d/m/Y ', strtotime($event["created_at"]));
                        $application["comment"][] = $comment;

                    }
                }
                if (count($count) > 1) {
                    $application["duplicated"] = $count;
                }
                $catMode = 0;
                if (Input::get("categoryMode")) {
                    $catMode = reset($application["category_application"])["id"];
                } else {
                    $catMode = 0;
                }


                return View::make('admin.profile-hr', array("categoryMode" => $catMode, "company" => $company, "application" => $application, "user" => $application["user"], "route" => "dashboard", "title" => "Dashboard", "description" => ""));
            } else {
                return response()->json([], 401);
            }


        } else {
            return redirect('/login?err=Please login again');

        }
    }


    public function getApplicationCv($id)
    {
        if (Auth::check()) {
            $client = App::make('client.api');

            $response = $client->request('GET', "/api/application/" . $id);
            $application = json_decode($response->getBody()->getContents(), true);

            if ($application["vacancy"]["company"]["id"] == Auth::user()->company["id"]) {

                $eventParams[] = ["status" => "READ", "title" => "CV viewed", "comment" => "The CV has been viewed", "application" => ["id" => $id], "author" => ["id" => Auth::user()->id]];
                $client->request("POST", "/api/event-application", ['form_params' => $eventParams]);


                if (isset($application["cv"]) && filter_var($application["cv"], FILTER_VALIDATE_URL)) {
                    Redirect::to($application["cv"]);
                } else {
                    $prm = ["key" => "94nr3BM70eMJFfvc2U6R92S10hUX8dIh"];

                    $r = $client->request('POST', "http://meritocracy.jobs/includes/view_cv?userId=" . $application["user"]["import_id"], ['form_params' => $prm]);

                    $response = Response::make($r->getBody()->getContents(), 200);

                    $response->header('Content-Type', $r->getHeader('Content-type')[0]);
                    return $response;


                }


            } else {
                return response()->json(["Hey, only chuck norris can do this."], 401);
            }

        } else {
            return response()->json([], 401);
        }
    }

    public function removeBenefit($benefitId, $companyId)
    {

        $client = App::make('client.api');

        $companyHasBenefitId = make_get("/api/company-has-benefit?company=$companyId&benefit=$benefitId&serializerGroup=user");
        $companyHasBenefitId = end($companyHasBenefitId)["id"];

        $response = $client->request('DELETE', "/api/company-has-benefit/$companyHasBenefitId");


        return response()->json([], 200);

    }


    public function updateStatusApplication($id, $type)
    {
        $user = Auth::user();
        if ($user->type == "COMPANY" || $user->type == "ANALYTICS") {
            $client = App::make('client.api');

            $now = new \DateTime();

            $params[] = [
                "status" => strtoupper($type),
                "last_update_status" => $now->format("Y-m-d")
            ];

            $response = $client->request('PATCH', "api/application/" . $id, ['form_params' => $params]);
            if ($response->getStatusCode() == 204) {

                $eventParams[] = ["status" => strtoupper($type), "title" => "Application " . $type, "comment" => "Application " . $type, "application" => ["id" => $id], "author" => ["id" => Auth::user()->id]];

                $response = $client->request("POST", "/api/event-application", ['form_params' => $eventParams]);


                $resp = $response->getHeader("Location");
                $resp = explode("/", $resp[0]);
                $applicationData = make_get("/api/application/$id");

                if (strtoupper($type) === "STARRED") {

                    $mailParams = [
                        "name" => $applicationData["user"]["first_name"],
                        "company" => $user->company["name"]
                    ];
                    $emailData[] = [
                        "status" => "ENQUEUED",
                        "params" => $mailParams,
                        "subject" => "Ciao " . $applicationData["user"]["first_name"] . ", vai al colloquio con FlixBus",
                        "sender" => [
                            "name" => 'Meritocracy e FlixBus',
                            "email" => 'info@meritocracy.is'
                        ],
                        "recipient" => [
                            "name" => "Meritocracy e FlixBus",
                            "email" => $applicationData["user"]["email"]
                        ],
                        "language" => strtoupper(\Illuminate\Support\Facades\App::getLocale()),
                        "cc" => [],
                        "bcc" => [],
                        "method" => "INTERN",
                        "template" => "FLIXBUS_PROMOTIONAL",
                        "user" => [
                            "id" => Auth::user()->id
                        ],
                        "promotional" => "FlixBus"
                    ];

                    try {
                        $client->request("POST", "/api/email-queue", ['form_params' => $emailData]);
                    } catch (\Exception $e) {
                    }

                }


                return response()->json(["id" => end($resp)], 201);

            } else {
                return response()->json([], 500);

            }


        } else {
            return response()->json([], 401);
        }
    }

    public function addFeedback()
    {

        $client = App::make('client.api');

        $paramsForm = Input::all();

        if (isset($paramsForm["feedbackType"])) {

            $params[] = [
                "company" => ["id" => Auth::user()->company["id"]],
                "user" => ["id" => Auth::user()->id],
                "title" => $paramsForm["feedbackTitle"],
                "description" => $paramsForm["feedbackDescription"],
                "type" => $paramsForm["feedbackType"]
            ];


            $response = $client->request("POST", "/api/feedback", ['form_params' => $params]);

            if ($response->getStatusCode() == 201 || $response->getStatusCode() == 204) {


                $resp = $response->getHeader("Location");
                $resp = explode("/", $resp[0]);


                $eventParams[] = [
                    "status" => "NEW",
                    "title" => "Feedback added",
                    "comment" => "A feedback has been created",
                    "company" => ["id" => Auth::user()->company["id"]],
                    "author" => ["id" => Auth::user()->id]
                ];
                $client->request("POST", "/api/event-company", ['form_params' => $eventParams]);


                return response()->json(["id" => end($resp)], 201);
            } else {
                return response()->json([], $response->getStatusCode());
            }
        }


    }


    public function addApplicationToCategory($id)
    {
        if (Auth::check()) {
            $client = App::make('client.api');

            try {
                $response = $client->request('GET', "/api/company/" . Auth::user()->company["id"]);
                $company = json_decode($response->getBody()->getContents(), true);

                foreach ($company["categories"] as $category) {
                    if ($category["id"] == $id) {
                        $cat_applications = $category["categories_applications"];
                        foreach ($cat_applications as $cat_apl) {
                            if ($cat_apl["application"]["id"] == Input::get("applicationId")) {
                                return response()->json("Already added", 409);
                            }
                        }
                    }
                }
            } catch (\Exception $e) {
            }

            $params[] = [
                "application" => ["id" => Input::get("applicationId")],
                "category" => ["id" => $id]
            ];

            $response = $client->request("POST", "/api/category-application", ['form_params' => $params]);
            return response()->json("", $response->getStatusCode());


        }
    }

    public function addCategory()
    {
        if (Auth::check()) {
            $client = App::make('client.api');

            $paramsForm = Input::all();


            $params[] = [
                "company" => ["id" => Auth::user()->company["id"]],
                "user" => ["id" => Auth::user()->id],
                "title" => $paramsForm["categoryTitle"],
            ];

            $response = $client->request("POST", "/api/category", ['form_params' => $params]);

            if ($response->getStatusCode() == 201 || $response->getStatusCode() == 204) {


                $resp = $response->getHeader("Location");
                $resp = explode("/", $resp[0]);


                $eventParams[] = [
                    "status" => "NEW",
                    "title" => "Category added",
                    "comment" => "A category has been created",
                    "company" => ["id" => Auth::user()->company["id"]],
                    "author" => ["id" => Auth::user()->id]
                ];
                $client->request("POST", "/api/event-company", ['form_params' => $eventParams]);


                return response()->json(["id" => end($resp)], 201);
            } else {
                return response()->json([], $response->getStatusCode());
            }
        } else {
            return response()->json([], 401);

        }
    }

    public function addVacancy()
    {
        if (Auth::check()) {
            $client = App::make('client.api');

            $paramsForm = Input::all();

            $data = str_replace("/", "-", trim($paramsForm["vacancyAddDate"]));
            $data = new \DateTime($data);

            $now = new \DateTime();


            $output = str_replace(array("\r\n", "\r"), "\n", trim($paramsForm["vacancyAddDescription"]));
            $lines = explode("\n", $output);
            $new_lines = array();

            foreach ($lines as $i => $line) {
                if (!empty($line))
                    $new_lines[] = trim($line);
            }
            $paramsForm['vacancyAddDescription'] = implode($new_lines);


            $paramsForm["vacancyAddDescription"] = preg_replace('/<!--(.|\s)*?-->/', '', strip_tags($paramsForm['vacancyAddDescription'], "<p><br><strong><i><b><u><ol><li><blockquote><italic>"));
            $paramsForm["vacancyAddDescription"] = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $paramsForm["vacancyAddDescription"]);

            $appo = [
                "company" => ["id" => (isset($paramsForm['company']['id'])) ? $paramsForm['company']['id'] : Auth::user()->company["id"]],
                "user" => ["id" => Auth::user()->id],
                "name" => $paramsForm["vacancyAddName"],
                "description" => $paramsForm["vacancyAddDescription"],
                "open_date" => $data->format("Y-m-d H:i"),
                "is_sponsored" => false,
                "is_active" => 1,
                "status" => 1,
                "city_plain_text" => $paramsForm["city_plain_text"],
                "seniority" => $paramsForm["vacancyAddSeniority"],
                "study_field" => ["id" => $paramsForm["vacancyAddStudyField"]],
                "industry" => ["id" => $paramsForm["vacancyAddIndustry"]],
                "job_function" => ["id" => $paramsForm["vacancyAddJobFunction"]],
                "codice_sconto" => []
            ];


            if (isset($paramsForm['codiceSconto']) && $paramsForm["codiceSconto"] != "") {

                $codiceSconto = $this->make_get("/api/codice-sconto?isActive=true&name=" . $paramsForm["codiceSconto"]);

                if (!empty($codiceSconto)) {

                    $appo['codice_sconto'] = [
                        "id" => $codiceSconto[0]['id']
                    ];
                }

            }


            if (isset($paramsForm["city"]['id']) && $paramsForm["city"]['id'] != "") {
                $appo['city'] = $paramsForm["city"];
            }


            if (isset($paramsForm["video"]['id']) && $paramsForm["video"]['id'] != "") {
                $appo['video'] = $paramsForm["video"];
            }


            try {
                $response = $client->request("POST", "/api/vacancy", ['form_params' => [$appo]]);

            } catch (\Exception $e) {

                return response()->json([$appo, $e->getMessage()], 500);

            }

            $resp = $response->getHeader("Location");
            $resp = explode("/", $resp[0]);


            if ($response->getStatusCode() == 201 || $response->getStatusCode() == 204) {

                $jobFunction = $this->make_get("/api/tags/" . $paramsForm["vacancyAddJobFunction"]);
                $jobFunction = $jobFunction["name"];

                $studyField = $this->make_get("/api/tags/" . $paramsForm["vacancyAddStudyField"]);
                $studyField = $studyField["name"];

                if (isset($paramsForm["sponsored"]) && $paramsForm["sponsored"] == "on") {

                    $subject = Auth::user()->company["name"] . " wants to sponsor a vacancy";
                    $companySubject = "Your spoonsored vacancy has been opened";
                    if (\Illuminate\Support\Facades\App::getLocale() == "it") {
                        $companySubject = "La tua vacancy sponsorizzata è stata aperta";
                    }

                    $mailParams = [
                        "title" => Auth::user()->first_name,
                        "companyName" => Auth::user()->company["name"],
                        "vacancyName" => $paramsForm["vacancyAddName"],
                        "vacancyDescription" => $paramsForm["vacancyAddDescription"],
                        "name" => $paramsForm["vacancyAddName"],
                        "link" => "https://meritocracy.is/" . Auth::user()->company["permalink"],
                        "id" => end($resp),
                        "countVacancy" => count(Auth::user()->company["vacancies"]),
                        "location" => $paramsForm["city_plain_text"],
                        "job_function" => $jobFunction,
                        "seniority" => $paramsForm["vacancyAddSeniority"],
                        "study_field" => $studyField,
                        "subject" => Auth::user()->company["name"] . " has added a sponsored vacancy"
                    ];

                } else {

                    $subject = Auth::user()->company["name"] . " just opened a new vacancy";


                    $companySubject = "Your vacancy has been opened";

                    if (\Illuminate\Support\Facades\App::getLocale() == "it") {
                        $companySubject = "La tua vacancy è stata aperta";
                    }


                    $mailParams = [
                        "title" => Auth::user()->first_name,
                        "companyName" => Auth::user()->company["name"],
                        "vacancyName" => $paramsForm["vacancyAddName"],
                        "vacancyDescription" => $paramsForm["vacancyAddDescription"],
                        "name" => $paramsForm["vacancyAddName"],
                        "link" => "https://meritocracy.is/" . Auth::user()->company["permalink"],
                        "id" => end($resp),
                        "countVacancy" => count(Auth::user()->company["vacancies"]),
                        "location" => $paramsForm["city_plain_text"],
                        "job_function" => $jobFunction,
                        "seniority" => $paramsForm["vacancyAddSeniority"],
                        "study_field" => $studyField,
                        "subject" => Auth::user()->company["name"] . " has added a new vacancy"
                    ];

                }


                $languages = explode(',', $paramsForm["vacancyAddLanguages"]);
                foreach ($languages as $language) {
                    $params[] = [
                        "vacancy" => ["id" => end($resp)],
                        "system_language" => ["id" => $language]
                    ];
                }
                $client->request("POST", "/api/language-vacancy", ['form_params' => $params]);


                $emailData = [];

                if (getenv('APP_ENV') != "local") {

                    $emailData[] = [
                        "status" => "ENQUEUED",
                        "params" => $mailParams,
                        "subject" => $companySubject,
                        "sender" => [
                            "name" => "Meritocracy",
                            "email" => 'account@meritocracy.is'
                        ],
                        "recipient" => [
                            "name" => Auth::user()->first_name,
                            "email" => Auth::user()->email
                        ],
                        "cc" => [],
                        "language" => strtoupper(\Illuminate\Support\Facades\App::getLocale()),
                        "bcc" => [],
                        "method" => "INTERN",
                        "template" => "NEW-VACANCY",
                        "user" => [
                            "id" => Auth::user()->id
                        ]
                    ];
                }


                $emailData[] = [
                    "status" => "ENQUEUED",
                    "params" => $mailParams,
                    "subject" => $subject,
                    "sender" => [
                        "name" => 'Meritocracy Vacancy',
                        "email" => 'info@meritocracy.is'
                    ],
                    "recipient" => [
                        "name" => "Meritocracy Vacancy",
                        "email" => "account@meritocracy.is"
                    ],
                    "language" => strtoupper(\Illuminate\Support\Facades\App::getLocale()),
                    "cc" => [],
                    "bcc" => [],
                    "method" => "INTERN",
                    "template" => "NEW-VACANCY",
                    "user" => [
                        "id" => Auth::user()->id
                    ]
                ];

                try {
                    $client->request("POST", "/api/email-queue", ['form_params' => $emailData]);
                } catch (\Exception $e) {
                }

                $eventParams[] = [
                    "status" => "NEW",
                    "title" => "Vacancy created",
                    "comment" => "The vacancy has been created",
                    "vacancy" => ["id" => end($resp)],
                    "author" => ["id" => Auth::user()->id]
                ];
                $client->request("POST", "/api/event-vacancy", ['form_params' => $eventParams]);

                Cache::forget("widget_vacancies_" . Auth::user()->company["id"]);


                return response()->json(["id" => end($resp)], 201);
            } else {
                return response()->json([], $response->getStatusCode());
            }
        } else {
            return response()->json([], 401);

        }
    }

    public function enqueueCompletePage()
    {

        $client = App::make('client.api');
        $user = Auth::user();
        $emailData[] = [
            "status" => "ENQUEUED",
            "params" => [
                "title" => $user->company['name'] . " ha bisogno di aiuto",
                "text" => "Azienda: " . $user->company['name'] . "<br>Email di contatto:" . $user->email . "<br>Company Page: http://meritocracy.is/" . $user->company['permalink']
            ],
            "subject" => $user->company['name'] . " vuole aiuto per completare la pagina",
            "sender" => [
                "name" => 'Meritocracy Company',
                "email" => 'info@meritocracy.is'
            ],
            "recipient" => [
                "name" => "Meritocracy Company",
                "email" => "account@meritocracy.is"
            ],
            "language" => strtoupper(\Illuminate\Support\Facades\App::getLocale()),
            "cc" => [],
            "bcc" => [],
            "method" => "INTERN",
            "template" => "SIMPLE_MAIL_TEMPLATE",
            "user" => [
                "id" => Auth::user()->id
            ]
        ];

        try {
            $client->request("POST", "/api/email-queue", ['form_params' => $emailData]);
        } catch (\Exception $e) {

        }


        return response()->json([], 201);

    }

    public function getHrPartialVacancy($id)
    {
        $client = App::make('client.api');

        $response = $client->request('GET', "/api/vacancy/" . $id);
        $workExperience = json_decode($response->getBody()->getContents(), true);


        return View::make('partial.vacancy', array("vacancy" => $workExperience));
    }


    public function openVacancy($id)
    {

        if (Auth::check()) {
            $client = App::make('client.api');

            $date = new \DateTime();
            $date->add(new \DateInterval("P4M"));

            $today = new \DateTime();

            $params[] = [
                "status" => 1,
                "is_active" => true,
                "closed_date" => $date->format("Y-m-d"),
                "open_date" => $today->format("Y-m-d H:i")
            ];


            $response = $client->request("PATCH", "/api/vacancy/$id", ['form_params' => $params]);

            if ($response->getStatusCode() == 204) {

                $eventParams[] = [
                    "status" => "OPEN",
                    "title" => "Vacancy opened",
                    "comment" => "The vacancy has been opened",
                    "vacancy" => ["id" => $id],
                    "author" => ["id" => Auth::user()->id]
                ];

                $client->request("POST", "/api/event-vacancy", ['form_params' => $eventParams]);


                $resp = $response->getHeader("Location");
                $resp = explode("/", $resp[0]);

                return response()->json(["id" => end($resp)], 204);
            } else {
                return response()->json([], $response->getStatusCode());
            }
        } else {
            return response()->json([], 401);

        }
    }


    public function closeVacancy($id)
    {
        if (Auth::check()) {
            $client = App::make('client.api');


            $params[] = [
                "status" => 0,
                "is_active" => false,
                "closed_date" => (new \DateTime())->format("Y-m-d")
            ];

            $response = $client->request("PATCH", "/api/vacancy/$id", ['form_params' => $params]);

            if ($response->getStatusCode() == 204) {

                $eventParams[] = [
                    "status" => "CLOSE",
                    "title" => "Vacancy closed",
                    "comment" => "The vacancy has been closed",
                    "vacancy" => ["id" => $id],
                    "author" => ["id" => Auth::user()->id]
                ];
                $client->request("POST", "/api/event-vacancy", ['form_params' => $eventParams]);


                $resp = $response->getHeader("Location");
                $resp = explode("/", $resp[0]);

                return response()->json(["id" => end($resp)], 204);
            } else {
                return response()->json([], $response->getStatusCode());
            }
        } else {
            return response()->json([], 401);

        }
    }


    public function editVacancy($id)
    {
        if (Auth::check()) {
            $client = App::make('client.api');

            $paramsForm = Input::all();


            $paramsForm["vacancyEditDescription"] = preg_replace('/<!--(.|\s)*?-->/', '', strip_tags($paramsForm["vacancyEditDescription"], "<p><br><strong><i><b><u><ol><li><blockquote><italic>"));

            $paramsForm["vacancyEditDescription"] = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $paramsForm["vacancyEditDescription"]);

            $data = str_replace("/", "-", trim($paramsForm["vacancyEditDate"]));
            $data = new \DateTime($data);

            $params = [
                "name" => $paramsForm["vacancyEditName"],
                "description" => $paramsForm["vacancyEditDescription"],
                "city_plain_text" => $paramsForm["city_plain_text"],
                "seniority" => $paramsForm["vacancyEditSeniority"],
                "study_field" => ["id" => $paramsForm["vacancyEditStudyField"]],
                "industry" => ["id" => $paramsForm["vacancyEditIndustry"]],
                "job_function" => ["id" => $paramsForm["vacancyEditJobFunction"]],
                "open_date" => $data->format("Y-m-d H:i"),
                "company" => ["id" => \Illuminate\Support\Facades\Auth::user()->company["id"]],
                "user" => ["id" => \Illuminate\Support\Facades\Auth::user()->id]
            ];


            if (isset($paramsForm["city"]['id']) && $paramsForm["city"]['id'] != "") {
                $params['city']['id'] = $paramsForm['city']['id'];
            }

            if (isset($paramsForm["company"]['id']) && $paramsForm["company"]['id'] != "") {
                $params['company']['id'] = $paramsForm['company']['id'];
            }


            if (isset($paramsForm["video"]['id']) && $paramsForm["video"]['id'] != "") {
                $params['video'] = $paramsForm["video"];
            } else {
                $params['video'] = null;

            }


            if ($paramsForm['action'] == "clone") {

                $params["status"] = 1;
                $params["sort"] = 0;
                $params["is_active"] = true;

                $response = $client->request("POST", "/api/vacancy", ['form_params' => [$params]]);


                $resp = $response->getHeader("Location");
                $resp = explode("/", $resp[0]);
                $id = end($resp);


            } else {
                $response = $client->request("PATCH", "/api/vacancy/$id", ['form_params' => [$params]]);
            }


            $languages = $paramsForm["vacancyEditLanguages"];
            $paramsLanguage = [];
            foreach ($languages as $language) {
                $paramsLanguage[] = [
                    "vacancy" => ["id" => $id],
                    "system_language" => ["id" => $language]
                ];
            }


            $client->request("POST", "/api/language-vacancy", ['form_params' => $paramsLanguage]);


            $eventParams[] = [
                "status" => "UPDATE",
                "title" => "Vacancy updated",
                "comment" => "The vacancy has been updated",
                "vacancy" => ["id" => $id],
                "author" => ["id" => Auth::user()->id]
            ];


            $client->request("POST", "/api/event-vacancy", ['form_params' => $eventParams]);

            $client->request("GET", "http://cvm.meritocracy.is/CVMServlet?type=rv2cs&id=$id&cache=3600&replace=true&threshold=0&thread=true&get=200&skills=0.7&frag=0&sen=0.3&industry=0.4&jf=0.4&edu=0.2&lang=0");
            Cache::forget("widget_vacancies_" . Auth::user()->company["id"]);


            return response()->json([], $response->getStatusCode());

        } else {
            return response()->json([], 401);

        }

    }


    public function sortVacancies()
    {
        if (Auth::check()) {
            $client = App::make('client.api');

            $vacancies = Input::get('vacancies');

            foreach ($vacancies as $index => $vacancy) {

                $params[] = ["sort" => $index];


            }


            $response = $client->request("PATCH", "/api/vacancy/" . implode(",", $vacancies), ['form_params' => $params]);
            if ($response->getStatusCode() != 204) {
                return response()->json([], 401);
            }

            return response()->json([], 204);

        } else {
            return response()->json([], 401);

        }
    }

    public function getHrVacancy($permalink)
    {


        $user = Auth::user();
        if ($user->type == "COMPANY" || $user->type == "ANALYTICS" || $user->type == "ADMINISTRATOR") {

            $client = App::make('client.api');

            if (Input::get("company-id")) {
                $response = $client->request('GET', "/api/company/" . Input::get("company-id") . "?serializerGroup[]=auth");
                $company = $response->getBody()->getContents();
                $company = json_decode($company, true);

                $user->company = $company;
            }

            if ($user->company["id"] == "" || !isset($user->company["id"])) {
                return redirect('/login');

            }


            $response = $client->request('GET', "/api/company/" . $user->company["id"] . "/vacancies");


            $vacancies = $response->getBody()->getContents();
            $vacancies = json_decode($vacancies, true);

            foreach ($vacancies as $vacancy) {
                if (isset($vacancy["permalink"]) && $vacancy["permalink"] == $permalink && (($vacancy['company']['id'] == $user->company['id'] && ($user->type == "COMPANY" || $user->type == "ANALYTICS")) || $user->type == "ADMINISTRATOR")) {

                    $idApplication = Input::get("__d", null);

                    return View::make('admin.candidates', ["idApplication" => explode("|", base64_decode($idApplication)), "feedback" => $user->feedback, "vacancies" => $vacancies, "route" => "vacancy", "vacancy" => $vacancy, "company" => $user->company, "title" => $vacancy["name"], "description" => $vacancy["description"]]);
                }
            }


        } else {
            return redirect('/login?err=Please login again');
        }

    }

    public function getDbCandidates($id)
    {
        $user = Auth::user();
        if ($user != null && $user->type == "COMPANY" || $user->type == "ANALYTICS") {

            $client = App::make('client.api');
            $response = $client->request('GET', "/api/category/" . $id);
            $cat = $response->getBody()->getContents();
            $category = json_decode($cat, true);

            $response = $client->request('GET', "/api/company/" . $user->company["id"] . "/vacancies");


            $vacancies = $response->getBody()->getContents();
            $vacancies = json_decode($vacancies, true);

            return View::make('admin.candidates-categories', ["feedback" => $user->feedback,
                "vacancies" => $vacancies, "route" => "vacancy", "category" => $category,
                "applications" => $category["categories_applications"], "company" => $user->company, "title" => $category["title"], "description" => ""]);


        } else {
            return redirect('/login?err=Please login again');
        }
    }

    public function getDbCategories()
    {
        $user = $this->make_get("/api/user/" . Auth::user()->id);
        return View::make('admin.my-candidates', ["user" => Auth::user(), "company" => $user["company"], "route" => "categories", "title" => "My Candidates", "description" => ""]);

    }

    public function searchCandidates($filter, $id)
    {
        $key = Input::get("term");

        //chiamata API di ricerca

        if ($key && trim($key) != "") {
            $client = App::make('client.api');
            $response = $client->request('GET', "/api/company/search-candidates/{$filter}/{$id}?key=" . $key);

            if ($response->getStatusCode() == 200) {

                $res = $response->getBody()->getContents();
                $res = json_decode($res, true);

                foreach ($res as $key => $application) {

                    if ($application['vacancy']['company']['id'] != Auth::user()->company['id']) {
                        unset($res[$key]);
                    }
                }


                return response()->json($res, 200);

            }


        }


        return Redirect::to('/');
    }


    public function getApplicationsByCategory($id)
    {
        $client = App::make('client.api');

        $response = $client->request('GET', "/api/category/" . $id . "");
        $category = json_decode($response->getBody()->getContents(), true);


        if (!empty($category['categories_application'])) {

            $sort = Input::get("sort");

            if (isset($sort) && $sort == "date") {
                usort($category['categories_applications'],
                    function ($a, $b) {
                        $result = 0;
                        if ($a['created_at'] < $b['created_at']) {
                            $result = 1;
                        } else if ($a['created_at'] > $b['created_at']) {
                            $result = -1;
                        }
                        return $result;
                    }
                );
            } else {

                usort($category['categories_applications'],
                    function ($a, $b) {
                        $result = 0;
                        if ($a['score_cvm']["total"] < $b['score_cvm']["total"]) {
                            $result = 1;
                        } else if ($a['score_cvm']["total"] > $b['score_cvm']["total"]) {
                            $result = -1;
                        }
                        return $result;
                    }
                );
            }


        }
        return response()->json($category['categories_applications'], 200);
    }


    public function getApplicationsByType($id, $type)
    {

        $client = App::make('client.api');

        $response = $client->request('GET', "/api/vacancy/" . $id . "/applications/" . strtoupper($type) . "?serializerGroup=summary");
        $applications = json_decode($response->getBody()->getContents(), true);

        if (!empty($applications)) {
            $user = Auth::user();

            foreach ($applications as $i => $application) {
                foreach ($application["events"] as $event) {
                    if ($event["status"] == "READ" && $event["author"]["id"] == $user->id) {
                        $applications[$i]["read"] = 1;
                        continue;
                    }
                    if ($event["status"] == "CONTACT" && $event["author"]["id"] == $user->id) {
                        $applications[$i]["contacted"] = 1;
                        continue;
                    }
                }
            }

            $sort = Input::get("sort");

            if (isset($sort) && $sort == "date") {
                usort($applications,
                    function ($a, $b) {
                        $result = 0;
                        if ($a['created_at'] < $b['created_at']) {
                            $result = 1;
                        } else if ($a['created_at'] > $b['created_at']) {
                            $result = -1;
                        }
                        return $result;
                    }
                );
            } else {

                usort($applications,
                    function ($a, $b) {
                        $result = 0;
                        if ($a['score_cvm']["total"] < $b['score_cvm']["total"]) {
                            $result = 1;
                        } else if ($a['score_cvm']["total"] > $b['score_cvm']["total"]) {
                            $result = -1;
                        }
                        return $result;
                    }
                );
            }

        }

        return response()->json($applications, 200);
    }


    public function getCv($id)
    {
        if (Auth::check()) {

            $client = App::make('client.api');

            $r = null;

            $id = base64_decode($id);

            if (!filter_var($id, FILTER_VALIDATE_URL) === false) {
                $r = $client->request('GET', $id);
            } else {
                $r = $client->request('GET', "http://meritocracy.jobs/includes/cv_mongo?key=94nr3BM70eMJFfvc2U6R92S10hUX8dIh&id=" . $id);

            }

            $response = Response::make($r->getBody()->getContents(), 200);
            $response->header('Content-Type', $r->getHeader('Content-type')[0]);


            return $response;

        } else {
            return response()->json([], 401);
        }
    }


}
