<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SoapClient;
use SoapFault;


class FacturacionComputarizadaController extends Controller
{
    protected $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJzdWIiOiJpZ25hY2lvbW9saW5hZ3V6bWFuMjBAZ21haWwuY29tIiwiY29kaWdvU2lzdGVtYSI6IjIyNzA5OUFGQkFGNDBBQTI5NjJGNiIsIm5pdCI6Ikg0c0lBQUFBQUFBQUFETTNNelkyc3pBMU1EUUZBRnVhUlpZS0FBQUEiLCJpZCI6NTE5OTc4MSwiZXhwIjoxNzgyNzgzNTExLCJpYXQiOjE3NzE3Mzg2ODEsIm5pdERlbGVnYWRvIjo3NjMzNjg1MDE1LCJzdWJzaXN0ZW1hIjoiU0ZFIn0.ZIwCT8p79PQ-llkjcFAQsG5kwr0NKI0tFgPb2FdL7l4AIVXL4ET7oDva8RYfrb1kHAPyYfupnxg0rltWT8C15g";
    protected $codigoSistema = "227099AFBAF40AA2962F6";
    protected $codigoAmbiente = 2;
    protected $codigoModalidad = 2;
    protected $codigoPuntoVenta = 0;
    protected $codigoSucursal = 0;
    protected $nit = "7633685015";

    public function verificarComunicacion()
    {
        if (!class_exists('SoapClient')) {
            return response()->json(['error' => 'La extensión SOAP no está habilitada en el servidor.'], 500);
        }

        $wsdl = "https://pilotosiatservicios.impuestos.gob.bo/v2/FacturacionCodigos?wsdl";
        $header = array(
            'http' => array(
                'header' => "apikey: TokenApi ".$this->token,
                'timeout' => 5
            )
        );
        $contexto = stream_context_create($header);

        try {
            $cliente = new \SoapClient(
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

    public function cuis()
    {
        $wsdl = "https://pilotosiatservicios.impuestos.gob.bo/v2/FacturacionCodigos?wsdl";

        $parametros = array(
            'SolicitudCuis' => array(
                'codigoAmbiente' => $this->codigoAmbiente,
                'codigoModalidad' => $this->codigoModalidad,
                'codigoPuntoVenta' => $this->codigoPuntoVenta,
                'codigoSistema' => $this->codigoSistema,
                'codigoSucursal' => $this->codigoSucursal,
                'nit' => $this->nit
            )
        );

        $header = array(
            'http' => array(
                'header' => "apikey: TokenApi ".$this->token,
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
            $resultado = $cliente->cuis($parametros);
        } catch (SoapFault $e) {
            $resultado = $e;
        }
        return $resultado;
    }

    public function cufd(){
        $wsdl="https://pilotosiatservicios.impuestos.gob.bo/v2/FacturacionCodigos?wsdl";

        // Accedemos a la jerarquía: RespuestaCuis -> codigo
        $cuis = $this->cuis()->RespuestaCuis->codigo;

        $parametros = array(
            'SolicitudCufd' => array(
                'codigoAmbiente' => $this->codigoAmbiente,
                'codigoModalidad' => $this->codigoModalidad,
                'codigoPuntoVenta' => $this->codigoPuntoVenta,
                'codigoSistema' => $this->codigoSistema,
                'codigoSucursal' => $this->codigoSucursal,
                'cuis' => $cuis,
                'nit' => $this->nit
            )
        );

        $header = array(
            'http' => array(
                'header' => "apikey: TokenApi ".$this->token,
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
            $resultado = $cliente->cufd($parametros);
        } catch (SoapFault $e) {
            $resultado = $e;
        }
        return $resultado;
    }

    
}
