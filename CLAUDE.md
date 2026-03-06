# CLAUDE.md

Este archivo proporciona orientación a Claude Code (claude.ai/code) cuando trabaja con el código de este repositorio.

## Descripción del Proyecto

**AxonBill** es una API REST en Laravel 12 que se integra con los servicios web SOAP del SIAT (Sistema de Administración de Impuestos) de Bolivia para la Facturación Computarizada. Se comunica con los endpoints SOAP del entorno piloto de impuestos (`pilotosiatservicios.impuestos.gob.bo`).

## Comandos

```bash
# Iniciar todos los servicios (servidor, cola, logs, vite)
composer run dev

# Ejecutar todos los tests
php artisan test --compact

# Ejecutar un test específico
php artisan test --compact --filter=NombreDelTest

# Formatear código PHP tras cualquier cambio
vendor/bin/pint --dirty --format agent

# Configuración inicial
composer run setup
```

## Arquitectura

### Integración con SIAT

Toda la comunicación con el SIAT se encuentra en [app/Http/Controllers/FacturacionComputarizadaController.php](app/Http/Controllers/FacturacionComputarizadaController.php). Usa `SoapClient` de PHP con un encabezado HTTP `apikey`. El controlador contiene credenciales fijas (`$token`, `$codigoSistema`, `$nit`, etc.) que identifican al sistema de facturación.

El flujo de la API SIAT es secuencial:
1. **CUIS** — Obtener código de sesión vía WSDL `FacturacionCodigos`
2. **CUFD** — Obtener código diario (requiere CUIS)
3. **Sincronización** — Sincronizar datos paramétricos (actividades, productos, métodos de pago, etc.) vía WSDL `FacturacionSincronizacion`
4. **recepcionFactura** — Enviar XML de factura (requiere CUIS y CUFD) vía WSDL `ServicioFacturacionCompraVenta`

### Rutas

Las rutas de la API (`routes/api.php`) están bajo el prefijo `/api/siat/*` (sin middleware de autenticación por el momento). Las rutas web (`routes/web.php`) solo sirven la vista de bienvenida.

### Base de Datos

Solo existen las tablas predeterminadas de Laravel (users, cache, jobs, personal_access_tokens). Aún no hay modelos de dominio.

<laravel-boost-guidelines>
=== foundation rules ===

# Directrices de Laravel Boost

Las directrices de Laravel Boost están curadas específicamente por los mantenedores de Laravel para esta aplicación. Deben seguirse de cerca para garantizar la mejor experiencia al construir aplicaciones Laravel.

## Contexto Base

Esta aplicación es una aplicación Laravel y sus principales paquetes del ecosistema Laravel y versiones son los siguientes. Eres experto en todos ellos. Asegúrate de respetar estos paquetes y versiones específicos.

- php - 8.2.30
- laravel/framework (LARAVEL) - v12
- laravel/prompts (PROMPTS) - v0
- laravel/sanctum (SANCTUM) - v4
- laravel/boost (BOOST) - v2
- laravel/mcp (MCP) - v0
- laravel/pail (PAIL) - v1
- laravel/pint (PINT) - v1
- laravel/sail (SAIL) - v1
- pestphp/pest (PEST) - v3
- phpunit/phpunit (PHPUNIT) - v11
- tailwindcss (TAILWINDCSS) - v4

## Activación de Skills

Este proyecto tiene skills específicos disponibles. DEBES activar el skill relevante cada vez que trabajes en ese dominio — no esperes hasta que estés bloqueado.

- `pest-testing` — Testea aplicaciones con el framework Pest 3 de PHP. Se activa al escribir tests, crear tests unitarios o de feature, agregar aserciones, testear componentes Livewire, tests de arquitectura, depurar fallos en tests, trabajar con datasets o mocking; o cuando el usuario menciona test, spec, TDD, expects, assertion, coverage, o necesita verificar que algo funciona.
- `tailwindcss-development` — Estiliza aplicaciones con utilidades de Tailwind CSS v4. Se activa al agregar estilos, rediseñar componentes, trabajar con gradientes, espaciado, layout, flex, grid, diseño responsivo, modo oscuro, colores, tipografía o bordes; o cuando el usuario menciona CSS, estilos, clases, Tailwind, rediseñar, hero section, tarjetas, botones o cualquier cambio visual/UI.

## Convenciones

- Debes seguir todas las convenciones de código existentes en esta aplicación. Al crear o editar un archivo, revisa los archivos hermanos para conocer la estructura, enfoque y nomenclatura correctos.
- Usa nombres descriptivos para variables y métodos. Por ejemplo, `isRegisteredForDiscounts`, no `discount()`.
- Verifica si existen componentes reutilizables antes de escribir uno nuevo.

## Scripts de Verificación

- No crees scripts de verificación ni uses tinker cuando los tests cubran esa funcionalidad y demuestren que funciona. Los tests unitarios y de feature son más importantes.

## Estructura y Arquitectura de la Aplicación

- Mantén la estructura de directorios existente; no crees nuevas carpetas base sin aprobación.
- No cambies las dependencias de la aplicación sin aprobación.

## Empaquetado Frontend

- Si el usuario no ve un cambio de frontend reflejado en la UI, podría significar que necesita ejecutar `npm run build`, `npm run dev` o `composer run dev`. Pregúntale.

## Archivos de Documentación

- Solo debes crear archivos de documentación si el usuario lo solicita explícitamente.

## Respuestas

- Sé conciso en tus explicaciones — enfócate en lo importante en lugar de explicar detalles obvios.

=== boost rules ===

# Laravel Boost

- Laravel Boost es un servidor MCP que viene con herramientas potentes diseñadas específicamente para esta aplicación. Úsalas.

## Artisan

- Usa la herramienta `list-artisan-commands` cuando necesites llamar un comando Artisan para verificar los parámetros disponibles.

## URLs

- Cada vez que compartas una URL del proyecto con el usuario, debes usar la herramienta `get-absolute-url` para asegurarte de usar el esquema, dominio/IP y puerto correctos.

## Tinker / Depuración

- Debes usar la herramienta `tinker` cuando necesites ejecutar PHP para depurar código o consultar modelos Eloquent directamente.
- Usa la herramienta `database-query` cuando solo necesites leer de la base de datos.
- Usa la herramienta `database-schema` para inspeccionar la estructura de tablas antes de escribir migraciones o modelos.

## Leer Logs del Navegador con la Herramienta `browser-logs`

- Puedes leer logs, errores y excepciones del navegador usando la herramienta `browser-logs` de Boost.
- Solo los logs recientes del navegador serán útiles — ignora los logs antiguos.

## Buscar Documentación (Críticamente Importante)

- Boost incluye una poderosa herramienta `search-docs` que debes usar antes de probar otros enfoques cuando trabajes con Laravel o paquetes del ecosistema Laravel. Esta herramienta pasa automáticamente una lista de paquetes instalados y sus versiones a la API remota de Boost, por lo que devuelve solo documentación específica de versión para la situación del usuario. Debes pasar un array de paquetes para filtrar si sabes que necesitas documentación de paquetes particulares.
- Busca en la documentación antes de hacer cambios en el código para asegurarte de tomar el enfoque correcto.
- Usa múltiples consultas amplias, simples y basadas en temas a la vez. Por ejemplo: `['rate limiting', 'routing rate limiting', 'routing']`. Los resultados más relevantes se devolverán primero.
- No agregues nombres de paquetes a las consultas; la información del paquete ya se comparte. Por ejemplo, usa `test resource table`, no `filament 4 test resource table`.

### Sintaxis de Búsqueda Disponible

1. Búsquedas de palabras simples con auto-stemming - query=authentication - encuentra 'authenticate' y 'auth'.
2. Múltiples palabras (lógica AND) - query=rate limit - encuentra conocimiento que contenga tanto "rate" COMO "limit".
3. Frases exactas (posición exacta) - query="infinite scroll" - las palabras deben ser adyacentes y en ese orden.
4. Consultas mixtas - query=middleware "rate limit" - "middleware" Y la frase exacta "rate limit".
5. Múltiples consultas - queries=["authentication", "middleware"] - CUALQUIERA de estos términos.

=== php rules ===

# PHP

- Siempre usa llaves para las estructuras de control, incluso para cuerpos de una sola línea.

## Constructores

- Usa promoción de propiedades en el constructor de PHP 8 en `__construct()`.
    - `public function __construct(public GitHub $github) { }`
- No permitas métodos `__construct()` vacíos con cero parámetros a menos que el constructor sea privado.

## Declaraciones de Tipo

- Siempre usa declaraciones de tipo de retorno explícitas para métodos y funciones.
- Usa tipos de PHP apropiados para los parámetros de los métodos.

<!-- Tipos de Retorno Explícitos y Parámetros de Métodos -->
```php
protected function isAccessible(User $user, ?string $path = null): bool
{
    ...
}
```

## Enums

- Normalmente, las claves en un Enum deben ser TitleCase. Por ejemplo: `FavoritePerson`, `BestLake`, `Monthly`.

## Comentarios

- Prefiere bloques PHPDoc sobre comentarios en línea. Nunca uses comentarios dentro del código a menos que la lógica sea excepcionalmente compleja.

## Bloques PHPDoc

- Agrega definiciones de tipo de forma de array útiles cuando sea apropiado.

=== laravel/core rules ===

# Haz las Cosas a la Manera de Laravel

- Usa comandos `php artisan make:` para crear nuevos archivos (migraciones, controladores, modelos, etc.). Puedes listar los comandos Artisan disponibles usando la herramienta `list-artisan-commands`.
- Si estás creando una clase PHP genérica, usa `php artisan make:class`.
- Pasa `--no-interaction` a todos los comandos Artisan para asegurarte de que funcionen sin entrada del usuario. También debes pasar las `--options` correctas para garantizar el comportamiento correcto.

## Base de Datos

- Siempre usa métodos de relación Eloquent adecuados con tipos de retorno. Prefiere los métodos de relación sobre consultas crudas o joins manuales.
- Usa modelos Eloquent y relaciones antes de sugerir consultas de base de datos crudas.
- Evita `DB::`; prefiere `Model::query()`. Genera código que aproveche las capacidades ORM de Laravel en lugar de eludirlas.
- Genera código que prevenga problemas de consultas N+1 usando eager loading.
- Usa el query builder de Laravel para operaciones de base de datos muy complejas.

### Creación de Modelos

- Al crear nuevos modelos, crea también factories y seeders útiles. Pregunta al usuario si necesita otras cosas, usando `list-artisan-commands` para verificar las opciones disponibles en `php artisan make:model`.

### APIs y Recursos Eloquent

- Para APIs, usa por defecto Recursos API Eloquent y versionado de API, a menos que las rutas API existentes no lo hagan; en ese caso, sigue la convención existente de la aplicación.

## Controladores y Validación

- Siempre crea clases Form Request para la validación en lugar de validación en línea en los controladores. Incluye tanto reglas de validación como mensajes de error personalizados.
- Revisa los Form Requests hermanos para ver si la aplicación usa reglas de validación basadas en arrays o en strings.

## Autenticación y Autorización

- Usa las funcionalidades de autenticación y autorización integradas de Laravel (gates, policies, Sanctum, etc.).

## Generación de URLs

- Al generar enlaces a otras páginas, prefiere rutas con nombre y la función `route()`.

## Colas

- Usa jobs en cola para operaciones que consumen mucho tiempo con la interfaz `ShouldQueue`.

## Configuración

- Usa variables de entorno solo en archivos de configuración — nunca uses la función `env()` directamente fuera de los archivos de configuración. Siempre usa `config('app.name')`, no `env('APP_NAME')`.

## Testing

- Al crear modelos para tests, usa las factories de los modelos. Verifica si la factory tiene estados personalizados que se puedan usar antes de configurar el modelo manualmente.
- Faker: Usa métodos como `$this->faker->word()` o `fake()->randomDigit()`. Sigue las convenciones existentes sobre si usar `$this->faker` o `fake()`.
- Al crear tests, usa `php artisan make:test [options] {name}` para crear un test de feature, y pasa `--unit` para crear un test unitario. La mayoría de los tests deben ser tests de feature.

## Error de Vite

- Si recibes un error "Illuminate\Foundation\ViteException: Unable to locate file in Vite manifest", puedes ejecutar `npm run build` o pedir al usuario que ejecute `npm run dev` o `composer run dev`.

=== laravel/v12 rules ===

# Laravel 12

- CRÍTICO: SIEMPRE usa la herramienta `search-docs` para documentación de Laravel específica de la versión y ejemplos de código actualizados.
- Desde Laravel 11, Laravel tiene una nueva estructura de archivos simplificada que este proyecto usa.

## Estructura de Laravel 12

- En Laravel 12, el middleware ya no se registra en `app/Http/Kernel.php`.
- El middleware se configura declarativamente en `bootstrap/app.php` usando `Application::configure()->withMiddleware()`.
- `bootstrap/app.php` es el archivo para registrar middleware, excepciones y archivos de routing.
- `bootstrap/providers.php` contiene los service providers específicos de la aplicación.
- El archivo `app\Console\Kernel.php` ya no existe; usa `bootstrap/app.php` o `routes/console.php` para la configuración de consola.
- Los comandos de consola en `app/Console/Commands/` están disponibles automáticamente y no requieren registro manual.

## Base de Datos

- Al modificar una columna, la migración debe incluir todos los atributos que se definieron previamente en la columna. De lo contrario, se eliminarán y perderán.
- Laravel 12 permite limitar registros cargados con eager loading de forma nativa, sin paquetes externos: `$query->latest()->limit(10);`.

### Modelos

- Los casts pueden y probablemente deberían definirse en un método `casts()` en el modelo en lugar de en la propiedad `$casts`. Sigue las convenciones existentes de otros modelos.

=== pint/core rules ===

# Formateador de Código Laravel Pint

- Si has modificado algún archivo PHP, debes ejecutar `vendor/bin/pint --dirty --format agent` antes de finalizar los cambios para asegurarte de que tu código coincida con el estilo esperado del proyecto.
- No ejecutes `vendor/bin/pint --test --format agent`, simplemente ejecuta `vendor/bin/pint --format agent` para corregir cualquier problema de formato.

=== pest/core rules ===

## Pest

- Este proyecto usa Pest para testing. Crea tests: `php artisan make:test --pest {name}`.
- Ejecuta tests: `php artisan test --compact` o filtra: `php artisan test --compact --filter=nombreDelTest`.
- NO elimines tests sin aprobación.
- CRÍTICO: SIEMPRE usa la herramienta `search-docs` para documentación de Pest específica de la versión y ejemplos de código actualizados.
- IMPORTANTE: Activa `pest-testing` cada vez que trabajes con una tarea relacionada con Pest o testing.

=== tailwindcss/core rules ===

# Tailwind CSS

- Siempre usa las convenciones Tailwind existentes; verifica los patrones del proyecto antes de agregar nuevos.
- IMPORTANTE: Siempre usa la herramienta `search-docs` para documentación de Tailwind CSS específica de la versión y ejemplos de código actualizados. Nunca dependas de los datos de entrenamiento.
- IMPORTANTE: Activa `tailwindcss-development` cada vez que trabajes con una tarea relacionada con Tailwind CSS o estilos.

</laravel-boost-guidelines>
