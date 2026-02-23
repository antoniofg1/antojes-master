<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Test - Servidor Funcionando</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f0f0f0;
        }
        .success {
            background: #d4edda;
            border: 2px solid #28a745;
            color: #155724;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .info {
            background: #e3f2fd;
            border: 2px solid #2196F3;
            padding: 15px;
            border-radius: 8px;
            margin: 10px 0;
        }
        h1 { color: #28a745; }
        code {
            background: #282c34;
            color: #61dafb;
            padding: 2px 6px;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <div class="success">
        <h1>✅ Servidor PHP Funcionando</h1>
        <p>Si ves este mensaje, el servidor está arrancado y sirviendo archivos HTML correctamente.</p>
    </div>
    
    <div class="info">
        <h3>Información del servidor:</h3>
        <p><strong>PHP Version:</strong> <?php echo phpversion(); ?></p>
        <p><strong>Server API:</strong> <?php echo php_sapi_name(); ?></p>
        <p><strong>Current Time:</strong> <?php echo date('Y-m-d H:i:s'); ?></p>
        <p><strong>Document Root:</strong> <code><?php echo $_SERVER['DOCUMENT_ROOT'] ?? 'N/A'; ?></code></p>
        <p><strong>Request URI:</strong> <code><?php echo $_SERVER['REQUEST_URI'] ?? 'N/A'; ?></code></p>
    </div>

    <div class="info">
        <h3>URLs de prueba:</h3>
        <ul>
            <li><a href="/">Raíz (API Info)</a></li>
            <li><a href="/health">Health Check (JSON)</a></li>
            <li><a href="/api/login">API Login (POST)</a></li>
            <li><a href="/check.html">Verificación automática</a></li>
            <li><a href="/index.html">Interfaz principal</a></li>
        </ul>
    </div>

    <div class="info">
        <h3>Prueba de API en consola del navegador:</h3>
        <button onclick="testAPI()">🧪 Probar API Health</button>
        <pre id="result" style="background: #282c34; color: #61dafb; padding: 10px; border-radius: 5px; margin-top: 10px; display: none;"></pre>
    </div>

    <script>
        async function testAPI() {
            const resultEl = document.getElementById('result');
            resultEl.style.display = 'block';
            resultEl.textContent = 'Probando...';
            
            try {
                const response = await fetch('/health', {
                    headers: { 'X-API-KEY': 'test-api-key' }
                });
                const data = await response.json();
                resultEl.textContent = JSON.stringify(data, null, 2);
            } catch (error) {
                resultEl.textContent = 'Error: ' + error.message;
            }
        }
    </script>
</body>
</html>
