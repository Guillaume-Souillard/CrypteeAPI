<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

/**
 * Get all data about coins
 * @return array
 */
function getData() {
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

Artisan::command('initTable', function() {
    //Get Data
    $files = getData();

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
})->describe('init coins table.');
