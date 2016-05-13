<?php

namespace Meritocracy\Http\Controllers;

use Illuminate\Support\Facades\App;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Facebook;

class AuthController extends Controller
{


    /**
     * Instantiate a new UserController instance.
     */
    public function __construct()
    {

    }


    public function getAuthFacebook()
    {
        return \Laravel\Socialite\Facades\Socialite::driver('facebook')->scopes(['email', 'user_birthday', 'user_about_me', 'user_location'])->redirect();

    }


    public function getAuthFacebookCallback()
    {

        try {
            $user = \Laravel\Socialite\Facades\Socialite::driver('facebook')->user();

            // grab credentials from the request

            $response = Auth::attempt(['email' => $user['email'], 'facebookId' => $user['id'], "facebook_user" => $user]);

            if ($response === true) {

                return response()->redirectTo("/close");

            } else {

                return response()->json(["message" => trans('common.login_error')], 401);

            }
        } catch (\Exception $ee) {
            var_dump($ee->getMessage());
            return response()->json(["message" => trans('common.auth_fb_error')], 401);
        }
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


    public function postLogin()
    {

        $email = strlen(Input::get('email')) > 0 ? Input::get('email') : Input::get("username");
        $password = Input::get('password');


        $response = Auth::attempt(['email' => $email, 'password' => $password]);
        if ($response === true) {
            return response()->json(["message" => Session::get('login-redirect')], 200);

        } else {

            return response()->json(["message" => trans('common.login_error')], 401);

        }
    }


    public function postRecoverPassword()
    {
        $client = App::make('client.api');

        $inputs = Input::all();


        $method = "POST";
        $route = "/api/user/recover-password";

        unset($inputs['id_work_experience']);
        $response = $client->request($method, $route, ['form_params' => $inputs]);


        if ($response->getStatusCode() == 201 || $response->getStatusCode() == 204) {
            $resp = $response->getHeader("Location");
            $resp = explode("/", $resp[0]);

            return response()->json(["id" => end($resp)], 201);
        } else {
            return response()->json([], 401);
        }
    }


    public function postPasswordReset()
    {
        $client = App::make('client.api');

        $inputs = Input::all();

        $token = base64_decode($inputs["token"]);

        $method = "GET";
        $route = "/api/user?forgotPasswordToken=$token";
        $response = $client->request($method, $route);
        $user = json_decode($response->getBody()->getContents(), true);

        if (!empty($user)) {

            $user = reset($user);


            if (isset($user["id"])) {

                $params[] = [
                    "password" => Hash::make($inputs['password']),
                    "forgot_password_token" => $this->generateRandomString(20)
                ];

                $response = $client->request("PATCH", "/api/user/" . $user["id"], ['form_params' => $params]);


                if ($response->getStatusCode() == 201 || $response->getStatusCode() == 204) {

                    $resp = $response->getHeader("Location");
                    $resp = explode("/", $resp[0]);

                    return response()->json(["id" => end($resp)], 204);
                } else {
                    return response()->json(["message" => "error during patching user"], 500);
                }
            } else {
                return response()->json(["message" => "error during patching user"], 500);
            }

        } else {
            return response()->json(["message" => "Please check that you have requested the password one more time and click on the last mail for recovery password request"], 401);
        }

    }


    public function postPasswordModify()
    {
        $client = App::make('client.api');

        $inputs = Input::all();
        $id = Auth::id();

        $method = "PATCH";
        $route = "/api/user/" . $id;


        if (isset($inputs['vecchia_password']) && password_verify($inputs['vecchia_password'], Auth::user()->password)) {
            if ($inputs['nuova_password'] == $inputs['conferma_nuova_password']) {
                if (strlen($inputs['nuova_password']) >= 6) {

                    $params[] = [
                        "password" => Hash::make($inputs['nuova_password'])
                    ];

                    $response = $client->request($method, $route, ['form_params' => $params]);


                    if ($response->getStatusCode() == 201 || $response->getStatusCode() == 204) {

                        $resp = $response->getHeader("Location");
                        $resp = explode("/", $resp[0]);


                        return response()->json(["id" => end($resp)], 204);
                    } else {
                        return response()->json([], 500);
                    }
                } else {
                    return response()->json(["message" => "Password must be at least six characters"], 401);
                }

            } else {
                return response()->json(["message" => "The new password entered are not the same"], 401);
            }
        } else {
            return response()->json(["message" => "Your current password is incorrect"], 401);
        }

    }

    public function getPasswordReset($token)
    {
        return View::make('admin.reset-password', ["token" => $token, "route" => "reset-password", "title" => "Recover your password", "description" => "Here you can recover your password"]);

    }


    public function passwordRecovery($email)
    {
        $client = App::make('client.api');


        //Find user by Email Address
        $method = "GET";
        $route = "/api/user?email=$email&serializerGroup=auth";

        $response = $client->request($method, $route);
        $user = json_decode($response->getBody()->getContents(), true);

        if (!empty($user)) {
            $user = $user[0];
            $userId = $user["id"];

            //Add a token to recover their password
            $method = "PATCH";
            $route = "/api/user/" . $userId;
            $token = $this->randomPassword();
            $arrayParams[] = [
                "forgot_password_token" => $token
            ];


            $response = $client->request($method, $route, ['form_params' => $arrayParams]);


            if ($response->getStatusCode() == 201 || $response->getStatusCode() == 204) {


                $msg = [
                    "name" => $user["first_name"],
                    "token" => base64_encode($token)
                ];


                $subject = $user["first_name"] . ", your password recovery change";
                if (\Illuminate\Support\Facades\App::getLocale() == "it") {
                    $subject = "Recupera la tua password";
                }


                $emailData = [
                    "status" => "ENQUEUED",
                    "params" => $msg,
                    "subject" => $subject,
                    "recipient" => [
                        "name" => $user["first_name"],
                        "email" => $user["email"]
                    ],
                    "cc" => [],
                    "bcc" => [],
                    "language" => strtoupper(\Illuminate\Support\Facades\App::getLocale()),
                    "sender" => [
                        "name" => "Meritocracy Account",
                        "email" => 'account@meritocracy.is'
                    ],
                    "method" => "INTERN",
                    "template" => "PASSWORD_RECOVERY_MAIL",
                ];


                $client = App::make('client.api');

                try {
                    $response = $client->request("POST", "/api/email-queue", ['form_params' => [$emailData]]);

                } catch (\Exception $e) {
                }


                return response()->json(["message" => "Password recovered successfully",], 204);
            } else {
                return response()->json([], 500);
            }

        }

        return response()->json([], 500);
    }


    public function logout()
    {
        Auth::logout();
        $cookie = Cookie::forget('logged');
        return Redirect::back()->with('message', 'Operation Successful !')->withCookie($cookie);
    }


    public function getLinkedinCallback()
    {

        $user = \Laravel\Socialite\Facades\Socialite::driver('linkedin')->user();


        // grab credentials from the request

        $response = Auth::attempt(['email' => $user->email, 'linkedinId' => $user->id, "linkedin_user" => $user]);

        if ($response === true) {

            return response()->redirectTo("/close");

        } else {

            return response()->json(["message" => trans('common.login_error')], 401);

        }
    }


    public function getLinkedinAuth()
    {
        return \Laravel\Socialite\Facades\Socialite::driver('linkedin')->redirect();

    }


}
