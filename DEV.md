# 📘 Documentación de Desarrollo - AxonBill Microservicio

Este documento detalla la arquitectura y los puntos de integración del microservicio de facturación **AxonBill**. Este servicio está diseñado para operar como un núcleo "headless", recibiendo peticiones de otros sistemas (ERP, CRM, E-commerce) y encargándose de la comunicación con el Servicio de Impuestos Nacionales (SIAT).

---

## 🔌 Integración y Consumo

Los sistemas externos deben consumir este microservicio a través de su API REST. Las respuestas se entregan generalmente en formato JSON.

### Flujo de Comunicación
1. **Sistema Externo** (Cliente) envía una petición HTTP al Microservicio.
2. **AxonBill** procesa la lógica de negocio y comunica con el SIAT (SOAP).
3. **AxonBill** formatea la respuesta del SIAT y la devuelve al Cliente.

---

## 📡 Endpoints Disponibles

### 1. Verificar Comunicación con SIAT

Este endpoint permite probar la conectividad entre el microservicio y los servidores del Servicio de Impuestos Nacionales (SIAT). Es útil para diagnósticos de salud del sistema externo antes de intentar emitir facturas.

* **URL:** `/api/siat/verificar-comunicacion`
* **Método:** `GET`
* **Controlador:** `FacturacionComputarizadaController@verificarComunicacion`

#### Ejemplo de Respuesta Exitosa (JSON)
El servicio devuelve la respuesta directa del SOAP del SIAT convertida a JSON:

```json
{
    "return": {
        "mensajesList": {
            "codigo": 926,
            "descripcion": "COMUNICACION EXITOSA"
        },
        "transaccion": true
    }
}
```

#### Notas Técnicas
- **Protocolo Upstream:** SOAP (WSDL).
- **Autenticación SIAT:** Utiliza un `apikey` en el header del stream context para la conexión SOAP.
- **Manejo de Errores:** Si falla la conexión SOAP, el endpoint retornará el objeto `SoapFault` serializado con los detalles del error.

### 2. Obtener CUIS

Solicita el Código Único de Inicio de Sistemas (CUIS), necesario para solicitar el CUFD y emitir facturas.

* **URL:** `/api/siat/cuis`
* **Método:** `GET`
* **Controlador:** `FacturacionComputarizadaController@cuis`

### 3. Obtener CUFD

Solicita el Código Único de Facturación Diaria (CUFD). Este código cambia cada 24 horas y es indispensable para la emisión de facturas.
*Nota: El controlador gestiona internamente la obtención del CUIS necesario para esta petición.*

* **URL:** `/api/siat/cufd`
* **Método:** `GET`
* **Controlador:** `FacturacionComputarizadaController@cufd`

### 4. Sincronizar Actividades

Obtiene el catálogo de actividades económicas habilitadas por el SIN para el contribuyente.

* **URL:** `/api/siat/sincronizar-actividades`
* **Método:** `GET`
* **Controlador:** `FacturacionComputarizadaController@sincronizarActividades`

### 5. Sincronizar Leyendas de Factura

Descarga la lista de leyendas obligatorias que deben imprimirse aleatoriamente en las facturas.

* **URL:** `/api/siat/sincronizar-lista-leyendas-factura`
* **Método:** `GET`
* **Controlador:** `FacturacionComputarizadaController@sincronizarListaLeyendasFactura`

## ⚠️ Requisitos del Sistema

Para que la comunicación con el SIAT funcione, es indispensable tener habilitada la extensión **SOAP** en el servidor PHP.

### Solución a `Class "SoapClient" not found`
* **Ubuntu/Debian:** Ejecutar `sudo apt-get install php-soap` y reiniciar el servidor web.
* **Docker:** Agregar `RUN docker-php-ext-install soap` en el Dockerfile.
* **php.ini:** Asegurarse de que `extension=soap` no esté comentado.