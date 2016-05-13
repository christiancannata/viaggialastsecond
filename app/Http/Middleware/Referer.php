<?php

namespace Meritocracy\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Referer
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (strpos(session('refererUrl'), "meritocracy") !== false) {
            $referer = "http://meritocracy.is";

            if (isset($_SERVER['HTTP_REFERER'])) {
                $referer = $_SERVER['HTTP_REFERER'];
            }

            $referer2=parse_url($referer);
            $referer=(isset($referer2['host']))?$referer2['host']:$referer;

            Session::set('refererUrl', str_replace("www.","",$referer));

        } else if (!session('refererUrl')) {
            $referer = "http://meritocracy.is";
            if (isset($_SERVER['HTTP_REFERER'])) {
                $referer = $_SERVER['HTTP_REFERER'];
            }

            $referer2=parse_url($referer);
            $referer=(isset($referer2['host']))?$referer2['host']:$referer;
            Session::set('refererUrl', str_replace("www.","",$referer));
        }
        if (!session('refererUrlAts')) {

            $referer = "http://meritocracy.is";
            if (isset($_SERVER['HTTP_REFERER'])) {
                $referer = $_SERVER['HTTP_REFERER'];
            }
            Session::set('refererUrlAts', $referer);
        }

        if (isset($_REQUEST["utm_source"]) && strlen($_REQUEST["utm_source"]) > 0) {
            Session::set('refererUrl', $_REQUEST["utm_source"]);
        }

        $ref = Session::get('refererUrl');

        return $next($request);
    }
}


