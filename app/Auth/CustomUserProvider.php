<?php namespace Meritocracy\Auth;

use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Auth\GenericUser;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Support\Facades\Session;
use Meritocracy\User;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;


class CustomUserProvider implements UserProvider
{

    protected $model;
    protected $app;

    public function __construct(UserContract $model, $app)
    {
        $this->model = $model;
        $this->app = $app;
    }


    public function retrieveById($identifier)
    {

        $client = $this->app->make('client.api');
       try{

           $response = $client->request('GET', "/api/user/" . $identifier."?serializerGroup=auth");

           $user = $response->getBody()->getContents();
           $user = json_decode($user, true);

           if (is_numeric($user['id'])) {
               return new GenericUser($user);
           } else {
               return null;
           }
       } catch (\Exception $e) {
           return null;

           if(!$e->getResponse() || $e->getResponse()->getStatusCode()==404){
           }
       }

    }

    public function retrieveByToken($identifier, $token)
    {
        $client = $this->app->make('client.api');

        try{
        $response = $client->request('GET', "/api/user/" . $token."?serializerGroup=auth");
        $user = $response->getBody()->getContents();


        $user = json_decode($user, true);

        return new GenericUser($user);
        } catch (\Exception $e) {
            return null;

            if(!$e->getResponse() || $e->getResponse()->getStatusCode()==404){
            }
        }
    }

    public function updateRememberToken(UserContract $user, $token)
    {

    }

    public function retrieveByCredentials(array $credentials)
    {
        $client = $this->app->make('client.api');

        if (isset($credentials["token"], $credentials["user"])) {

            $user = $credentials["user"];

        } else {

            Session::flash("login-redirect", "");
            try {

                $response = $client->request('POST', "/authenticate", ['form_params' => $credentials]);

                $user = $response->getBody()->getContents();
                $user = json_decode($user, true);

            } catch (BadResponseException $ex) {
                $user = $ex->getResponse()->getBody();
                $user = json_decode($user, true);

                Session::flash('login-error', $user['error']);
                return null;

            }


        }


        /*
                if ($user["authorizationLevel"] == 2 ) {
                    Session::flash("login-redirect" , "/hr");
                } */

        $user["data"]['id'] = $user['token'];

        return new GenericUser($user["data"]);


    }

    public function validateCredentials(UserContract $user, array $credentials)
    {

        if ($user) {
            return true;
        } else {
            return false;
        }
    }

}