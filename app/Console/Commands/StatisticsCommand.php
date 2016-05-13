<?php namespace Meritocracy\Console\Commands;


use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class StatisticsCommand extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'meritocracy:statistics:generate
    {--entity= : specify entity }
    {--offset= : specify entity }
    {--delete= : specify entity }
    {--connection= : For a specific connection }
    {--filter-expression= : Tables which are filtered by Regular Expression.}';

    /**
     * @var string
     */
    protected $description = 'Import vacancies in elastic search';
    protected $colors = null;

    public function __construct()
    {
        parent::__construct();

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $client = new \GuzzleHttp\Client();

        $this->comment("GET  Colors " . PHP_EOL);


        $response = $client->request('GET', "http://www.colourlovers.com/api/colors/top?format=json&numResults=20");
        $this->colors = json_decode($response->getBody()->getContents(), true);


        $data = new \DateTime();

        $this->comment("Start indexing {$data->format("d-m-Y H:i:s")}" . PHP_EOL);

        $limit = 8;


        $client = App::make('client.api');
        $response = $client->request('GET', "/api/company?isSystemCompany=true&serializerGroup=admin");
        $companies = json_decode($response->getBody()->getContents(), true);


        foreach ($companies as $company) {

            if ($company['count_vacancies'] > 0) {
                $this->comment("Caching " . $company['name'] . PHP_EOL);


                $id = $company['id'];
                //PERCENTUALE FONTI VISITE
                $sorgenti = $this->getSorgentiTraffico("ga:pagePath=@/company/" . $company['permalink']);
                $arrayReferrals = $sorgenti['arrayReferrals'];
                $totalReferralPageViews = $sorgenti['total'];

                //TREND VISITE ULTIMI 14 GIORNI A CONFRONTO

                $this->comment("GET  " . "/api/analytics?metrics=ga:pageviews&filters=ga:pagePath=@/company/" . $company['permalink'] . "&dimensions=ga:date&from=P13D&to=yesterday" . PHP_EOL);

                $response = $client->request('GET', "/api/analytics?metrics=ga:pageviews&filters=ga:pagePath=@/company/" . $company['permalink'] . "&dimensions=ga:date&from=P13D&to=yesterday");
                $visits = json_decode($response->getBody()->getContents(), true);


                $countVisitsPeriod1 = 0;
                $countVisitsPeriod2 = 0;


                $total = count($visits);

                foreach (array_slice($visits, 0, $total / 2) as $visit) {

                    $countVisitsPeriod1 += $visit['pageView'];
                }

                foreach (array_slice($visits, 7, $total / 2) as $visit) {
                    $countVisitsPeriod2 += $visit['pageView'];

                }

                $percentCompareVisits = ($countVisitsPeriod1 > 0) ? ($countVisitsPeriod2 - $countVisitsPeriod1) / $countVisitsPeriod1 * 100 : 0;

                //TREND APPLICATIONS ULTIMI 14 GIORNI A CONFRONTO

                $response = $client->request('GET', "/api/company/" . $id . "/applications?grouped=day&from=P14D&to=P1D");
                $datas = json_decode($response->getBody()->getContents(), true);


                $countApplicationsPeriod1 = 0;
                $countApplicationsPeriod2 = 0;


                $total = count($datas);
                $totalApplicationsPeriod = 0;
                foreach ($datas as $visit) {

                    $totalApplicationsPeriod += $visit['applications'];
                }
                if (count($datas) > 14) {


                    foreach (array_slice($datas, 0, $total / 2) as $visit) {

                        $countApplicationsPeriod1 += $visit['applications'];
                    }

                    foreach (array_slice($datas, 7, $total / 2) as $visit) {
                        $countApplicationsPeriod2 += $visit['applications'];

                    }

                    $percentCompareApplications = ($countApplicationsPeriod1 > 0) ? ($countApplicationsPeriod2 - $countApplicationsPeriod1) / $countApplicationsPeriod1 * 100 : 0;
                } else {

                    $percentCompareApplications = "-";
                    $countApplicationsPeriod2 = $totalApplicationsPeriod;

                }

                //TREND SCORE ULTIMI 14 GIORNI A CONFRONTO

                $trendScore = $this->getTrendScore("company", $id);
                $countScorePeriod1 = $trendScore['countScorePeriod1'];
                $countScorePeriod2 = $trendScore['countScorePeriod2'];
                $percentCompareScore = $trendScore['percentCompareScore'];
                $scores = $trendScore['scores'];

                $response = $client->request('GET', "/api/company/" . $id . "/applications?countMode=true");
                $applicationsTotal = json_decode($response->getBody()->getContents(), true);
                $countTotalApplication = 0;
                foreach ($applicationsTotal as $appl) {

                    $countTotalApplication += $appl['doc_count'];
                }


                $rejectedStatistics = $this->getApplicationsReferralStatisticFiltered("company", $id, "STARRED", $limit);
                $totalLiked = $rejectedStatistics['total'];
                $arrayReferralsStarred = $rejectedStatistics['arrayReferrals'];


                $rejectedStatistics = $this->getApplicationsReferralStatisticFiltered("company", $id, "REJECTED", $limit);
                $totalDisliked = $rejectedStatistics['total'];
                $arrayReferralsRejected = $rejectedStatistics['arrayReferrals'];


                $response = $client->request('GET', "/api/company/$id/vacancies?serializerGroup=auth");
                $vacancies = json_decode($response->getBody()->getContents(), true);


                $referralPageViewsVacancies = [];

                foreach ($vacancies as $vacancy) {

                    $appo["vacancy"] = $vacancy;
                    //PERCENTUALE FONTI VISITE PER VACANCY

                    $sorgenti = $this->getSorgentiTraffico("ga:pagePath=@/vacancy/" . $company['permalink'] . "/" . $vacancy['permalink']);
                    $appo['sorgenti'] = $sorgenti;

                    $rejectedStatistics = $this->getApplicationsReferralStatisticFiltered("vacancy", $vacancy['id'], "STARRED", $limit);
                    $appo['statisticheStarred'] = $rejectedStatistics;

                    $rejectedStatistics = $this->getApplicationsReferralStatisticFiltered("vacancy", $vacancy['id'], "REJECTED", $limit);
                    $appo['statisticheRejected'] = $rejectedStatistics;


                    $response = $client->request('GET', "/api/vacancy/" . $vacancy['id'] . "/applications?countMode=true");
                    $applicationsTotalVacancy = json_decode($response->getBody()->getContents(), true);
                    $totalApplicationVacancy = 0;
                    foreach ($applicationsTotalVacancy as $appl) {
                        $totalApplicationVacancy += $appl['doc_count'];
                    }
                    $appo['applicationsTotalVacancy'] = ["applicationsTotalVacancy" => $applicationsTotalVacancy, "total" => $totalApplicationVacancy];

                    $referralPageViewsVacancies[] = $appo;
                }
                $data = new \DateTime();
                $data->setTimezone(new \DateTimeZone("Europe/Rome"));
                Cache::forever($company['permalink'] . "_statistic_cache", ["cached" => $data->format("d-m-Y H:i:s"), "dal" => null, "al" => null, "vacancies" => $referralPageViewsVacancies, "totalLiked" => $totalLiked, "totalDisliked" => $totalDisliked, "arrayReferralsStarred" => $arrayReferralsStarred, "arrayReferralsRejected" => $arrayReferralsRejected, "countTotalApplications" => $countTotalApplication, "applicationsTotal" => $applicationsTotal, "applications" => $datas, "totalPageView" => $totalReferralPageViews, "tortaReferralPageView" => $arrayReferrals, "company" => $company['name'], "visits" => $visits, "scores" => $scores, "trendApplicationPercentage" => $percentCompareApplications, "trendApplicationPeriod1" => $countApplicationsPeriod1, "trendApplicationPeriod2" => $countApplicationsPeriod2, "trendVisitsPercentage" => $percentCompareVisits, "trendVisitsPeriod1" => $countVisitsPeriod1, "trendVisitsPeriod2" => $countApplicationsPeriod2, "trendScorePercentage" => $percentCompareScore, "trendScorePeriod1" => $countScorePeriod1, "trendScorePeriod2" => $countScorePeriod2]);
            }


        }


        $data = new \DateTime();

        $this->comment("Finished indexing {$data->format("d-m-Y H:i:s")}" . PHP_EOL);

    }


    private function getApplicationsReferralStatisticFiltered($type, $id, $filter, $limit)
    {

        $colors = $this->colors;

        $client = App::make('client.api');

        $response = $client->request('GET', "/api/" . $type . "/" . $id . "/referral?filter[status]=" . $filter);
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


    private function getSorgentiTraffico($filters)
    {

        $colors = $this->colors;

        $client = App::make('client.api');


        $this->comment("GET  " . "/api/analytics?metrics=ga:pageviews&filters=" . $filters . "&dimensions=ga:source&from=P91D&to=yesterday&sort=-ga:pageviews" . PHP_EOL);

        $response = $client->request('GET', "/api/analytics?metrics=ga:pageviews&filters=" . $filters . "&dimensions=ga:source&from=P91D&to=yesterday&sort=-ga:pageviews");
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


    private function getTrendScore($type, $id)
    {
        $client = App::make('client.api');

        $response = $client->request('GET', "/api/analytics/trendAvgScore/company/" . $id);
        $scores = json_decode($response->getBody()->getContents(), true);


        $countScorePeriod1 = 0;
        $countScorePeriod2 = 0;


        $total = count($scores);

        foreach (array_slice($scores, 0, $total / 2) as $visit) {

            $countScorePeriod1 += $visit['height_stats']['avg'];
        }

        foreach (array_slice($scores, 7, $total / 2) as $visit) {
            $countScorePeriod2 += $visit['height_stats']['avg'];

        }

        $countScorePeriod1 = ($total > 0) ? $countScorePeriod1 / ($total / 2) : 0;
        $countScorePeriod2 = ($total > 0) ? $countScorePeriod2 / ($total / 2) : 0;


        $percentCompareScore = ($countScorePeriod1 > 0) ? ($countScorePeriod2 - $countScorePeriod1) / $countScorePeriod1 * 100 : 0;

        return [
            "percentCompareScore" => $percentCompareScore,
            "countScorePeriod1" => $countScorePeriod1,
            "countScorePeriod2" => $countScorePeriod2,
            "scores" => $scores
        ];

    }


}
