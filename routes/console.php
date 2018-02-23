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
function getData($range) {
    // Create a stream
    $opts = array(
        'http'=>array(
            'method'=>"GET",
            'header'=>"Authorization: Z2bKu8DThLGdAFDgzFzbfa02c8bzFT877vWT4dHcomPUewU0BOqBLvEql6cZ"
        )
    );

    $context = stream_context_create($opts);

    // Open the file using the HTTP headers set above
    $file = file_get_contents("https://cryptapi.com/v1/getdata?exchange=bittrex-poloniex-bitstamp-kraken-gdax&range=$range", false, $context);
    $files = json_decode($file, true);

    return $files;
}

function getChartData($coin) {
    $file = file_get_contents("https://min-api.cryptocompare.com/data/histoday?fsym=$coin&tsym=USD&limit=365&aggregate=3&e=CCCAGG",false);
    $files = json_decode($file, true);
    return $files;
}

/**
 * php artisan initTable
 * init coins table (only in dev or bug)
 */
Artisan::command('initTable', function() {
    //Get Data
    $files = getData('100');

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
})->describe('Init coins table.');

/**
 * Update all coins
 * @return void
 */
Artisan::command('updateAllCoins', function () {
    //Get Data
    $files = getData('100');

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
})->describe('Update coins table');

/**
 * update All Charts Daily
 * @return void
 */
Artisan::command('updateChartsDaily', function () {

    //Clear charts table
    DB::statement('TRUNCATE `charts_data`');

    $files = getData('150');
    foreach ($files['result'] as $file) {
        $chartDatas = getChartData($file['symbol']);
        foreach ($chartDatas['Data'] as $data) {
            if ($data['close'] != 0) {
                DB::table('charts_data')->insert([
                    [
                        'symbol' => $file['symbol'],
                        'time' => $data['time'],
                        'price' => $data['close']
                    ]
                ]);
            }
        }
    }
    echo'All Charts Daily updated !';
});