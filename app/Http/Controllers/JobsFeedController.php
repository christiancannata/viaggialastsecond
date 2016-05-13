<?php

namespace Meritocracy\Http\Controllers;

use Illuminate\Support\Facades\App;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Response;
use SimpleXMLElement;

class JobsFeedController extends Controller
{


    /**
     * Instantiate a new JobsFeedController instance.
     */
    public function __construct()
    {

    }

    public function index()
    {
        $contents = make_get("/api/vacancy?isActive=true&serializerGroup=search", false, 60);
        if ($contents == null && count($contents) <= 0) {
            return Response::make("No Vacancies", 200, ["application/text"]);
        } else {

            $xml = new SimpleXMLElement("<?xml version=\"1.0\" encoding=\"utf-8\" ?><Jobs></Jobs>");

            foreach ($contents as $vacancy) {
                try {
                    $closedDate = new \DateTime($vacancy['closed_date']);
                    $now = new \DateTime();
                    if ($vacancy["is_sponsored"] != true ||  $vacancy['status'] == 0 || $closedDate->getTimestamp() < $now->getTimestamp() || $vacancy["is_visible"] == 0 || $vacancy["company"]["feed_hidden"] == true || $vacancy["feed_hidden"] == true) {
                        continue;
                    }

                    $vacancyContent = $vacancy;

                    $job = $xml->addChild('Job');
                    $job->addChild("url", "http://meritocracy.is/" . $vacancy["company"]["permalink"] . "/" . $vacancyContent["permalink"]);
                    $job->addChild("title", htmlspecialchars($vacancyContent["name"]));
                    $job->addChild("location", htmlspecialchars($vacancyContent["city_plain_text"]));
                    $job->addChild("city", htmlspecialchars($vacancyContent["city_plain_text"]));
                    if (isset($vacancyContent["city"]["country"]["name"])) {
                        $job->addChild("country", htmlspecialchars($vacancyContent["city"]["country"]["name"]));
                    }
                    if (isset($vacancyContent["industry"]["name"])) {
                        $job->addChild("industry", htmlspecialchars($vacancyContent["industry"]["name"]));
                    }
                    if (isset($vacancyContent["job_function"]["name"])) {
                        $job->addChild("jobFunction", htmlspecialchars($vacancyContent["job_function"]["name"]));
                    }
                    if (isset($vacancyContent["study_field"]["name"])) {
                        $job->addChild("studyField", htmlspecialchars($vacancyContent["study_field"]["name"]));
                    }
                    $job->addChild("company", htmlspecialchars($vacancyContent["company"]["name"]));
                    $job->addChild("companyLogo", htmlspecialchars($vacancyContent["company"]["logo_small"]));

                    if (isset($vacancyContent["company"]["country"]["name"])) {
                        $job->addChild("companyCountry", htmlspecialchars($vacancyContent["company"]["country"]["name"]));
                    }
                    $job->addChild("publishDate", $vacancyContent["open_date"]);
                    $job->addChild("description", htmlspecialchars($vacancyContent["description"]));
                    if (!empty($vacancyContent["redirect_url"])) {
                        $job->addChild("willRedirected", true);
                    }
                    $job->company = $vacancy["company"]["name"];


                } catch (\Exception $ee) {
                    var_dump($ee);
                }


            }
            $xml->addAttribute("vacancies", count($xml->Job));
            return Response::make($xml->asXML(), 200, ["Content-Type" => "application/xml"]);
        }

    }


}
