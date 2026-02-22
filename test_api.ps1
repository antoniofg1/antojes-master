# Script de prueba para API Antojes

Write-Host "`n=== PRUEBA 1: LOGIN ===" -ForegroundColor Cyan
$loginBody = @{
    email = 'maria.garcia@valencia.com'
    password = 'password123'
} | ConvertTo-Json

$apiKeyHeader = @{
    'X-API-KEY' = 'test-api-key'
}

try {
    $loginResponse = Invoke-RestMethod -Uri 'http://localhost:8000/api/login' `
        -Method Post `
        -Body $loginBody `
        -Headers $apiKeyHeader `
        -ContentType 'application/json'
    
    Write-Host "[ OK] Login exitoso" -ForegroundColor Green
    Write-Host ($loginResponse | ConvertTo-Json -Depth 5)
    
    $token = $loginResponse.data.token
    $headers = @{
        'Authorization' = "Bearer $token"
        'X-API-KEY' = 'test-api-key'
    }
    
    Write-Host "`n=== PRUEBA 2: HOME (Usuario + Cercanos) ===" -ForegroundColor Cyan
    $homeResponse = Invoke-RestMethod -Uri 'http://localhost:8000/api/home' `
        -Method Get `
        -Headers $headers
    
    Write-Host "[OK] Home obtenido" -ForegroundColor Green
    Write-Host ($homeResponse | ConvertTo-Json -Depth 5)
    
    Write-Host "`n=== PRUEBA 3: GENERAL (Todos los usuarios) ===" -ForegroundColor Cyan
    $generalResponse = Invoke-RestMethod -Uri 'http://localhost:8000/api/general' `
        -Method Get `
        -Headers $headers
    
    Write-Host "[OK] General obtenido" -ForegroundColor Green
    Write-Host "Total usuarios: $($generalResponse.data.users.Count)"
    
    Write-Host "`n=== PRUEBA 4: ACTUALIZAR ===" -ForegroundColor Cyan
    $updateBody = @{
        lat = 39.4750
        lng = -0.3760
        online = $true
    } | ConvertTo-Json
    
    $updateResponse = Invoke-RestMethod -Uri 'http://localhost:8000/api/actualizar' `
        -Method Post `
        -Body $updateBody `
        -Headers $headers `
        -ContentType 'application/json'
    
    Write-Host "[OK] Usuario actualizado" -ForegroundColor Green
    Write-Host ($updateResponse | ConvertTo-Json -Depth 5)
    
    Write-Host "`n=== TODAS LAS PRUEBAS EXITOSAS ===" -ForegroundColor Green
    Write-Host "`nFormato de respuesta: {data, error} [OK]" -ForegroundColor Yellow
    
} catch {
    Write-Host "Error: $($_.Exception.Message)" -ForegroundColor Red
    Write-Host $_.Exception -ForegroundColor Red
}
