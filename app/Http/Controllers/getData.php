<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class getData extends Controller
{
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
