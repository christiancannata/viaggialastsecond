<?php

namespace Meritocracy\Http\Controllers;

use Illuminate\Support\Facades\App;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
class UtilityController extends Controller
{


    /**
     * Instantiate a new UserController instance.
     */
    public function __construct()
    {

    }


    public function search($routeName)
    {

        $client = App::make('client.api');


        $type = Input::get("type");

        if ($routeName == "degree") {
            $response = $client->request('GET', "/api/" . $routeName . "/");
        } else {

            if ($routeName == "tags") {
                $response = $client->request('GET', "/api/" . $routeName . "/category/" . $type . "?key=" . Input::get("term"));
            } else {
                $response = $client->request('GET', "/api/" . $routeName . $type . "/search?key=" . Input::get("term"));
            }
        }


        if ($response->getStatusCode() == 200) {

            $res = $response->getBody()->getContents();
            $res = json_decode($res, true);


            if ($routeName == "tags") {


                if (App::getLocale() == "it") {
                    $this->sortBySubkey($res, 'name_it');
                } else {
                    $this->sortBySubkey($res, 'name');

                }
            }


            if ($routeName == "degree") {


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


                usort($degrees, array($this, 'compareByName'));

                $res = $degrees;

            }


            if ($routeName == "tags") {


                if (App::getLocale() == "it") {
                    $this->sortBySubkey($res, 'name_it');
                } else {
                    $this->sortBySubkey($res, 'name');

                }
            }

            return response()->json($res, 200);


        } else {

            return response()->json([], 500);
        }
    }


}
