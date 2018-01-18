<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Psy\debug;

class Cronjob extends Controller
{

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

    public function initTable($key_pass) {

        //verify the key_pass
        if ($key_pass == "T{qb<62W<94x498*DRTJ8Wim$>pq!") {
            $files = $this->getData();

            //Adding coin
            foreach ($files['result'] as $file) {

                DB::table('coins')->insert([
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
                ]);

            }
            echo'All Is Good Created';
        } else {
            echo 'Access Denied';
        }
    }

    public function update() {

        $files = $this->getData();

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

        echo'All Is Good Updated';
    }
}
