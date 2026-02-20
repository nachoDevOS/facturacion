# 🚀 AxonBill API - Servicio de Facturación

**AxonBill** es un microservicio robusto desarrollado en **Laravel 12**, diseñado para centralizar la lógica fiscal y la emisión de facturas electrónicas. Funciona como un núcleo "headless" (sin interfaz) que procesa peticiones de otros sistemas de la infraestructura.

---

## 🛠️ Stack Tecnológico
* **Framework:** Laravel 12.x
* **Arquitectura:** API RESTful
* **Testing:** Pest Framework
* **IA Assisted:** Optimizado para Gemini CLI y Claude Code (Laravel Boost)
* **Autenticación:** Laravel Sanctum (Token-based)

---

## 📂 Estructura del Proyecto (Servicio)
Al ser un servicio puro, la lógica principal reside en:
* `routes/api.php`: Definición de los puntos de entrada.
* `app/Http/Controllers/Api/`: Controladores encargados de la lógica de facturación.
* `app/Models/`: Modelos de datos (Invoice, Client, Tax).
* `tests/`: Pruebas unitarias y de integración con Pest.

---

## 🚦 Endpoints Disponibles

### 1. Estado del Sistema
Verifica que el servicio esté arriba y respondiendo.
* **URL:** `/api/status`
* **Método:** `GET`
* **Respuesta Exitosa (JSON):**
```json
{
    "service": "AxonBill API",
    "status": "online",
    "version": "1.0.0"
}# facturacion
