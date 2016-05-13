<?php

namespace Meritocracy\Http\Controllers;

use Cache;
use hisorange\BrowserDetect\Provider\BrowserDetectService;
use Illuminate\Support\Facades\App;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Jenssegers\Agent\Agent;
use Netshell\Paypal\Facades\Paypal;
use Moment\Moment;

class FrontendController extends Controller
{


    /**
     * Instantiate a new UserController instance.
     */
    public function __construct()
    {
        $this->middleware('referer');
        if (App::getLocale() == "it") {
            Moment::setLocale('it_IT');
        }


        $this->_apiContext = PayPal::ApiContext(
            config('services.paypal.client_id'),
            config('services.paypal.secret'));


        $this->_apiContext->setConfig(array(
            'mode' => (getenv('APP_ENV') == "local") ? 'sandbox' : 'live',
            'service.EndPoint' => (getenv('APP_ENV') == "local") ? 'https://api.sandbox.paypal.com' : 'https://api.paypal.com',
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => false,
            'log.FileName' => storage_path('logs/paypal.log'),
            'log.LogLevel' => 'FINE'
        ));


    }


    public function getRedirect($key)
    {
        $key = base64_decode($key);
        $key = explode("&*#", $key);
        return View::make('redirect', array("vacancy" => $key[3], "redirectUrl" => $key[2], "company" => $key[0], "logo" => $key[1], "route" => "redirect", "title" => "Redirecting", "description" => ""));
    }

    public function getHomepage()
    {


        $client = new \GuzzleHttp\Client(["base_uri" => ""]);

        //  $response = $client->request('GET', "http://partners.api.skyscanner.net/apiservices/browsequotes/v1.0/IT/EUR/it-IT/MXP/anywhere/2016-09/2016-09?sortorder=asc&sorttype=price&apiKey=ch993057195838657953325378101545", ['Content-Type' => "application/json"]);

        $response = $client->request('GET', "http://partners.api.skyscanner.net/apiservices/browsequotes/v1.0/IT/EUR/it-IT/IT/anywhere/anytime/anytime?apiKey=ch993057195838657953325378101545", ['Content-Type' => "application/json"]);

        $res = $response->getBody()->getContents();
        $res = json_decode($res, true);


        $places = $res["Places"];

        $results = $res['Quotes'];


        foreach ($results as $key => $res) {
            $partenzaIdOrigin = $this->search($places, "PlaceId", $res['OutboundLeg']["OriginId"])[0];
            $results[$key]["OutboundLeg"]["origin"] = $partenzaIdOrigin;


            $partenzaIdOrigin = $this->search($places, "PlaceId", $res['OutboundLeg']["DestinationId"])[0];
            $results[$key]["OutboundLeg"]["destination"] = $partenzaIdOrigin;

            $partenzaIdOrigin = $this->search($places, "PlaceId", $res['InboundLeg']["OriginId"])[0];
            $results[$key]["InboundLeg"]["origin"] = $partenzaIdOrigin;


            $partenzaIdOrigin = $this->search($places, "PlaceId", $res['InboundLeg']["DestinationId"])[0];
            $results[$key]["InboundLeg"]["destination"] = $partenzaIdOrigin;

        }


        $this->sortBySubkey($results,"MinPrice");


        die(var_dump($results));

    }


    public function getSearchPage()
    {
        $key = Input::get("key");

        //chiamata API di ricerca
        $response = null;
        if ($key && trim($key) != "") {
            $inTwoMonths = 60 * 60 * 24 * 60 + time();
            if (isset($_COOKIE['search'])) {
                $arraySearch = json_decode($_COOKIE['search'], true);

                if (!in_array($key, $arraySearch)) {
                    $arraySearch[] = $key;
                    setcookie("search", json_encode($arraySearch), $inTwoMonths);
                }
            } else {
                $arraySearch[] = $key;
                setcookie("search", json_encode($arraySearch), $inTwoMonths);
            }

            $client = App::make('client.api');

            $key = str_replace("!", "", $key);
            $key = str_replace("?", "", $key);

            $response = $client->request('GET', "/api/vacancy/search?key=" . $key);
        } else {
            return Redirect::to('/');
        }


        if ($response->getStatusCode() == 200) {

            $res = $response->getBody()->getContents();
            $res = json_decode($res, true);


            $numVacancies = 0;
            $pagine = 0;

            if (isset($res)) {

                $numVacancies = count($res);
                $pagine = round($numVacancies / 20);

                if (isset($res)) {
                    foreach ($res as $key2 => $vacancy) {

                        if ($vacancy['is_visible'] == false) {
                            unset($res[$key2]);
                        }
                    }
                }


                return View::make('search-result', ["route" => "search", "numVacancies" => $numVacancies, "customClass" => "jobs", "pagine" => $pagine, "vacancies" => $res, "key" => $key, "title" => "Cerca " . $key, "description" => ""]);

            }

        }


        return Redirect::to('/');
    }

    public function getLogin()
    {

        if (Auth::check()) {
            if (\Illuminate\Support\Facades\Auth::user()->type == "ADMINISTRATOR") {
                return redirect('/admin/dashboard');
            }
            return redirect('/user/dashboard');
        } else {
            return View::make('template.login.login', ["route" => "login", "title" => "Login", "description" => "Here you can Log In with Meritocracy"]);

        }

    }


    public function getRegisterUserPage()
    {
        return View::make('template.login.register-user', ["route" => "User registration", "title" => trans("common.register_manual_text"), "description" => "Here you can Sign Up as candidate / user to Meritocracy"]);

    }

    public function getPasswordRecoveryPage()
    {
        return View::make('template.login.password-recovery', ["route" => "Password Recovery", "title" => trans("common.lost_password_button"), "description" => "Here you can recover your lost password for your Meritocracy account"]);

    }

    public function getHomeCompanies($all)
    {
        if ($all == "all&limit=200") {
            return make_get("https://api.meritocracy.is/api/company?isSystemCompany=true&isVisible=true&orderBy[]=isPremium,DESC&orderBy[]=createdAt,DESC&orderBy[]=createdAt,DESC&serializerGroup=react&limit=200");
        } else if (App::getLocale() == "en") {
            return make_get("https://api.meritocracy.is/api/company?inHomeUk=true&isVisible=true&orderBy[]=datePremium,DESC&orderBy[]=datePremium,DESC&serializerGroup=react&limit=4&_=1460017464919");
        } else {
            return make_get("https://api.meritocracy.is/api/company?inHome=true&isVisible=true&orderBy[]=datePremium,DESC&orderBy[]=datePremium,DESC&serializerGroup=react&limit=4&_=1460017464919");
        }

    }


    public function getJobsPage()
    {


        if (App::getLocale() == "en") {
            $title = "Browse Jobs Opportunities";
            $description = "Find your dream jobs and careers opportunities and explore our companies";
        } else {
            $title = "Esplora opportunità lavorative";
            $description = "Esplora le nostre opportunità lavorative e le aziende per sviluppare le professionalità del futuro.";
        }

        $client = App::make('client.api');
        $response = $client->request('GET', "/api/tags/category/JOBFUNCTION");


        $jobFunctions = json_decode($response->getBody()->getContents(), true);


        $categories = [];

        foreach ($jobFunctions as $jobFunction) {

            if ($jobFunction['has_vacancy']) {
                $name = $jobFunction['name'];
                $link = "/job-opportunities/" . $jobFunction['permalink_en'];


                if (\Illuminate\Support\Facades\App::getLocale() == "it") {
                    $link = "/annunci-lavoro/" . $jobFunction['permalink_it'];
                    $name = $jobFunction['name_it'];

                }

                $categories[] = [
                    "name" => $name,
                    "link" => $link
                ];
            }

        }

        $companyOpenTab = false;

        if (Input::get("company")) {
            $companyOpenTab = true;
        }


        $route = "jobs";
        return View::make('jobs', ["companyOpenTab" => $companyOpenTab, "categories" => $categories, "route" => $route, "title" => $title, "description" => $description, "route" => "jobs"]);

    }

    public function getAreYouCompanyPage()
    {

        if (App::getLocale() == "en") {
            $title = "Attract your talents";
            $description = "Meritocracy helps you find and attract top Millennials. It boosts Employer Brand and brings it to the attention of the best candidates worldwide.";
        } else {
            $title = "Attrai i tuoi talenti";
            $description = "Meritocracy è il partner ideale per la tua strategia di talent attraction. Migliora il tuo Employer Brand e lo porta ai candidati giusti in tutto il mondo.";
        }

        $route = "are-you-company";
        return View::make('company', ["route" => $route, "title" => $title, "description" => $description]);
    }


    public function getManifestoPage()
    {


        if (App::getLocale() == "en") {
            $title = "About";
            $description = "Meritocracy helps people pinpoint the best jobs to grow and fulfil their potential. Work is the way each of us can put our passion and energy into creating value.";
        } else {
            $title = "Chi Siamo";
            $description = "Meritocracy aiuta le persone a trovare i migliori lavori dove crescere e far fruttare il talento. Con il lavoro, ciascuno di noi crea valore intorno a sé, con dedizione ed energia.";
        }


        $route = "manifesto";
        return View::make('manifesto', ["route" => $route, "title" => $title, "description" => $description, "customClass" => "technology-background technology"]);

    }

    public function goToWizard()
    {
        if (Auth::check()) {
            $route = "wizard-application";
            $res = make_get("/api/" . "tags" . "/category/" . "industry");


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


            usort($industries, array($this, 'compareByName'));


            return View::make('wizard-registration', ["industries" => $industries, "application" => null, "route" => $route, "title" => trans('wizard-application.title'), "description" => trans('wizard-application.description'), "customClass" => "technology-background technology wizard-application"]);

        }

    }


    public function getApplicationThankYouPage()
    {

        $id = Input::get("_appId", null);

        if ($id) {

            $client = App::make('client.api');

            $response = $client->request('GET', "/api/application/" . base64_decode($id));

            $application = $response->getBody()->getContents();
            $application = json_decode($application, true);


            if ($application['user']['is_complete']) {

                $route = "thankyou-application";

                return Redirect::to('/user/profile?completeApplication=1');
            }


            $route = "wizard-application";


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


            usort($industries, array($this, 'compareByName'));


            return View::make('wizard-application', ["industries" => $industries, "application" => $application, "route" => $route, "title" => trans('wizard-application.title'), "description" => trans('wizard-application.description'), "customClass" => "technology-background technology wizard-application"]);


        }
    }


    public function getRegistrationCompletedPage()
    {
        $route = "thankyou-registration";

        return View::make('thankyou-registration', ["route" => $route, "title" => trans('thankyou-registration.title'), "description" => trans('thankyou-registration.description'), "customClass" => "technology-background technology wizard-application"]);

    }


    public function getTechnologyPage()
    {

        $route = "technology";


        if (App::getLocale() == "en") {
            $title = "Technology Embracing Humanity";
            $description = "A technology that helps candidates to find the best opportunity to develop their talent and companies to screen candidates faster and better.";
        } else {
            $title = "La tecnologia incontra l'uomo";
            $description = "La tecnologia che aiuta i candidati a trovare la migliore opportunità per sviluppare il proprio talento e le aziende a scegliere meglio e rapidamente le persone su cui investire.";
        }


        return View::make('technology', ["route" => $route, "title" => $title, "description" => $description, "customClass" => "technology-background"]);

    }


    public function getMeritocracyBox($campaign, $id, $type)
    {
        header("Access-Control-Allow-Origin: *");

        switch ($type) {
            case "company" :
                if (!Cache::has("widget_vacancies_$id")) {
                    $vacancies = make_get("/api/vacancy?company=$id&serializerGroup=search");
                    Cache::put("widget_vacancies_$id", $vacancies, 3600);
                } else {
                    $vacancies = Cache::get("widget_vacancies_$id");
                }
                $company = $vacancies[0]["company"];
                $validVacancies = [];
                foreach ($vacancies as $key => $vacancy) {
                    if ($vacancy["is_visible_company_page"]) {
                        $validVacancies[] = $vacancy;
                    }
                }

                if (!empty($validVacancies)) {
                    usort($validVacancies, array($this, 'date_compare'));
                    $vacancies = array_reverse($validVacancies);
                }
                return View::make('vacancies-box', ["vacancies" => $vacancies, "company" => $company, "route" => "Vacancies Box", "title" => "Vacancies Box", "description" => "Vacancy"]);

                break;

            case "event" :

                if (!Cache::has("widget_events_$id")) {
                    $companies = make_get("/api/company?importId=$id&serializerGroup=systemCompany");
                    Cache::put("widget_events_$id", $companies, 3600);
                } else {
                    $companies = Cache::get("widget_events_$id");
                }

                return View::make('companies-box', ["campaign" => $campaign, "companies" => $companies, "route" => "Companies Box", "title" => "Companies Box", "description" => "Companies"]);

                break;

            default :
                return View::make('500', array("route" => "Error", "title" => "Error 500", "description" => "", "whiteLogo" => 1));
        }


    }


    public function getVacancyPage($company, $permalink)
    {

        if ($permalink == "l.proto" || $permalink == "56fd7c6867fd7135f5bd66ab" || $company == "company") {
            return View::make('404');

        }
        // Create a client with a base URI
        $client = App::make('client.api');
        $route = "job-page";

        $strAdd = "";
        if (isset($_COOKIE["timezone"])) {
            $strAdd .= "&timezone=" . $_COOKIE["timezone"];
        }
        $id = Auth::id();

        if (isset($id)) {
            $strAdd .= "&gs=" . $id;
        }

        $permalink = str_replace("_", "-", $permalink);


        try {


            $response = $client->request('GET', "/api/vacancy/$permalink?serializerGroup[]=application");


            $vacancy = $response->getBody()->getContents();
            $vacancy = json_decode($vacancy, true);


            if (isset($vacancy["name"])) {


                $now = new \DateTime();

                $closedDate = new \DateTime();

                if (isset($vacancy['closed_date'])) {
                    $closedDate = new \DateTime($vacancy['closed_date']);
                }

                if (!$vacancy['is_visible_company_page']) {
                    return Redirect::to($vacancy['company']['permalink']);
                }


                $intro = App::getLocale() == "en" ? "Job: " : "Lavoro: ";

                $city = "";
                try {
                    if (!empty($vacancy["city_plain_text"])) {
                        $city = " - " . $vacancy["city_plain_text"];
                    }
                } catch (\Exception $ee) {
                }

                $title = $intro . $vacancy['name'] . $city . " - " . $vacancy['company']['name'];
                $description = strip_tags($vacancy['description']);
                $url = "http://meritocracy.is/$company/$permalink";
                $company = $vacancy["company"];
                $image = "";

                if (isset($company["sliders"])) {
                    foreach ($company["sliders"] as $slider) {
                        if (!isset($slider["status"]) || $slider["status"]) {
                            $image = $slider["link"];
                            break;
                        }
                    }
                }


                $benefitArray = [];
                if (isset($vacancy['company']['benefits'])) {

                    foreach ($vacancy['company']['benefits'] as $benefit) {
                        $benefitArray[] = $benefit['name'];
                    }
                }

                if (isset($vacancy['company']['sliders'])) {

                    foreach ($vacancy['company']['sliders'] as $key => $slide) {
                        if ((isset($slide['status']) && $slide['status'] == false) || (isset($slide['visible']) && $slide['visible'] == false)) {
                            unset($vacancy['company']['sliders'][$key]);
                        }
                    }

                    $vacancy['company']['sliders'] = array_values($vacancy['company']['sliders']);
                }


                $benefitArray = implode(",", $benefitArray);


                $trackPageView = App::getLocale() . "/vacancy/" . $vacancy['company']['permalink'] . '/' . $vacancy['permalink'];


                $redirectUrl = "";
                if (!empty($vacancy["redirect_url"]) && strlen($vacancy["redirect_url"]) > 1) {
                    $redirectUrl = $vacancy["redirect_url"];
                } else if (!empty($company["redirect_url"]) && strlen($company["redirect_url"]) > 1) {
                    $redirectUrl = $company["redirect_url"];
                }
                $applied = false;

                if (Auth::check() && in_array($vacancy["id"], Auth::user()->vacancies_applicated)) {
                    $applied = true;
                }

                return View::make('vacancy', ["redirectUrl" => $redirectUrl, "trackPageView" => $trackPageView, "benefitArray" => $benefitArray, "applied" => $applied, "image" => $image, "url" => $url, "route" => $route, "title" => $title, "description" => $description, "vacancy" => $vacancy, "company" => $vacancy['company']]);
            } else {
                return View::make('404');
            }
        } catch (\Exception $ee) {
            $title = "Pagina non trovata";
            return View::make('404', ["route" => $route, "title" => $title, "description" => ""]);
        }


    }

    public function getRegisterCompanyPage()
    {
        $client = App::make('client.api');


        $response = $client->request('GET', "/api/" . "tags" . "/category/" . "industry");


        if ($response->getStatusCode() == 200) {

            $res = $response->getBody()->getContents();
            $res = json_decode($res, true);


            $industries = [];

            if (!empty($res)) {

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
            }

            return View::make('register-company', ["route" => "register-company", "industries" => $industries, "title" => trans('register-company.title'), "description" => trans("register-company.description")]);


        } else {

            return response()->json([], 500);
        }


    }

    function validBase64($string)
    {
        $decoded = base64_decode($string, true);
        // Check if there is no invalid character in strin
        if (!preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $string)) return false;

        // Decode the string in strict mode and send the responce
        if (!base64_decode($string, true)) return false;

        // Encode and compare it to origional one
        if (base64_encode($decoded) != $string) return false;

        return true;
    }

    public function getCompanyPage($permalink)
    {
        $client = App::make('client.api');


        if (Input::get("apply-id")) {


            $response = $client->request('GET', "/api/vacancy/" . Input::get("apply-id") . "&serializerGroup[]=application");
            $vacancy = $response->getBody()->getContents();
            $vacancy = json_decode($vacancy, true);

            if (isset($vacancy['permalink'])) {
                return Redirect::to($vacancy['company']['permalink'] . '/' . $vacancy['permalink']);
            }
        }

        try {
            $company = make_get("/api/company/$permalink?serializerGroup[]=systemCompany");


            if ($company) {
                error_reporting(0);


                $intro = App::getLocale() == "it" ? "Lavora con" : "Working at";

                $title = $intro . " " . $company['name'];
                $description = strip_tags($company['story']);
                $url = "http://meritocracy.is/$permalink";

                $image = "";

                $this->sortBySubkey($company["sliders"], 'ordering');
                if (isset($company["sliders"])) {
                    foreach ($company["sliders"] as $i => $slider) {
                        if (!isset($slider["status"]) || $slider["status"]) {
                            if ($company["is_premium"] && $company["avoid_watermark"] == false) {
                                if (!Cache::has('image_' . $slider["link"])) {
                                    $finalLink = base64_encode(file_get_contents("https://process.filestackapi.com/A8gsh1avRW6BM45L8W9tqz/watermark=f:CUPo1ZibSYqfEFf8IrIz,position:[top,right]/output=format:jpg,compress:true/" . str_replace(" ", "%20", $slider["link"])));
                                    Cache::forever('image_' . $slider["link"], $finalLink);
                                } else {
                                    $finalLink = Cache::get('image_' . $slider["link"]);
                                }
                                $company["sliders"][$i]["link"] = $this->validBase64($finalLink) ? $finalLink = "data:image/jpg;base64," . $finalLink : $finalLink;
                            } else if (strlen($image) <= 0) {
                                $image = $slider["link"];
                            }
                        }
                    }
                }

                if (isset($company["vacancies"])) {
                    $vacancies = [];
                    foreach ($company["vacancies"] as $key => $vacancy) {
                        if ($vacancy["is_visible_company_page"]) {
                            $vacancies[] = $vacancy;
                        }
                    }


                    if (!empty($vacancies)) {
                        usort($vacancies, array($this, 'date_compare'));
                        $company["vacancies"] = array_reverse($vacancies);
                    }

                    if (!empty($vacancies) && $vacancies != null) {
                        $this->sortBySubkey($vacancies, 'sort');
                    }

                }

                $route = "company-page";

                $trackPageView = App::getLocale() . "/company/" . $company['permalink'];

                return View::make('employer-page', ["trackPageView" => $trackPageView, "route" => $route, "image" => $image, "url" => $url, "title" => $title, "description" => $description, "company" => $company, "vacancies" => $vacancies, "customClass" => "no-background-image"]);
            } else {
                App::abort(404);
            }
        } catch (\Exception $e) {
            App::abort(404);
        }
    }


    public function getAnnunciLavoroPage($permalink)
    {
        Session::put('locale', "it");

        App::setLocale("it");
        //chiamata API di ricerca

        if ($permalink && trim($permalink) != "") {
            $client = App::make('client.api');
            try {


                $tagResponse = $client->request('GET', "/api/tags/" . $permalink);


                $res = $tagResponse->getBody()->getContents();
                $tag = json_decode($res, true);
            } catch (\Exception $e) {
                return Redirect::to('/');

            }
        }


        if ($tag) {

            try {
                $response = $client->request('GET', "/api/vacancy/job-function/" . $permalink);
                $res = $response->getBody()->getContents();
                $res = json_decode($res, true);


                $numVacancies = 0;
                $pagine = 0;

                if (isset($res)) {

                    $numVacancies = count($res);

                    $pagine = round($numVacancies / 20);


                    $tagName = $tag['name'];

                    if (App::getLocale() == "it") {


                        $tagName = $tag['name_it'];
                    }


                    if (isset($res)) {
                        foreach ($res as $key2 => $vacancy) {

                            if ($vacancy['is_visible'] == false) {
                                unset($res[$key2]);
                            }
                        }
                    }

                    $client = App::make('client.api');
                    $response = $client->request('GET', "/api/tags/category/JOBFUNCTION");


                    $jobFunctions = json_decode($response->getBody()->getContents(), true);


                    $categories = [];

                    foreach ($jobFunctions as $jobFunction) {

                        if ($jobFunction['has_vacancy']) {
                            $name = $jobFunction['name'];
                            $link = "/job-opportunities/" . $jobFunction['permalink_en'];


                            if (\Illuminate\Support\Facades\App::getLocale() == "it") {
                                $link = "/annunci-lavoro/" . $jobFunction['permalink_it'];
                                $name = $jobFunction['name_it'];

                            }

                            $categories[] = [
                                "name" => $name,
                                "link" => $link
                            ];
                        }

                    }


                    $description = "Trova annunci di lavoro in " . $tagName . " per mettere a frutto il tuo talento. In tutto il mondo.";


                    if (\Illuminate\Support\Facades\App::getLocale() != "it") {
                        $description = "Find jobs in " . $tagName . " to nurture your talent. Worldwide.";
                    }

                    return View::make('vacancy-category', ["categories" => $categories, "tag" => $tag, "route" => "vacancy-category", "numVacancies" => $numVacancies, "customClass" => "jobs", "pagine" => $pagine, "vacancies" => $res, "key" => $permalink, "title" => "Annunci Lavoro " . $tagName, "tagName" => $tagName, "description" => $description]);

                }
            } catch (\Exception $e) {
                return Redirect::to('/');

            }


        }


        return Redirect::to('/');
    }


    public function getAnnunciLavoroCittaPage($city)
    {

        //chiamata API di ricerca
        $client = App::make('client.api');


        if ($city) {

            $response = $client->request('GET', "/api/vacancy/searchbylocation?key=" . $city);
            $res = $response->getBody()->getContents();
            $res = json_decode($res, true);


            $numVacancies = 0;
            $pagine = 0;

            if (isset($res)) {

                $numVacancies = count($res);

                $pagine = round($numVacancies / 20);


                $tagName = ucfirst($city);


                if (isset($res)) {
                    foreach ($res as $key2 => $vacancy) {

                        if ($vacancy['is_visible'] == false) {
                            unset($res[$key2]);
                        }
                    }
                }

                $client = App::make('client.api');
                $response = $client->request('GET', "/api/tags/category/JOBFUNCTION");


                $jobFunctions = json_decode($response->getBody()->getContents(), true);


                $categories = [];

                foreach ($jobFunctions as $jobFunction) {

                    if ($jobFunction['has_vacancy']) {
                        $name = $jobFunction['name'];
                        $link = "/job-opportunities/" . $city . "/" . $jobFunction['permalink_en'];


                        if (\Illuminate\Support\Facades\App::getLocale() == "it") {
                            $link = "/annunci-lavoro/" . $city . "/" . $jobFunction['permalink_it'];
                            $name = $jobFunction['name_it'];

                        }

                        $categories[] = [
                            "name" => $name,
                            "link" => $link
                        ];
                    }

                }


                $description = "Trova annunci di lavoro in " . $tagName . " per mettere a frutto il tuo talento. In tutto il mondo.";


                if (\Illuminate\Support\Facades\App::getLocale() != "it") {
                    $description = "Find jobs in " . $tagName . " to nurture your talent. Worldwide.";
                }
                if (!empty($res)) {
                    usort($res, array($this, 'date_compare'));
                    $res = array_reverse($res);
                }
                return View::make('vacancy-city', ["categories" => $categories, "tag" => $tagName, "route" => "vacancy-category", "numVacancies" => $numVacancies, "customClass" => "jobs", "pagine" => $pagine, "vacancies" => $res, "key" => $tagName, "title" => "Annunci Lavoro " . $tagName, "tagName" => $tagName, "description" => $description]);

            }


        }


        return Redirect::to('/');
    }


    public function getAnnunciLavoroCittaCategoriaPage($city, $permalink)
    {


        //chiamata API di ricerca
        $client = App::make('client.api');


        if ($permalink && trim($permalink) != "") {
            $client = App::make('client.api');
            try {


                $tagResponse = $client->request('GET', "/api/tags/" . $permalink);


                $res = $tagResponse->getBody()->getContents();
                $tag = json_decode($res, true);
            } catch (\Exception $e) {
                return Redirect::to('/');

            }
        }


        if ($city && $tag) {

            $response = $client->request('GET', "/api/vacancy/searchbylocation?key=" . $city);
            $res = $response->getBody()->getContents();
            $res = json_decode($res, true);


            $numVacancies = 0;
            $pagine = 0;

            if (isset($res)) {

                $numVacancies = count($res);

                $pagine = round($numVacancies / 20);

                $tagName = $tag['name'];

                if (App::getLocale() == "it") {


                    $tagName = $tag['name_it'];
                }

                $tagName = $tagName . " - " . ucfirst($city);


                if (isset($res)) {
                    foreach ($res as $key2 => $vacancy) {


                        if (!isset($vacancy['job_function']) || $vacancy['is_visible'] == false || ($vacancy['job_function']['permalink_it'] != $permalink && $vacancy['job_function']['permalink_en'] != $permalink)) {
                            unset($res[$key2]);
                        }
                    }
                }

                $client = App::make('client.api');
                $response = $client->request('GET', "/api/tags/category/JOBFUNCTION");


                $jobFunctions = json_decode($response->getBody()->getContents(), true);


                $categories = [];

                foreach ($jobFunctions as $jobFunction) {

                    if ($jobFunction['has_vacancy']) {
                        $name = $jobFunction['name'];
                        $link = "/job-opportunities/" . $city . "/" . $jobFunction['permalink_en'];


                        if (\Illuminate\Support\Facades\App::getLocale() == "it") {
                            $link = "/annunci-lavoro/" . $city . "/" . $jobFunction['permalink_it'];
                            $name = $jobFunction['name_it'];

                        }

                        $categories[] = [
                            "name" => $name,
                            "link" => $link
                        ];
                    }

                }


                $description = "Trova annunci di lavoro in " . $tagName . " per mettere a frutto il tuo talento. In tutto il mondo.";


                if (\Illuminate\Support\Facades\App::getLocale() != "it") {
                    $description = "Find jobs in " . $tagName . " to nurture your talent. Worldwide.";
                }


                if (!empty($res)) {
                    usort($res, array($this, 'date_compare'));
                    $res = array_reverse($res);
                }


                return View::make('vacancy-city', ["categories" => $categories, "tag" => $tagName, "route" => "vacancy-category", "numVacancies" => $numVacancies, "customClass" => "jobs", "pagine" => $pagine, "vacancies" => $res, "key" => $tagName, "title" => "Annunci Lavoro " . $tagName, "tagName" => $tagName, "description" => $description]);

            }


        }


        return Redirect::to('/');
    }

    public function getJobOpportunitiesPage($permalink)
    {
        Session::put('locale', "en");

        App::setLocale("en");
        //chiamata API di ricerca

        if ($permalink && trim($permalink) != "") {
            $client = App::make('client.api');
            try {
                $tagResponse = $client->request('GET', "/api/tags/" . $permalink);
                $res = $tagResponse->getBody()->getContents();
                $tag = json_decode($res, true);
            } catch (\Exception $e) {
                return Redirect::to('/');

            }
        }


        if ($tag) {

            try {

                $response = $client->request('GET', "/api/vacancy/job-function/" . $permalink);
                $res = $response->getBody()->getContents();
                $res = json_decode($res, true);


                $numVacancies = 0;
                $pagine = 0;

                if (isset($res)) {
                    $numVacancies = count($res);

                    $pagine = round($numVacancies / 20);


                    $tagName = $tag['name'];

                    if (App::getLocale() == "it") {

                        $tagName = $tag['name_it'];
                    }


                    if (isset($res)) {
                        foreach ($res as $key2 => $vacancy) {

                            if ($vacancy['is_visible'] == false) {
                                unset($res[$key2]);
                            }
                        }
                    }


                    $client = App::make('client.api');
                    $response = $client->request('GET', "/api/tags/category/JOBFUNCTION");


                    $jobFunctions = json_decode($response->getBody()->getContents(), true);


                    $categories = [];

                    foreach ($jobFunctions as $jobFunction) {

                        if ($jobFunction['has_vacancy']) {
                            $name = $jobFunction['name'];
                            $link = "/job-opportunities/" . $jobFunction['permalink_en'];


                            if (\Illuminate\Support\Facades\App::getLocale() == "it") {
                                $link = "/annunci-lavoro/" . $jobFunction['permalink_it'];
                                $name = $jobFunction['name_it'];

                            }

                            $categories[] = [
                                "name" => $name,
                                "link" => $link
                            ];
                        }

                    }


                    return View::make('vacancy-category', ["categories" => $categories, "tag" => $tag, "route" => "vacancy-category", "numVacancies" => $numVacancies, "customClass" => "jobs", "pagine" => $pagine, "vacancies" => $res, "key" => $permalink, "title" => "Job Opportunities " . $tagName, "tagName" => $tagName, "description" => trans('vacancy-category.tag_page_description')]);

                }
            } catch (\Exception $e) {
                return Redirect::to('/');

            }

        }


        return Redirect::to('/');
    }


    public function getLandingAttraiTalenti()
    {
        Session::put('locale', "it");

        App::setLocale("it");


        $route = "landing-page-1";


        $title = trans($route . '.title_seo');
        $description = trans($route . '.description_seo');


        return View::make('landing-company', ["route" => $route, "title" => $title, "description" => $description, "route" => "landing-page-1"]);

    }


    public function getLandingAttractTalents()
    {
        Session::put('locale', "en");
        App::setLocale("en");

        $route = "landing-page-1";


        $title = trans($route . '.title_seo');
        $description = trans($route . '.description_seo');


        return View::make('landing-company', ["route" => $route, "title" => $title, "description" => $description, "route" => "landing-page-1"]);


    }


    public function getEmailHtml($permalink)
    {
        $email = Input::get("__d");

        //chiamata API di ricerca


        $client = App::make('client.api');


        $r = $client->request('GET', "/api/email-queue/" . base64_decode($email) . "/render");

        $response = Response::make($r->getBody()->getContents(), 200);
        $response->header('Content-Type', $r->getHeader('Content-type')[0]);

        return $response;
    }


    public function getStatwolf()
    {
        return Redirect::to('http://meritocracy.jobs/statwolf');

    }


    public function getSitemap()
    {
        return Redirect::to('/sitemap');

    }

    public function redirectRegisterCompanyPage()
    {
        return Redirect::to('/register/company');

    }

    public function getPromotionalEmployerBrand()
    {
        return Redirect::to('http://meritocracy.jobs/promotional/employer-brand');

    }


    public function getJobsFeedTrovit()
    {
        return Redirect::to('http://meritocracy.jobs/jobs-feed-trovit');

    }

    public function updateAttachment($id)
    {
        $client = App::make('client.api');

        $now = New \DateTime();
        $params[] = [
            "name" => Input::get("name"),
            "comment" => "CV name changed on " . $now->format("d/m/y h:m")
        ];

        $response = $client->request('PATCH', "api/attachment/" . $id, ['form_params' => $params]);
        if ($response->getStatusCode() == 204) {
            $resp = $response->getHeader("Location");
            $resp = explode("/", $resp[0]);

            return response()->json(["id" => end($resp)], 201);

        } else {
            return response()->json([], 500);
        }
    }


    public function apply()
    {

        $params = "";
        //  try {
        $client = App::make('client.api');

        $vacancyId = Input::get('vacancyId');

        $redirectMode = Input::get('redirectMode');


        if (in_array($vacancyId, Auth::user()->vacancies_applicated)) {
            return response()->json(["message" => "You are already applied for this position."], 409);
        }

        $coverletterUrl = Input::get('coverLetter');

        $user = Auth::user();


        $referUrl = Session::get('refererUrl');

        $urlRefer = $referUrl;
        $idCv = null;

        if (Input::get('cvUrl') && Input::get('cvUrl') != "") {


            $cv = Input::get('cvUrl');

            $now = new \DateTime();

            $cvName = $user->first_name . "_" . $user->last_name . "_" . $now->format("d/m/Y");

            $attach[] = [
                "comment" => "CV uploaded during the application",
                "type" => "CV",
                "name" => $cvName,
                "link" => $cv,
                "user" => [
                    "id" => $user->id
                ]
            ];
            $response = $client->request('POST', "/api/attachment", ['form_params' => $attach]);
            $resp = $response->getHeader("Location");
            $idCv = explode("/", $resp[0]);
            $idCv = end($idCv);

        }


        if (Input::get("cvId") && Input::get("cvId") != "") {
            $idCv = Input::get("cvId");
        }


        $active = Auth::user()->is_complete;

        if ($redirectMode == "true") {
            $active = 1;
        }


        $params = [
            "vacancy" => [
                "id" => $vacancyId
            ],
            "user" => [
                "id" => $user->id
            ],
            "cover_letter" => $coverletterUrl,
            "video_url" => Input::get('video'),
            "active" => $active,
            "status" => "SENT",
            "locale" => strtoupper(App::getLocale()),
            "referer_url" => $urlRefer,
            "premium_suggested" => (Input::get("premium_suggested") && Input::get("premium_suggested") != "") ? 1 : 0
        ];


        if ($idCv) {
            $params["cv"] = [
                "id" => $idCv
            ];
        }

        $response = $client->request('POST', "/api/application", ['form_params' => [$params]]);


        if ($response->getStatusCode() == 201) {
            $resp = $response->getHeader("Location");
            $resp = explode("/", $resp[0]);

            $response = $client->request('GET', "/api/vacancy/" . $vacancyId . "?serializerGroup[]=react");
            $vacancy = json_decode($response->getBody()->getContents(), true);

            $msg = [
                "company" => $vacancy["company"]["name"],
                "vacancy" => $vacancy["name"],
                "name" => $user->first_name,
            ];


            $send = new \DateTime();


            $subject = "";


            if ($active) {
                $subject = "Add more experiences to stand out to recruiters!";

                if (\Illuminate\Support\Facades\App::getLocale() == "it") {
                    $subject = "Arricchisci il tuo profilo per emergere!";
                }


                $sendReminder = new \DateTime();
                $sendReminder->add(new \DateInterval("P2D"));


                $emailData[] = [
                    "status" => "ENQUEUED",
                    "params" => $msg,
                    "subject" => $subject,
                    "sender" => [
                        "name" => "Meritocracy",
                        "email" => 'account@meritocracy.is'
                    ],
                    "recipient" => [
                        "name" => $user->first_name,
                        "email" => $user->email
                    ],
                    "language" => strtoupper(\Illuminate\Support\Facades\App::getLocale()),
                    "cc" => [],
                    "bcc" => [],
                    "method" => "INTERN",
                    "send_at" => $sendReminder->format("Y-m-d H:i"),
                    "template" => "USER_COMPLETE_PROFILE",
                    "user" => [
                        "id" => \Illuminate\Support\Facades\Auth::user()->id
                    ],
                    "application" => [
                        "id" => end($resp)
                    ]
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
                        "id" => end($resp)
                    ]
                ];


            } else {
                $subject = "Be careful! Your application has NOT been submitted correctly";

                if (\Illuminate\Support\Facades\App::getLocale() == "it") {
                    $subject = "Attenzione! La tua candidatura NON è stata completata correttamente.";
                }


                $sendReminder = new \DateTime();
                $sendReminder->setTimezone(new \DateTimeZone('Europe/Rome'));
                $sendReminder->add(new \DateInterval("PT30M"));

                $emailData[] = [
                    "status" => "ENQUEUED",
                    "params" => $msg,
                    "subject" => $subject,
                    "sender" => [
                        "name" => "Meritocracy",
                        "email" => 'account@meritocracy.is'
                    ],
                    "recipient" => [
                        "name" => $user->first_name,
                        "email" => $user->email
                    ],
                    "language" => strtoupper(\Illuminate\Support\Facades\App::getLocale()),
                    "cc" => [],
                    "bcc" => [],
                    "method" => "INTERN",
                    "send_at" => $sendReminder->format("Y-m-d H:i"),
                    "template" => "USER_APPLICATION_UNCOMPLETED",
                    "user" => [
                        "id" => \Illuminate\Support\Facades\Auth::user()->id
                    ],
                    "application" => [
                        "id" => end($resp)
                    ]
                ];


                $sendReminder = new \DateTime();
                $sendReminder->setTimezone(new \DateTimeZone('Europe/Rome'));

                $sendReminder->add(new \DateInterval("PT6H"));

                $emailData[] = [
                    "status" => "ENQUEUED",
                    "params" => $msg,
                    "subject" => $subject,
                    "sender" => [
                        "name" => "Meritocracy",
                        "email" => 'account@meritocracy.is'
                    ],
                    "recipient" => [
                        "name" => $user->first_name,
                        "email" => $user->email
                    ],
                    "language" => strtoupper(\Illuminate\Support\Facades\App::getLocale()),
                    "cc" => [],
                    "bcc" => [],
                    "method" => "INTERN",
                    "send_at" => $sendReminder->format("Y-m-d H:i"),
                    "template" => "USER_APPLICATION_UNCOMPLETED",
                    "user" => [
                        "id" => \Illuminate\Support\Facades\Auth::user()->id
                    ],
                    "application" => [
                        "id" => end($resp)
                    ]
                ];


                $sendReminder = new \DateTime();
                $sendReminder->setTimezone(new \DateTimeZone('Europe/Rome'));

                $sendReminder->add(new \DateInterval("P1D"));

                $emailData[] = [
                    "status" => "ENQUEUED",
                    "params" => $msg,
                    "subject" => $subject,
                    "sender" => [
                        "name" => "Meritocracy",
                        "email" => 'account@meritocracy.is'
                    ],
                    "recipient" => [
                        "name" => $user->first_name,
                        "email" => $user->email
                    ],
                    "language" => strtoupper(\Illuminate\Support\Facades\App::getLocale()),
                    "cc" => [],
                    "bcc" => [],
                    "method" => "INTERN",
                    "send_at" => $sendReminder->format("Y-m-d H:i"),
                    "template" => "USER_APPLICATION_UNCOMPLETED",
                    "user" => [
                        "id" => \Illuminate\Support\Facades\Auth::user()->id
                    ],
                    "application" => [
                        "id" => end($resp)
                    ]
                ];

            }


            $subject = "Your application for " . $vacancy["company"]["name"];
            if (\Illuminate\Support\Facades\App::getLocale() == "it") {
                $subject = "La tua candidatura per " . $vacancy["company"]["name"];
            }

            //EMAIL FEEDBACK 10 GIORNI
            $msg["giorni"] = "10";
            $send = new \DateTime();
            $send->add(new \DateInterval("P10D"));
            $emailData[] = [
                "status" => "ENQUEUED",
                "params" => $msg,
                "subject" => $subject,
                "sender" => [
                    "name" => "Meritocracy Account",
                    "email" => 'no-reply@meritocracy.is'
                ],
                "recipient" => [
                    "name" => $user->first_name,
                    "email" => $user->email
                ],
                "language" => strtoupper(\Illuminate\Support\Facades\App::getLocale()),
                "cc" => [],
                "bcc" => [],
                "method" => "INTERN",
                "send_at" => $send->format("Y-m-d H:i"),
                "template" => "MISSING_FEEDBACK",
                "user" => [
                    "id" => \Illuminate\Support\Facades\Auth::user()->id
                ],
                "application" => [
                    "id" => end($resp)
                ]
            ];


            //EMAIL FEEDBACK 20 GIORNI
            $msg["giorni"] = "20";

            $send = new \DateTime();
            $send->add(new \DateInterval("P20D"));
            $emailData[] = [
                "status" => "ENQUEUED",
                "params" => $msg,
                "subject" => $subject,
                "sender" => [
                    "name" => "Meritocracy Account",
                    "email" => 'no-reply@meritocracy.is'
                ],
                "recipient" => [
                    "name" => $user->first_name,
                    "email" => $user->email
                ],
                "language" => strtoupper(\Illuminate\Support\Facades\App::getLocale()),
                "cc" => [],
                "bcc" => [],
                "method" => "INTERN",
                "send_at" => $send->format("Y-m-d H:i"),
                "template" => "MISSING_FEEDBACK",
                "user" => [
                    "id" => \Illuminate\Support\Facades\Auth::user()->id
                ],
                "application" => [
                    "id" => end($resp)
                ]
            ];


            //EMAIL FEEDBACK 20 GIORNI
            $msg["giorni"] = "30";

            $send = new \DateTime();
            $send->add(new \DateInterval("P30D"));
            $emailData[] = [
                "status" => "ENQUEUED",
                "params" => $msg,
                "subject" => $subject,
                "sender" => [
                    "name" => "Meritocracy Account",
                    "email" => 'no-reply@meritocracy.is'
                ],
                "recipient" => [
                    "name" => $user->first_name,
                    "email" => $user->email
                ],
                "language" => strtoupper(\Illuminate\Support\Facades\App::getLocale()),
                "cc" => [],
                "bcc" => [],
                "method" => "INTERN",
                "send_at" => $send->format("Y-m-d H:i"),
                "template" => "APPLICATION_AUTOMATIC_REJECTED",
                "user" => [
                    "id" => \Illuminate\Support\Facades\Auth::user()->id
                ],
                "application" => [
                    "id" => end($resp)
                ]
            ];


            $params = [
                "templates" => "USER_COMPLETE_PROFILE"
            ];
            try {
                $client->request("POST", "/api/email-queue/dequeue/user/" . Auth::user()->id, ['form_params' => $params]);
            } catch (\Exception $e) {

            }


            try {
                $client->request("POST", "/api/email-queue", ['form_params' => $emailData]);

            } catch (\Exception $e) {

            }


            return response()->json(["id" => end($resp)], 201);
        } else {
            return response()->json([], 500);

        }
        /*
            } catch (\Exception $e) {
                return response()->json(["message" => "Internal server error, refresh the page and retry."], 500);

            }
         */

    }


    public function getSitemapXml()
    {


        // create new sitemap object
        $sitemap = App::make("sitemap");


        // add item to the sitemap (url, date, priority, freq)

        $translations = null;
        $now = new \DateTime();
        // $sitemap->setCache('laravel.sitemap', 3600);
// check if there is cached sitemap and build new only if is not
        if (1) {
            // add item with translations (url, date, priority, freq, images, title, translations)
            $translations = [];

            $translations = [
                ['language' => 'it', 'url' => URL::to("/it")],
            ];
            $sitemap->add(URL::to("/en"), $now->format('Y-m-d h:i:s'), '1', 'monthly', [], null, $translations);


            $translations = [
                ['language' => 'it', 'url' => URL::to("/it/jobs")],
            ];
            $sitemap->add(URL::to("/en/jobs"), $now->format('Y-m-d h:i:s'), '1', 'monthly', [], null, $translations);

            $translations = [
                ['language' => 'it', 'url' => URL::to("/it/company")],
            ];
            $sitemap->add(URL::to("/en/company"), $now->format('Y-m-d h:i:s'), '1', 'monthly', [], null, $translations);

            $translations = [
                ['language' => 'it', 'url' => URL::to("/it/login")],
            ];
            $sitemap->add(URL::to("/en/login"), $now->format('Y-m-d h:i:s'), '0.8', 'monthly', [], null, $translations);

            $translations = [
                ['language' => 'it', 'url' => URL::to("/it/register/user")],
            ];
            $sitemap->add(URL::to("/en/register/user"), $now->format('Y-m-d h:i:s'), '0.8', 'monthly', [], null, $translations);

            $translations = [
                ['language' => 'it', 'url' => URL::to("/it/password/recovery")],
            ];
            $sitemap->add(URL::to("/en/password/recovery"), $now->format('Y-m-d h:i:s'), '0.8', 'monthly', [], null, $translations);

            $translations = [
                ['language' => 'it', 'url' => URL::to("/it/manifesto")],
            ];
            $sitemap->add(URL::to("/en/manifesto"), $now->format('Y-m-d h:i:s'), '0.8', 'monthly', [], null, $translations);


            $translations = [
                ['language' => 'it', 'url' => URL::to("/it/tech")],
            ];
            $sitemap->add(URL::to("/en/tech"), $now->format('Y-m-d h:i:s'), '0.75', 'monthly', [], null, $translations);


            // get all posts from db
            $client = App::make('client.api');


            $response = $client->request('GET', "/api/company?isVisible=true&offset=0&serializerGroup=sitemap");
            $companies = json_decode($response->getBody()->getContents(), true);
            // add every post to the sitemap
            foreach ($companies as $company) {


                $sitemap->add(URL::to("/en/" . $company['permalink']), $now->format('Y-m-d h:i:s'), "0.7", "daily");
                $sitemap->add(URL::to("/it/" . $company['permalink']), $now->format('Y-m-d h:i:s'), "0.7", "daily");


                foreach ($company['vacancies'] as $vacancy) {
                    $translations = [
                    ];
                    if ($vacancy['is_visible']) {
                        $sitemap->add(URL::to("/en/" . $company['permalink'] . "/" . $vacancy['permalink']), $now->format('Y-m-d h:i:s'), "0.7", "daily");
                        $sitemap->add(URL::to("/it/" . $company['permalink'] . "/" . $vacancy['permalink']), $now->format('Y-m-d h:i:s'), "0.7", "daily");
                    }

                }

            }


            $response = $client->request('GET', "/api/tags/category/JOBFUNCTION");
            $jobFunctions = json_decode($response->getBody()->getContents(), true);
            foreach ($jobFunctions as $jobFunction) {

                $sitemap->add("http://meritocracy.is/job-opportunities/" . $jobFunction['permalink_en'], $now->format('Y-m-d h:i:s'), "0.7", "daily");
                $sitemap->add("http://meritocracy.is/annunci-lavoro/" . $jobFunction['permalink_it'], $now->format('Y-m-d h:i:s'), "0.7", "daily");
            }

        };


        // show your sitemap (options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
        return $sitemap->render('xml');

    }


    public function checkoutPaypal(Request $request)
    {

        $params = Input::all();

        $total = $params['total'];
        $payer = Paypal::Payer();
        $payer->setPaymentMethod('paypal');

        $amount = PayPal:: Amount();
        $amount->setCurrency('EUR');


        $amount->setTotal($total); // This is the simple way,
        // you can alternatively describe everything in the order separately;
        // Reference the PayPal PHP REST SDK for details.

        if (!isset($params['vacancyId'])) {
            $params['vacancyId'] = $params['id'];
        }
        if (!isset($params['vacancyAddName'])) {
            $params['vacancyAddName'] = $params['name'];
        }


        $transaction = PayPal::Transaction();
        $transaction->setAmount($amount);
        $transaction->setDescription('Sponsored Vacancy - #' . $params['vacancyId'] . ' - ' . $params['vacancyAddName']);
        $transaction->setCustom("codiceScontoId=" . $params['codiceScontoId'] . "&codiceSconto=" . $params['codiceSconto'] . "&name=" . $params['vacancyAddName'] . "&vacancyId=" . $params['vacancyId'] . "&userId=" . Auth::user()->id);
        $redirectUrls = PayPal::RedirectUrls();
        $redirectUrls->setReturnUrl(action('FrontendController@getDone'));
        $redirectUrls->setCancelUrl(action('FrontendController@getCancel'));

        $payment = PayPal::Payment();
        $payment->setIntent('sale');
        $payment->setPayer($payer);
        $payment->setRedirectUrls($redirectUrls);

        $payment->setTransactions(array($transaction));

        $response = $payment->create($this->_apiContext);


        $redirectUrl = $response->links[1]->href;

        $token = explode("token=", $redirectUrl);


        $client = App::make('client.api');
        $client->request("PATCH", "/api/vacancy/" . $params['vacancyId'], ['form_params' => [["paypal_token" => $token[1]]]]);


        return response()->json(["token" => $token[1], "url" => $response->links[1]->href], 201);
    }


    public function getDone(\Illuminate\Http\Request $request)
    {

        $id = $request->get('paymentId');
        $token = $request->get('token');
        $payer_id = $request->get('PayerID');

        $payment = PayPal::getById($id, $this->_apiContext);

        $paymentExecution = PayPal::PaymentExecution();

        $paymentExecution->setPayerId($payer_id);

        $transaction = $payment->getTransactions();
        $customParams = [];
        parse_str($transaction[0]->getCustom(), $customParams);


        $total = $transaction[0]->getAmount()->getTotal() . " " . $transaction[0]->getAmount()->getCurrency();

        $date = new \DateTime();

        $params = [
            "paypal_transaction_id" => $id,
            "payment_date" => $date->format("Y-m-d H:i:s"),
            "is_sponsored" => true,
            "paypal_total" => $total
        ];

        if (isset($customParams['codiceScontoId']) && $customParams['codiceScontoId'] != "" && $customParams['codiceScontoId'] != "undefined") {
            $params['codice_sconto'] = [
                "id" => $customParams['codiceScontoId']
            ];
        }

        try {
            $executePayment = $payment->execute($paymentExecution, $this->_apiContext);

            $client = App::make('client.api');
            $response = $client->request("PATCH", "/api/vacancy/" . $customParams['vacancyId'], ['form_params' => [$params]]);

        } catch (\PayPal\Exception\PayPalConnectionException $ex) {

        }


        // Clear the shopping cart, write to database, send notifications, etc.

        // Thank the user for the purchase
        $customParams["idPayment"] = $id;
        $customParams['total'] = $total;
        $customParams['first_name'] = Auth::user()->first_name;


        $subject = "Your payment receipt #" . $id;


        //EMAIL NOTIFICA APPLICATION
        $emailData[] = [
            "status" => "ENQUEUED",
            "params" => $customParams,
            "subject" => $subject,
            "sender" => [
                "name" => "Meritocracy",
                "email" => 'billing@meritocracy.is'
            ],
            "recipient" => [
                "name" => Auth::user()->first_name,
                "email" => Auth::user()->email
            ],
            "language" => strtoupper(\Illuminate\Support\Facades\App::getLocale()),
            "cc" => [],
            "bcc" => [
                "name" => "Meritocracy",
                "email" => "billing@meritocracy.is"
            ],
            "method" => "INTERN",
            "template" => "PAYMENT_SUCCESS",
            "user" => [
                "id" => \Illuminate\Support\Facades\Auth::user()->id
            ],
            "vacancy" => [
                "id" => $customParams['vacancyId']
            ]
        ];


        try {
            $client->request("POST", "/api/email-queue", ['form_params' => $emailData]);

        } catch (\Exception $e) {

        }


        $params = [
            "templates" => "ALERT_SPONSOR_VACANCY"
        ];
        try {
            $client->request("POST", "/api/email-queue/dequeue/vacancy/" . $customParams['vacancyId'], ['form_params' => $params]);
        } catch (\Exception $e) {

        }


        return Redirect::to('/hr')->with('checkout_done', $customParams);


    }

    public function getCancel(\Illuminate\Http\Request $request)
    {

        $token = $request->get('token');

        $client = App::make('client.api');

        $response = $client->request("GET", "/api/vacancy?paypalToken=" . urlencode($token));

        $vacancy = json_decode($response->getBody()->getContents(), true);
        $vacancy = $vacancy[0];


        $client = App::make('client.api');
        $response = $client->request("PATCH", "/api/vacancy/" . $vacancy['id'], ['form_params' => [["is_sponsored" => false]]]);

        // Curse and humiliate the user for cancelling this most sacred payment (yours)
        return Redirect::to('/hr')->with('checkout_fail', $vacancy);
    }

}
