<?php
// Router para PHP built-in server

// Obtener la URI solicitada
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$filePath = __DIR__ . $uri;

// Log para debugging (aparecerá en los logs de Render)
error_log("Router: Requested URI: $uri");
error_log("Router: File path: $filePath");
error_log("Router: File exists: " . (file_exists($filePath) ? 'YES' : 'NO'));

// Si es un archivo que existe en el sistema, servirlo directamente
if ($uri !== '/' && file_exists($filePath) && is_file($filePath)) {
    error_log("Router: Serving static file: $filePath");
    // Dejar que PHP built-in maneje el archivo estático
    return false;
}

// Para cualquier otra ruta, cargar index.php de Symfony
error_log("Router: Loading Symfony index.php for: $uri");
require_once __DIR__ . '/index.php';
