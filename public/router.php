<?php
// Router para php -S que maneja correctamente todas las peticiones

// Si es un archivo estático que existe, servirlo directamente
if (php_sapi_name() === 'cli-server') {
    $path = __DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    
    // Si el archivo existe y no es un directorio, servirlo
    if (is_file($path) && !is_dir($path)) {
        return false;  // Servir el archivo estático
    }
}

// Para todo lo demás (rutas de la API), usar index.php
require_once __DIR__ . '/index.php';
