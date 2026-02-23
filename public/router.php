<?php
// Router para PHP built-in server (php -S)

// Solo aplicar lógica especial si estamos en el servidor built-in
if (php_sapi_name() === 'cli-server') {
    $uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    $filePath = __DIR__ . $uri;
    
    // Si es la raíz, redirigir a index.php
    if ($uri === '/') {
        require_once __DIR__ . '/index.php';
        return true;
    }
    
    // Si el archivo existe y es un archivo estático (no .php), servirlo
    if ($uri !== '/' && is_file($filePath)) {
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        // Permitir archivos estáticos comunes pero NO archivos .php
        if (in_array($extension, ['html', 'css', 'js', 'json', 'jpg', 'jpeg', 'png', 'gif', 'svg', 'ico', 'woff', 'woff2', 'ttf', 'eot'])) {
            return false; // Dejar que PHP built-in lo sirva
        }
    }
    
    // Para rutas de API o cualquier otra ruta, pasar a index.php de Symfony
    $_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/index.php';
    $_SERVER['SCRIPT_NAME'] = '/index.php';
    require_once __DIR__ . '/index.php';
    return true;
}

// Si no es servidor built-in, simplemente cargar index.php
require_once __DIR__ . '/index.php';
