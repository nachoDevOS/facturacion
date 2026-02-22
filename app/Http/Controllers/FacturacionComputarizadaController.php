<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SoapClient;
use SoapFault;

class FacturacionComputarizadaController extends Controller
{
    public function verificarComunicacion()
    {
        $wsdl = "https://pilotosiatservicios.impuestos.gob.bo/v2/FacturacionCodigos?wsdl";
        $header = array(
            'http' => array(
                'header' => "apikey: TokenApi eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJzdWIiOiJqdmlsbmV0QGhvdG1haWwuY29tIiwiY29kaWdvU2lzdGVtYSI6IjM3MUEwNjAwNEJCQTBDQzlERjFFIiwibml0IjoiSDRzSUFBQUFBQUFBQURNeE1qRTNNRFF5TUxRQUFEYVlPLVlLQUFBQSIsImlkIjo1NzI2MDE0LCJleHAiOjE3NzE2MjA3NDQsImlhdCI6MTc3MDc3MTExNSwibml0RGVsZWdhZG8iOjQyNDcwMTIwMTgsInN1YnNpc3RlbWEiOiJTRkUifQ.kziCtAaFI-mqgHbKsZwnEp5XRm8SPId6oO7cfJlwXCemIfK3x2e2WJKhMx1WpfKyiu3nxW3cqZR-mMxCoBEOvA",
                'timeout' => 5
            )
        );
        $contexto = stream_context_create($header);

        try {
            $cliente = new SoapClient(
                $wsdl,
                [
                    'stream_context' => $contexto,
                    'cache_wsdl' => WSDL_CACHE_NONE
                ]
            );
            $resultado = $cliente->verificarComunicacion();
        } catch (SoapFault $e) {
            $resultado = $e;
        }
        return $resultado;
    }
}
