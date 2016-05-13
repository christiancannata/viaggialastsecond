<?php

namespace Meritocracy\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Contracts\Validation\Validator;
use \Illuminate\Support\Facades\Auth;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    /**
     * {@inheritdoc}
     */
    protected function formatValidationErrors(Validator $validator)
    {
        return $validator->errors()->toArray();
    }



    private function strip_word_html($text, $allowed_tags = '<p><br><strong><i><b><u><ol><li><blockquote><italic><b><i><sup><sub><em><strong><u><br>')
    {
        mb_regex_encoding('UTF-8');
        //replace MS special characters first
        $search = array('/&lsquo;/u', '/&rsquo;/u', '/&ldquo;/u', '/&rdquo;/u', '/&mdash;/u');
        $replace = array('\'', '\'', '"', '"', '-');
        $text = preg_replace($search, $replace, $text);
        //make sure _all_ html entities are converted to the plain ascii equivalents - it appears
        //in some MS headers, some html entities are encoded and some aren't
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
        //try to strip out any C style comments first, since these, embedded in html comments, seem to
        //prevent strip_tags from removing html comments (MS Word introduced combination)
        if (mb_stripos($text, '/*') !== FALSE) {
            $text = mb_eregi_replace('#/\*.*?\*/#s', '', $text, 'm');
        }
        //introduce a space into any arithmetic expressions that could be caught by strip_tags so that they won't be
        //'<1' becomes '< 1'(note: somewhat application specific)
        $text = preg_replace(array('/<([0-9]+)/'), array('< $1'), $text);
        $text = strip_tags($text, $allowed_tags);
        //eliminate extraneous whitespace from start and end of line, or anywhere there are two or more spaces, convert it to one
        $text = preg_replace(array('/^\s\s+/', '/\s\s+$/', '/\s\s+/u'), array('', '', ' '), $text);
        //strip out inline css and simplify style tags
        $search = array('#<(strong|b)[^>]*>(.*?)</(strong|b)>#isu', '#<(em|i)[^>]*>(.*?)</(em|i)>#isu', '#<u[^>]*>(.*?)</u>#isu');
        $replace = array('<b>$2</b>', '<i>$2</i>', '<u>$1</u>');
        $text = preg_replace($search, $replace, $text);
        //on some of the ?newer MS Word exports, where you get conditionals of the form 'if gte mso 9', etc., it appears
        //that whatever is in one of the html comments prevents strip_tags from eradicating the html comment that contains
        //some MS Style Definitions - this last bit gets rid of any leftover comments */
        $num_matches = preg_match_all("/\<!--/u", $text, $matches);
        if ($num_matches) {
            $text = preg_replace('/\<!--(.)*--\>/isu', '', $text);
        }
        return $text;
    }

    public function compareByName($a, $b)
    {
        return strcmp(ucfirst($a["name"]), ucfirst($b["name"]));
    }


    public function make_get($apiRoute)
    {
        $client = app()->make('client.api');
        $response = $client->request('GET', $apiRoute);
        return json_decode($response->getBody()->getContents(), true);

    }


    public function randomPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public function sortBySubkey(&$array, $subkey, $sortType = SORT_ASC)
    {
        foreach ($array as $subarray) {
            if (!isset($subarray[$subkey])) {
                $subarray[$subkey] = 0;
            }
            $keys[] = ucfirst($subarray[$subkey]);
        }
        array_multisort($keys, $sortType, $array);
    }


    public function format_uri($string, $separator = '-')
    {
        $accents_regex = '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i';
        $special_cases = array('&' => 'and', "'" => '');
        $string = mb_strtolower(trim($string), 'UTF-8');
        $string = str_replace(array_keys($special_cases), array_values($special_cases), $string);
        $string = preg_replace($accents_regex, '$1', htmlentities($string, ENT_QUOTES, 'UTF-8'));
        $string = preg_replace("/[^a-z0-9]/u", "$separator", $string);
        $string = preg_replace("/[$separator]+/u", "$separator", $string);
        return $string;
    }

    public function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function date_compare($a, $b)
    {
        if (isset($a['data_fine']) && isset($b['data_fine'])) {
            $t1 = strtotime($a['data_fine']);
            $t2 = strtotime($b['data_fine']);
        } elseif (isset($a['end_date'])) {
            $t1 = strtotime($a['end_date']);
            $t2 = strtotime($b['end_date']);
        } elseif (isset($a['open_date'])) {
            $t1 = strtotime($a['open_date']);
            $t2 = strtotime($b['open_date']);
        } else {
            $t1 = strtotime($a['updated_at']);
            $t2 = strtotime($b['updated_at']);
        }

        return $t1 - $t2;
    }


// Make OnePage CRM API call
    public function make_api_call($url, $http_method, $post_data = array(), $uid = null, $key = null)
    {
        $full_url = 'https://app.onepagecrm.com/api/v3/' . $url;
        $ch = curl_init($full_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $http_method);
        $timestamp = time();
        $auth_data = array($uid, $timestamp, $http_method, sha1($full_url));
        $request_headers = array();
        // For POST and PUT requests we will send data as JSON
        // as with regular "form data" request we won't be able
        // to send more complex structures
        if ($http_method == 'POST' || $http_method == 'PUT') {
            $request_headers[] = 'Content-Type: application/json';
            $json_data = json_encode($post_data);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
            $auth_data[] = sha1($json_data);
        }
        // Set auth headers if we are logged in
        if ($key != null) {
            $hash = hash_hmac('sha256', implode('.', $auth_data), $key);
            $request_headers[] = "X-OnePageCRM-UID: $uid";
            $request_headers[] = "X-OnePageCRM-TS: $timestamp";
            $request_headers[] = "X-OnePageCRM-Auth: $hash";
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
        $result = json_decode(curl_exec($ch));
        curl_close($ch);
        if ($result->status > 99) {
            echo "API call error: {$result->message}\n";
            return null;
        }
        return $result;
    }

    protected function search($array, $key, $value)
    {
        $results = array();

        if (is_array($array)) {
            if (isset($array[$key]) && $array[$key] == $value) {
                $results[] = $array;
            }

            foreach ($array as $subarray) {
                $results = array_merge($results, $this->search($subarray, $key, $value));
            }
        }

        return $results;
    }


}
