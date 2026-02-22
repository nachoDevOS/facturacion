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
                'header' => "apikey: TokenApi eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJzdWIiOiJpZ25hY2lvbW9saW5hZ3V6bWFuMjBAZ21haWwuY29tIiwiY29kaWdvU2lzdGVtYSI6IjIyNzA5OUFGQkFGNDBBQTI5NjJGNiIsIm5pdCI6Ikg0c0lBQUFBQUFBQUFETTNNelkyc3pBMU1EUUZBRnVhUlpZS0FBQUEiLCJpZCI6NTE5OTc4MSwiZXhwIjoxNzgyNzgzNTExLCJpYXQiOjE3NzE3Mzg2ODEsIm5pdERlbGVnYWRvIjo3NjMzNjg1MDE1LCJzdWJzaXN0ZW1hIjoiU0ZFIn0.ZIwCT8p79PQ-llkjcFAQsG5kwr0NKI0tFgPb2FdL7l4AIVXL4ET7oDva8RYfrb1kHAPyYfupnxg0rltWT8C15g",
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
