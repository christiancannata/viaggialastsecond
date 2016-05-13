<?php

namespace Meritocracy\Http\Controllers;

use Illuminate\Support\Facades\App;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{


    /**
     * Instantiate a new UserController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');

    }


    public function getAdminDashboard()
    {


        $user = Auth::user();
        if ($user->type == "ADMINISTRATOR") {

            $client = App::make('client.api');
            $response = $client->request('GET', "/api/company?isSystemCompany=true&serializerGroup=admin");
            $companies = json_decode($response->getBody()->getContents(), true);

            usort($companies, array($this, "compareByName"));

            return View::make('admin.admin', array("companies" => $companies, "user" => $user, "description" => "", "title" => "Admin Dashboard"));
        } else {
            return redirect('/login');
        }
    }

    public function getTagsPage()
    {


        $user = Auth::user();
        if ($user->type == "ADMINISTRATOR") {

            $client = App::make('client.api');
            $response = $client->request('GET', "/api/company?isSystemCompany=true&serializerGroup=admin");
            $companies = json_decode($response->getBody()->getContents(), true);
            usort($companies, array($this, "compareByName"));

            return View::make('admin.tag-manager', array("companies" => $companies, "user" => $user, "description" => "", "title" => "Tag Manager"));
        } else {
            App::abort(403, 'Unauthorized action: you must be logged as administrator');
        }
    }


    public function createCodiceSconto()
    {
        $client = App::make('client.api');

        $inputs = Input::all();
        $inputs['is_active'] = true;

        $response = $client->request("POST", "/api/codice-sconto", ['form_params' => [$inputs]]);


        if ($response->getStatusCode() == 201 || $response->getStatusCode() == 204) {

            $resp = $response->getHeader("Location");
            $resp = explode("/", $resp[0]);

            return response()->json(["id" => end($resp)], 201);
        } else {
            return response()->json([], 401);
        }

    }



    public function updateCodiceSconto($id)
    {
        $client = App::make('client.api');

        $inputs = Input::all();
        $inputs['is_active'] = boolval($inputs['is_active']);

        $response = $client->request("PATCH", "/api/codice-sconto/".$id, ['form_params' => [$inputs]]);


        if ($response->getStatusCode() == 201 || $response->getStatusCode() == 204) {

            $resp = $response->getHeader("Location");
            $resp = explode("/", $resp[0]);

            return response()->json(["id" => end($resp)], 201);
        } else {
            return response()->json([], 401);
        }

    }



    public function getCodiciScontoPage()
    {


        $user = Auth::user();
        if ($user->type == "ADMINISTRATOR") {

            $client = App::make('client.api');
            $response = $client->request('GET', "/api/codice-sconto");
            $sconti = json_decode($response->getBody()->getContents(), true);

            if(empty($sconti)){
                $sconti=[];
            }
            return View::make('admin.codici-sconto', array("sconti" => $sconti, "user" => $user, "description" => "", "title" => "Codici Sconto"));
        } else {
            App::abort(403, 'Unauthorized action: you must be logged as administrator');
        }
    }


    public function getTagsJson()
    {


        $user = Auth::user();
        if ($user->type == "ADMINISTRATOR") {

            $client = App::make('client.api');
            $response = $client->request('GET', "/api/tags");
            $tags = json_decode($response->getBody()->getContents(), true);

            return response()->json($tags);
        } else {
            return redirect('/login');
        }
    }


    public function getStatisticsPage()
    {


        $user = Auth::user();
        if ($user->type == "ADMINISTRATOR") {

            $client = App::make('client.api');
            $response = $client->request('GET', "/api/company?isSystemCompany=true&serializerGroup=admin");
            $companies = json_decode($response->getBody()->getContents(), true);
            usort($companies, array($this, "compareByName"));

            return View::make('admin.statistiche', array("companies" => $companies, "user" => $user, "description" => "", "title" => "Admin Dashboard"));
        } else {
            return redirect('/login');
        }
    }


    public function getCompanyStatisticsPage($permalink)
    {

        $user = Auth::user();
        if ($user->type == "ADMINISTRATOR") {

            $client = App::make('client.api');
            $response = $client->request('GET', "/api/company?isSystemCompany=true&serializerGroup=admin");
            $companies = json_decode($response->getBody()->getContents(), true);


            usort($companies, array($this, "compareByName"));


            $response = $client->request('GET', "/api/company/$permalink?serializerGroup[]=systemCompany");
            $company = json_decode($response->getBody()->getContents(), true);

            return View::make('admin.statistiche-company', array("company" => $company, "companies" => $companies, "user" => $user, "description" => "", "title" => "Admin Dashboard"));
        } else {
            return redirect('/login');
        }
    }

    public function getAdminCompany($permalink)
    {
        $user = Auth::user();
        if ($user != null && $user->type == "ADMINISTRATOR") {


            $client = App::make('client.api');

            $response = $client->request('GET', "/api/company/" . $permalink . "?serializerGroup[]=auth");


            $company = $response->getBody()->getContents();
            $company = json_decode($company, true);


            $response = $client->request('GET', "/api/company/" . $company["id"] . "/vacancies");
            $vacancies = json_decode($response->getBody()->getContents(), true);


            if (!empty($vacancies)) {
                usort($vacancies, array($this, 'date_compare'));
                $vacancies = array_reverse($vacancies);
            }

            if (!empty($vacancies) && $vacancies[0]['sort'] != null) {
                $this->sortBySubkey($vacancies, 'sort');

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

            $companyIndustry = isset($company["industry"], $company["industry"]["id"]) ? $company["industry"]["id"] : -1;
            $companyLanguage = isset($company["language"], $company["language"]["id"]) ? $company["language"]["id"] : -1;


            $client = App::make('client.api');
            $response = $client->request('GET', "/api/company?isSystemCompany=true&serializerGroup=admin");
            $companies = json_decode($response->getBody()->getContents(), true);

            usort($companies, array($this, "compareByName"));


            $videos = "";
            if (isset(Auth::user()->company['videos'])) {
                $videos = Auth::user()->company['videos'];
                usort($videos, array($this, "compareByName"));

            }

            Auth::user()->company = $company;


            $hasCheckout = false;

            if (session()->has("checkout_done")) {
                $hasCheckout = session('checkout_done');

            }


            $hasCancel = false;

            if (session()->has("checkout_fail")) {
                $hasCancel = session('checkout_fail');

            }


            return View::make('admin.company', ["hasCheckout"=>$hasCheckout,"hasCancel"=>$hasCancel, "videos" => $videos, "companies" => $companies, "route" => "dashboard", "companyIndustry" => $companyIndustry, "companyLanguage" => $companyLanguage, "industries" => $industries, "languages" => $languages, "user" => $user, "vacancies" => $vacancies, "company" => $company, "title" => $company["name"], "description" => ""]);


        } else {
            return redirect('/login?err=Please login again');
        }
    }

    public function getAdminVacancy($company, $permalink)
    {
        $user = Auth::user();
        if ($user != null && $user->type == "ADMINISTRATOR") {


            $client = App::make('client.api');

            $response = $client->request('GET', "/api/company/" . $company . "/vacancies");

            $vacancies = $response->getBody()->getContents();
            $vacancies = json_decode($vacancies, true);

            foreach ($vacancies as $vacancy) {
                if ($vacancy["permalink"] == $permalink) {

                    $idApplication = Input::get("__d", null);

                    return View::make('admin.candidates', ["idApplication" => explode("|", base64_decode($idApplication)), "feedback" => $user->feedback, "vacancies" => $vacancies, "route" => "vacancy", "vacancy" => $vacancy, "company" => ["id" => $company], "title" => $vacancy["name"], "description" => $vacancy["description"]]);
                }
            }


        } else {
            return redirect('/login?err=Please login again');
        }

    }


}
