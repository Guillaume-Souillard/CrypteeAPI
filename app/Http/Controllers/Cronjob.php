<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Psy\debug;

class Cronjob extends Controller
{

    /**
     * Init the table. Use in dev only.
     * @param $key_pass
     * @return void
     */
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
}
