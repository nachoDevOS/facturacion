<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FacturacionComputarizadaController;

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

// Endpoints de Facturación Computarizada (SIAT)
Route::get('/siat/verificar-comunicacion', [FacturacionComputarizadaController::class, 'verificarComunicacion']);