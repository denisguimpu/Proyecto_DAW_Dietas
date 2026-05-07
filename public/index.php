<?php
/**
 * PUNTO DE ENTRADA DE LA APLICACIÓN
 * =========================
 * 
 * Este es el primer archivo PHP que se ejecuta cuando alguien accede a la web.
 * Es como la "puerta principal" de la aplicación.
 * 
 * Cuando escribes "localhost:8000" en el navegador:
 * 1. El servidor web busca este archivo (index.php)
 * 2. Este archivo carga Laravel
 * 3. Laravel procesa la petición y devuelve una página
 */

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

/**
 * Definimos una constante con el tiempo exacto en que empieza todo.
 * Esto sirve para medircuánto tarda la página en cargar (benchmarking).
 * microtime(true) devuelve el tiempo actual en segundos (con decimales).
 */
define('LARAVEL_START', microtime(true));

// ============================================================================
// MODO MANTENIMIENTO
// ============================================================================
// Primero comprobamos si la aplicación está en "modo mantenimiento".
// Si alguien hace "php artisan down", la app se pone en mantenimiento
// y este archivo muestra un mensaje de "volvemos pronto".
// El archivo storage/framework/maintenance.php guarda la información.
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    // Si existe, lo cargamos y mostramos el mensaje de mantenimiento
    require $maintenance;
}

// ============================================================================
// CARGADOR AUTOMÁTICO DE COMPOSER
// ============================================================================
// Composer es el gestor de dependencias de PHP.
// Cuando haces "composer install", descarga todas las librerías necesarias.
// Este archivo (autoload.php) carga automáticamente todas esas librerías.
// Sin esto, tendríamos que cargar cada archivo a mano.
require __DIR__.'/../vendor/autoload.php';

// ============================================================================
// ARRANCAR LARAVEL
// ============================================================================
// Aqui es donde pasa la magia:
// 1. Cargamos el archivo bootstrap/app.php que prepara Laravel
// 2. Creamos la aplicación ($app)
// 3. $app->handleRequest() procesa la petición del usuario
// 4. Devuelve la página HTML correspondiente

/** @var Application $app */
//require_once carga el archivo una sola vez (evita errores si se carga dos veces)
$app = require_once __DIR__.'/../bootstrap/app.php';

// handleRequest() es el método que:
// - Mira qué URL pidió el usuario
// - Busca qué controlador y método debe usar
// - Ejecuta ese código
// - Devuelve la respuesta (HTML, JSON, etc.)
$app->handleRequest(Request::capture());
