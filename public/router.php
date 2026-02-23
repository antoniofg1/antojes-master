<?php
// Router para PHP built-in server

// Obtener la URI solicitada
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Si es un archivo que existe en el sistema, servirlo directamente
if ($uri !== '/' && file_exists(__DIR__ . $uri) && is_file(__DIR__ . $uri)) {
    // Dejar que PHP built-in maneje el archivo estático
    return false;
}

// Para cualquier otra ruta, cargar index.php de Symfony
require_once __DIR__ . '/index.php';
