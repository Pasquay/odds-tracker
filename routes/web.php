<?php

use Illuminate\Support\Facades\Route;
use App\Models\Price;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/latest-prices', function (){
    return Price::latest()->take(4)->get();
});