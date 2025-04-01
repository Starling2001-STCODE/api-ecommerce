<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/get-ip', function (Request $request) {
    $client = new \GuzzleHttp\Client();
    $res = $client->get('https://api.ipify.org?format=json');
    return json_decode($res->getBody(), true);
});
