<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Cronjob extends Controller
{
    public function startCron() {

       $allcoins =  file_get_contents('https://api.coinmarketcap.com/v1/ticker/?limit=100');
       json_decode($allcoins,true);

    }
}
