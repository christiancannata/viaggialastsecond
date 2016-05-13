<?php namespace Meritocracy\Console\Commands;


use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class CacheWatermarkCompanies extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'meritocracy:cache:watermark
    {--entity= : specify entity }
    {--offset= : specify entity }
    {--delete= : specify entity }
    {--connection= : For a specific connection }
    {--filter-expression= : Tables which are filtered by Regular Expression.}';

    /**
     * @var string
     */
    protected $description = 'Cache url watermark for companies';
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

        $this->comment("Getting companies " . PHP_EOL);




        $client = App::make('client.api');
        $response = $client->request('GET', "/api/company?isSystemCompany=true&isPremium=true&serializerGroup=systemCompany");
        $companies = json_decode($response->getBody()->getContents(), true);

        $this->comment("Caching elements " . PHP_EOL);
        $count = 0;
        foreach ($companies as $company) {

            if (isset($company["sliders"])) {
                $count++;
            }
        }

        $bar = $this->output->createProgressBar($count);
        $bar->start();
        $bar->setFormat('%message% %current%/%max% [%bar%] %percent:3s%%');


        foreach ($companies as $company) {

            if (isset($company["sliders"])) {
                foreach ($company["sliders"] as $i => $slider) {
                    if (!isset($slider["status"]) || $slider["status"]) {
                        if($company["is_premium"] && $company["avoid_watermark"] == false) {
                            if(!Cache::has('image_'.$slider["link"])) {
                                $finalLink = base64_encode(file_get_contents("https://process.filestackapi.com/A8gsh1avRW6BM45L8W9tqz/watermark=f:CUPo1ZibSYqfEFf8IrIz,position:[top,right]/output=format:jpg,compress:true/".str_replace(" ", "%20",$slider["link"])));
                                Cache::forever('image_'.$slider["link"], $finalLink);
                            }

                        }
                    }
                }
            }
            $bar->advance();

        }
        $bar->finish();

        $data = new \DateTime();

        $this->comment("Finished caching images {$data->format("d-m-Y H:i:s")}" . PHP_EOL);

    }

}
