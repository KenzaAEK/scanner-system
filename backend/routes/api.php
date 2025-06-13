<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/x', function () {
    return response()->json(["heloo" => "xx"]);
});
