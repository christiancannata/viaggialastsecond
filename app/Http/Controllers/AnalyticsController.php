<?php

namespace Meritocracy\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class AnalyticsController extends Controller
{


    /**
     * Instantiate a new UserController instance.
     */
    public function __construct()
    {

    }


    public function getTopScoreReferral($type, $id)
    {
        $client = App::make('client.api');

        $response = $client->request('GET', "/api/" . $type . "/" . $id . "/referral");
        $datas = json_decode($response->getBody()->getContents(), true);

        $referrals = $datas['buckets'];


        $arrayReferrals = [];
        foreach ($referrals as $key => $referral) {
            $arrayReferrals[$key]["Referral"] = $referral['key'];
            $arrayReferrals[$key]["Count"] = $referral["height_stats"]['count'];
            $arrayReferrals[$key]["Score"] = number_format((float)$referral["height_stats"]['avg'], 2, '.', '');
        }

        if (!empty($arrayReferrals))
            $this->sortBySubkey($arrayReferrals, 'Score');


        return response()->json(array_reverse($arrayReferrals));

    }

    public function getReferral($type, $id)
    {

        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', "http://www.colourlovers.com/api/colors/top?format=json&numResults=20");
        $colors = json_decode($response->getBody()->getContents(), true);


        $client = App::make('client.api');

        $response = $client->request('GET', "/api/" . $type . "/" . $id . "/referral?" . $_SERVER['QUERY_STRING']);
        $datas = json_decode($response->getBody()->getContents(), true);

        $referrals = $datas['buckets'];


        $total = 0;

        foreach ($referrals as $referral) {
            $total += $referral['doc_count'];
        }

        $limit = 8;
        if (Input::get("limit")) {
            $limit = Input::get("limit");
        }

        if (count($referrals) < $limit) {
            $limit = 5;
        }


        $arrayReferrals = [];

        foreach (array_slice($referrals, 0, $limit) as $key => $referral) {
            if ($referral['doc_count'] > 0 && $total > 0) {
                $arrayReferrals[$key]["value"] = number_format((float)($referral['doc_count'] / $total) * 100, 2, '.', '');

            } else {
                $arrayReferrals[$key]["value"] = 0;

            }
            $arrayReferrals[$key]["label"] = $referral['key'] . " (" . number_format((float)$referral["height_stats"]['avg'], 2, '.', '') . ")";
            $arrayReferrals[$key]["labelColor"] = "white";
            $arrayReferrals[$key]["labelFontSize"] = "16";
            $arrayReferrals[$key]["avgScore"] = $referral["height_stats"]['avg'];
            $arrayReferrals[$key]["color"] = "#" . $colors[$key]["hex"];
            $arrayReferrals[$key]["highlight"] = "#" . $colors[$key]["hex"];
        }

        $value = 0;

        $color = "#" . $colors[$limit]["hex"];
        $highlight = $color;

        $score = 0;
        $i = 0;

        foreach (array_slice($referrals, $limit - 1, count($referrals)) as $key => $referral) {
            $i++;
            $value += $referral['doc_count'];
            $score += $referral["height_stats"]['avg'];
        }


        if ($value > 0 && $total > 0) {
            $arrayReferrals[count($arrayReferrals)]["value"] = number_format((float)($value / $total) * 100, 2, '.', '');
            $score = (float)$score / $i;
        } else {
            $arrayReferrals[count($arrayReferrals)]["value"] = 0;
            $score = 0;
        }

        $label = "Altri Referral (" . number_format((float)$score, 2, '.', '') . ")";


        $arrayReferrals[$limit]["label"] = $label;
        $arrayReferrals[$limit]["color"] = $color;
        $arrayReferrals[$limit]["labelColor"] = "white";
        $arrayReferrals[$limit]["labelFontSize"] = "16";
        $arrayReferrals[$limit]["highlight"] = $highlight;

        return response()->json($arrayReferrals);

    }

    public function getApplicationsTrend($type, $id)
    {
        $client = App::make('client.api');

        $grouped = Input::get("dateGroup", "day");
        $from = Input::get("from",null);
        $to = Input::get("to", null);

        if(!$from && !$to){
            $from = new \DateTime();
            $to = new \DateTime();
            $from->sub(new \DateInterval("P8D"));
            $to->sub(new \DateInterval("P1D"));
            $from=$from->format("d-m-Y");
            $to=$to->format("d-m-Y");
        }


        $response = $client->request('GET', "/api/" . $type . "/" . $id . "/applications?grouped=" . $grouped . "&from=" . $from . "&to=" . $to);
        $datas = json_decode($response->getBody()->getContents(), true);

        $referrals = $datas;

        return response()->json($referrals);
    }


    public function getAnalytics()
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->type != "USER") {

                $client = App::make('client.api');
                $response = $client->request('GET', "/api/analytics?" . $_SERVER['QUERY_STRING']);
                return response($response->getBody()->getContents())->header('Content-Type', 'application/json');
            } else {
            }
        }


    }


    public function getCompanyAnalytics($id)
    {
        $user = Auth::user();
        if ($user->type != "USER") {


            if (!Cache::has(Input::get("permalink") . "_statistic_cache") && !Input::get("disabledCache")) {
              //  return View::make('admin.partial-statistics-company', Cache::get(Input::get("permalink") . "_statistic_cache"));
            }


            $limit = 8;
            if (Input::get("limit")) {
                $limit = Input::get("limit");
            }

            $client = new \GuzzleHttp\Client();

            $response = $client->request('GET', "http://www.colourlovers.com/api/colors/top?format=json&numResults=40");
            $colors = json_decode($response->getBody()->getContents(), true);


            $client = App::make('client.api');

            //PERCENTUALE FONTI VISITE

            $dal = Input::get("from", "P15D");
            $al = Input::get("to", "P1D");

            $sorgenti = $this->getSorgentiTraffico(Input::get("filters"), $colors, $dal, $al);
            $arrayReferrals = $sorgenti['arrayReferrals'];
            $totalReferralPageViews = $sorgenti['total'];

            //TREND VISITE ULTIMI 14 GIORNI A CONFRONTO


            $response = $client->request('GET', "/api/analytics?" . $_SERVER['QUERY_STRING']);
            $visits = json_decode($response->getBody()->getContents(), true);

            $countVisitsPeriod1 = 0;
            $countVisitsPeriod2 = 0;

            foreach ($visits as $visit) {
                $countVisitsPeriod2 += $visit['pageView'];
            }

            $total = count($visits);


            $percentCompareVisits = 0;

            //APPLICATIONS ULTIMI 14 GIORNI A CONFRONTO

            $response = $client->request('GET', "/api/company/" . $id . "/applications?grouped=day&from={$dal}&to={$al}");
            $datas = json_decode($response->getBody()->getContents(), true);

            $countApplicationsPeriod1 = 0;
            $countApplicationsPeriod2 = 0;


            $total = count($datas);

            $totalApplicationsPeriod = 0;
            foreach ($datas as $visit) {

                $totalApplicationsPeriod += $visit['applications'];
            }


            $percentCompareApplications = 0;


            //TREND SCORE ULTIMI 14 GIORNI A CONFRONTO

            $trendScoreA = $this->getTrendScore("company", $id, $dal, $al);
            $scores = $trendScoreA['scores'];

            $totalePunteggio=0;
            foreach($scores as $score){

                $totalePunteggio+=$score['height_stats']['avg'];
            }
            $punteggioMedio=0;
            if(!empty($scores)){
                $punteggioMedio = $totalePunteggio / count($scores);

            }

            $response = $client->request('GET', "/api/company/" . $id . "/applications?countMode=true&from={$dal}&to={$al}");
            $applicationsTotal = json_decode($response->getBody()->getContents(), true);

            $countTotalApplication = 0;
            foreach ($applicationsTotal as $appl) {

                $countTotalApplication += $appl['doc_count'];
            }


            $rejectedStatistics = $this->getApplicationsReferralStatisticFiltered("company", $id, "STARRED", $limit, $colors, $dal, $al);
            $totalLiked = $rejectedStatistics['total'];
            $arrayReferralsStarred = $rejectedStatistics['arrayReferrals'];


            $rejectedStatistics = $this->getApplicationsReferralStatisticFiltered("company", $id, "REJECTED", $limit, $colors, $dal, $al);
            $totalDisliked = $rejectedStatistics['total'];
            $arrayReferralsRejected = $rejectedStatistics['arrayReferrals'];


            $response = $client->request('GET', "/api/company/$id/vacancies?serializerGroup=auth");
            $vacancies = json_decode($response->getBody()->getContents(), true);


            $referralPageViewsVacancies = [];

            foreach ($vacancies as $vacancy) {

                $appo["vacancy"] = $vacancy;
                //PERCENTUALE FONTI VISITE PER VACANCY

                $sorgenti = $this->getSorgentiTraffico("ga:pagePath=@/vacancy/" . Input::get("permalink") . "/" . $vacancy['permalink'], $colors, $dal, $al);
                $appo['sorgenti'] = $sorgenti;

                $rejectedStatistics = $this->getApplicationsReferralStatisticFiltered("vacancy", $vacancy['id'], "STARRED", $limit, $colors, $dal, $al);
                $appo['statisticheStarred'] = $rejectedStatistics;

                $rejectedStatistics = $this->getApplicationsReferralStatisticFiltered("vacancy", $vacancy['id'], "REJECTED", $limit, $colors, $dal, $al);
                $appo['statisticheRejected'] = $rejectedStatistics;

                $response = $client->request('GET', "/api/vacancy/" . $vacancy['id'] . "/applications?countMode=true&from={$dal}&to={$al}");
                $applicationsTotalVacancy = json_decode($response->getBody()->getContents(), true);
                $totalApplicationVacancy = 0;
                foreach ($applicationsTotalVacancy as $appl) {
                    $totalApplicationVacancy += $appl['doc_count'];
                }
                $appo['applicationsTotalVacancy'] = ["applicationsTotalVacancy" => $applicationsTotalVacancy, "total" => $totalApplicationVacancy];

                $referralPageViewsVacancies[] = $appo;
            }

            if (Input::get("general") && !Input::get("disabledCache")) {
                $data = new \DateTime();
                $data->setTimezone(new \DateTimeZone("Europe/Rome"));
                $expiresAt = Carbon::now()->addHours(3);
                Cache::put(Input::get("permalink") . "_statistic_cache", ["punteggioMedio"=>$punteggioMedio, "cached" => $data->format("d-m-Y H:i:s"), "dal" => Input::get("from", null), "al" => Input::get("to", null), "vacancies" => $referralPageViewsVacancies, "totalLiked" => $totalLiked, "totalDisliked" => $totalDisliked, "arrayReferralsStarred" => $arrayReferralsStarred, "arrayReferralsRejected" => $arrayReferralsRejected, "countTotalApplications" => $countTotalApplication, "applicationsTotal" => $applicationsTotal, "applications" => $datas, "totalPageView" => $totalReferralPageViews, "tortaReferralPageView" => $arrayReferrals, "company" => Input::get("companyName"), "visits" => $visits, "scores" => $scores, "trendApplicationPercentage" => $percentCompareApplications, "trendApplicationPeriod1" => $countApplicationsPeriod1, "trendApplicationPeriod2" => $totalApplicationsPeriod, "trendVisitsPercentage" => $percentCompareVisits, "trendVisitsPeriod1" => $countVisitsPeriod1, "trendVisitsPeriod2" => $countVisitsPeriod2, "trendScorePercentage" => null, "trendScorePeriod1" => null, "trendScorePeriod2" => null], $expiresAt);

            }

            return View::make('admin.partial-statistics-company', ["punteggioMedio"=>$punteggioMedio, "cached" => false, "dal" => Input::get("from", null), "al" => Input::get("to", null), "vacancies" => $referralPageViewsVacancies, "totalLiked" => $totalLiked, "totalDisliked" => $totalDisliked, "arrayReferralsStarred" => $arrayReferralsStarred, "arrayReferralsRejected" => $arrayReferralsRejected, "countTotalApplications" => $countTotalApplication, "applicationsTotal" => $applicationsTotal, "applications" => $datas, "totalPageView" => $totalReferralPageViews, "tortaReferralPageView" => $arrayReferrals, "company" => Input::get("companyName"), "visits" => $visits, "scores" => $scores, "trendApplicationPercentage" => $percentCompareApplications, "trendApplicationPeriod1" => $countApplicationsPeriod1, "trendApplicationPeriod2" => $totalApplicationsPeriod, "trendVisitsPercentage" => $percentCompareVisits, "trendVisitsPeriod1" => $countVisitsPeriod1, "trendVisitsPeriod2" => $countVisitsPeriod2, "trendScorePercentage" => null, "trendScorePeriod1" => null, "trendScorePeriod2" => null]);


        } else {

        }

    }


    public function compareApplicationsPeriods($type)
    {


        $user = Auth::user();
        if ($user->type != "USER") {

            $client = App::make('client.api');

            $response = $client->request('GET', "/api/analytics/" . $type . "/compare?" . $_SERVER['QUERY_STRING']);
            return response($response->getBody()->getContents())->header('Content-Type', 'application/json');
        } else {
        }
    }


    private function getApplicationsReferralStatisticFiltered($type, $id, $filter, $limit, $colors, $dal, $al)
    {


        $client = App::make('client.api');

        $response = $client->request('GET', "/api/" . $type . "/" . $id . "/referral?filter[status]=" . $filter . "&from={$dal}&to={$al}");
        $res = json_decode($response->getBody()->getContents(), true);

        $referrals = $res['buckets'];

        $total = 0;

        foreach ($referrals as $referral) {
            $total += $referral['doc_count'];
        }

        $total;
        $arrayReferrals = [];

        foreach (array_slice($referrals, 0, $limit) as $key => $referral) {
            if ($referral['doc_count'] > 0 && $total > 0) {
                $arrayReferrals[$key]["value"] = number_format((float)($referral['doc_count'] / $total) * 100, 2, '.', '');

            } else {
                $arrayReferrals[$key]["value"] = 0;

            }
            $arrayReferrals[$key]["label"] = $referral['key'] . " (" . number_format((float)$referral["height_stats"]['avg'], 2, '.', '') . ")";
            $arrayReferrals[$key]["labelColor"] = "white";
            $arrayReferrals[$key]["labelFontSize"] = "16";
            $arrayReferrals[$key]["avgScore"] = $referral["height_stats"]['avg'];
            $arrayReferrals[$key]["color"] = "#" . $colors[$key]["hex"];
            $arrayReferrals[$key]["highlight"] = "#" . $colors[$key]["hex"];
        }

        $value = 0;

        $color = "#" . $colors[$limit]["hex"];
        $highlight = $color;

        $score = 0;
        $i = 0;

        foreach (array_slice($referrals, $limit - 1, count($referrals)) as $key => $referral) {
            $i++;
            $value += $referral['doc_count'];
            $score += $referral["height_stats"]['avg'];
        }

        $altriReferral = [];

        if ($value > 0 && $total > 0) {
            $altriReferral["value"] = number_format((float)($value / $total) * 100, 2, '.', '');
            $score = (float)$score / $i;
        } else {
            $altriReferral["value"] = 0;
            $score = 0;
        }

        $label = "Altri Referral (" . number_format((float)$score, 2, '.', '') . ")";


        $altriReferral["label"] = $label;
        $altriReferral["color"] = $color;
        $altriReferral["labelColor"] = "white";
        $altriReferral["labelFontSize"] = "16";
        $altriReferral["highlight"] = $highlight;

        $arrayReferrals[] = $altriReferral;


        return [
            "arrayReferrals" => $arrayReferrals,
            "total" => $total
        ];


    }


    private function getSorgentiTraffico($filters, $colors, $dal, $al)
    {


        $client = new \GuzzleHttp\Client();


        $client = App::make('client.api');

        $response = $client->request('GET', "/api/analytics?metrics=ga:pageviews&filters=" . $filters . "&dimensions=ga:source&from={$dal}&to={$al}&sort=-ga:pageviews");
        $referralPageViews = json_decode($response->getBody()->getContents(), true);
        $totalReferralPageViews = 0;


        foreach ($referralPageViews as $visit) {
            $totalReferralPageViews += $visit['pageView'];
        }


        if ($totalReferralPageViews == 0) {
            return [
                "arrayReferrals" => [],
                "referralPageViews" => [],
                "total" => 0
            ];
        }


        $tortaReferralPageView = [];

        foreach ($referralPageViews as $visit) {
            if (strstr($visit['dimensions'], "facebook") !== false) {
                $tortaReferralPageView[] = [
                    "referral" => "Facebook",
                    "percentage" => ($visit['pageView'] / $totalReferralPageViews) * 100
                ];
                continue;
            }
            if (strstr($visit['dimensions'], "indeed") !== false) {
                $tortaReferralPageView[] = [
                    "referral" => "Indeed",
                    "percentage" => ($visit['pageView'] / $totalReferralPageViews) * 100
                ];
                continue;
            }
            if (strstr($visit['dimensions'], "linkedin") !== false) {
                $tortaReferralPageView[] = [
                    "referral" => "Linkedin",
                    "percentage" => ($visit['pageView'] / $totalReferralPageViews) * 100
                ];
                continue;
            }
            if (strstr($visit['dimensions'], "google") !== false) {
                $tortaReferralPageView[] = [
                    "referral" => "Google",
                    "percentage" => ($visit['pageView'] / $totalReferralPageViews) * 100
                ];
                continue;
            }
            if (strstr($visit['dimensions'], "lnkd") !== false) {
                $tortaReferralPageView[] = [
                    "referral" => "Linkedin",
                    "percentage" => ($visit['pageView'] / $totalReferralPageViews) * 100
                ];
                continue;
            }
            if (strstr(strtolower($visit['dimensions']), "egnazia") !== false) {
                $tortaReferralPageView[] = [
                    "referral" => "Borgo Egnazia widget",
                    "percentage" => ($visit['pageView'] / $totalReferralPageViews) * 100
                ];
                continue;
            }

            if (strstr(strtolower($visit['dimensions']), "mail.") !== false || strstr(strtolower($visit['dimensions']), "webmail") !== false) {
                $tortaReferralPageView[] = [
                    "referral" => "Sendgrid",
                    "percentage" => ($visit['pageView'] / $totalReferralPageViews) * 100
                ];
                continue;
            }

            $tortaReferralPageView[] = [
                "referral" => $visit['dimensions'],
                "percentage" => ($visit['pageView'] / $totalReferralPageViews) * 100
            ];
        }


        $data_summ = array();
        foreach ($tortaReferralPageView as $value) {
            $data_summ[$value["referral"]] = ["referral" => $value["referral"], "percentage" => 0];
        }


        foreach ($tortaReferralPageView as $list) {
            $data_summ[$list["referral"]]["percentage"] += $list['percentage'];

        }

        $referralPageViews = $data_summ;


        $limit = 8;
        if (Input::get("limit")) {
            $limit = Input::get("limit");
        }

        if (count($referralPageViews) < $limit) {
            $limit = 5;
        }


        $arrayReferrals = [];
        $i = 0;
        foreach (array_slice($referralPageViews, 0, $limit) as $key => $referral) {
            $arrayReferrals[$i]["value"] = number_format($referral['percentage'], 2, '.', '');
            $arrayReferrals[$i]["label"] = $referral['referral'];
            $arrayReferrals[$i]["labelColor"] = "white";
            $arrayReferrals[$i]["labelFontSize"] = "16";
            $arrayReferrals[$i]["color"] = "#" . $colors[$i]["hex"];
            $arrayReferrals[$i]["highlight"] = "#" . $colors[$i]["hex"];
            $i++;
        }

        $value = 0;

        $color = "#" . $colors[$limit]["hex"];
        $highlight = $color;

        $i = 0;

        foreach (array_slice($referralPageViews, $limit - 1, count($referralPageViews)) as $key => $referral) {
            $value += number_format((float)$referral['percentage'], 2, '.', '');
        }

        $label = "Altri Referral";

        $arrayReferrals[$limit]["value"] = $value;

        $arrayReferrals[$limit]["label"] = $label;
        $arrayReferrals[$limit]["color"] = $color;
        $arrayReferrals[$limit]["labelColor"] = "white";
        $arrayReferrals[$limit]["labelFontSize"] = "16";
        $arrayReferrals[$limit]["highlight"] = $highlight;

        return [
            "arrayReferrals" => $arrayReferrals,
            "referralPageViews" => $referralPageViews,
            "total" => $totalReferralPageViews
        ];

    }


    private function getTrendScore($type, $id, $dal, $al)
    {
        $client = App::make('client.api');


        $response = $client->request('GET', "/api/analytics/trendAvgScore/{$type}/" . $id . "?from={$dal}&to={$al}");
        $scores = json_decode($response->getBody()->getContents(), true);

        $total = count($scores);

        return [
            "total" => $total,
            "scores" => $scores
        ];

    }


}
