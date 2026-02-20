<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/status', function () {
    return response()->json([
        'service' => 'AxonBill API',
        'status' => 'online',
        'version' => '1.0.0'
    ]);
});