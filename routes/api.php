<?php

use App\Http\Controllers\Api\ExampleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('/examples', ExampleController::class);

Route::get('/', function() {
    return response()->json(['message' => 'success']);
});