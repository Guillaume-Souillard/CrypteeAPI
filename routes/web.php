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

// Récupére tous les coins.
Route::get('allcoins', function() {
    return 'requête des allcoins';
});

//Requête pour le login.
Route::get('login', function() {
    return 'Requete log';
});

//Requête pour le register.
Route::get('register', function() {
    return 'Requete register';
});

//Requête pour le cronjob.
Route::get('cronjobinit/{key}', 'Cronjob@initTable');

//Requête pour le cronjob.
Route::get('cronjobupdate', 'Cronjob@update');

//Requête DATA
Route::get('getalldata', 'getData@getAll');

//Requête One Coin
Route::get('getdata/{symbol}', 'getData@getDataCoin');