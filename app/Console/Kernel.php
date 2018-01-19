<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //Update coins data
        $schedule->call(function () {
            $datas = $this->getData();
            $this->updateData($datas);
        })->everyFiveMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    /**
     * Return all data about cryptocurrency
     *
     * @return array
     */
    public function getData() {
        // Create a stream
        $opts = array(
            'http'=>array(
                'method'=>"GET",
                'header'=>"Authorization: Z2bKu8DThLGdAFDgzFzbfa02c8bzFT877vWT4dHcomPUewU0BOqBLvEql6cZ"
            )
        );

        $context = stream_context_create($opts);

        // Open the file using the HTTP headers set above
        $file = file_get_contents('https://cryptapi.com/v1/getdata?exchange=bittrex-poloniex-bitstamp-kraken-gdax&range=100', false, $context);
        $files = json_decode($file, true);

        return $files;
    }

    public function updateData($files) {

        //Update coins
        foreach ($files['result'] as $file) {

            DB::table('coins')
                ->where('rank', $file['rank'])
                ->update(
                    [
                        'name' => $file['name'],
                        'symbol' => $file['symbol'],
                        'rank' => $file['rank'],
                        'img' => $file['img'],
                        'percent_change_1h' => $file['percent_change_1h'],
                        'percent_change_24h' => $file['percent_change_24h'],
                        'percent_change_7d' => $file['percent_change_7d'],
                        'cmc_price_btc' => $file['cmc_price_btc'],
                        'cmc_price_usd' => $file['cmc_price_usd']
                    ]
                );
        }

        return'All Is Good Updated';
    }

}
