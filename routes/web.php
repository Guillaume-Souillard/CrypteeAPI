<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Requête pour le cronjob.
Route::get('cronjobinit/{key}', 'Cronjob@initTable');

//Requête DATA
Route::get('getalldata', 'getData@getAll');

//Requête One Coin
Route::get('getdata/{symbol}', 'getData@getDataCoin');

//Requête One Chart Coin
Route::get('getCharts/{symbol}', 'getData@getChartsDailyCoin');