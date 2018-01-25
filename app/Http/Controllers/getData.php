<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class getData extends Controller
{

    /**
     * Return in json all data about all coins
     * @return object
     */
    public function getAll() {
        $datas = DB::table('coins')->select(
            'name',
            'symbol',
            'rank',
            'img',
            'percent_change_1h',
            'percent_change_24h',
            'percent_change_7d',
            'cmc_price_btc',
            'cmc_price_usd'
        )->get();

        $data = json_encode($datas, JSON_UNESCAPED_SLASHES);

        return $data;
    }

    /**
     * Return in json all data about one coin (set with coin symbol)
     * @param $symbol
     * @return object
     */
    public function getDataCoin($symbol) {
        $datas = DB::table('coins')
            ->select(
            'name',
            'symbol',
            'rank',
            'img',
            'percent_change_1h',
            'percent_change_24h',
            'percent_change_7d',
            'cmc_price_btc',
            'cmc_price_usd'
            )
            ->where('symbol', '=', $symbol)
            ->get();

        $data = json_encode($datas,JSON_UNESCAPED_SLASHES );

        return $data;
    }
}
