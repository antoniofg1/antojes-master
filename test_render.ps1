# Test API en Render
$API_URL = "https://chat-geolocalizado-api.onrender.com"
$API_KEY = "test-api-key"

Write-Host "🔍 Testing API deployment..." -ForegroundColor Cyan

# Test 1: Login
Write-Host "`n1️⃣ Testing Login..." -ForegroundColor Yellow
$body = @{
    email = 'maria.garcia@valencia.com'
    password = 'password123'
} | ConvertTo-Json

try {
    $response = Invoke-RestMethod -Uri "$API_URL/api/login" -Method Post -Body $body -ContentType 'application/json' -Headers @{'X-API-KEY'=$API_KEY}
    Write-Host "✅ Login successful!" -ForegroundColor Green
    Write-Host "Token: $($response.data.token.Substring(0,50))..." -ForegroundColor Gray
    Write-Host "User: $($response.data.user.name)" -ForegroundColor Gray
    
    $token = $response.data.token
    
    # Test 2: Home
    Write-Host "`n2️⃣ Testing Home..." -ForegroundColor Yellow
    $homeResponse = Invoke-RestMethod -Uri "$API_URL/api/home" -Method Get -Headers @{
        'Authorization' = "Bearer $token"
        'X-API-KEY' = $API_KEY
    }
    Write-Host "✅ Home successful!" -ForegroundColor Green
    Write-Host "User location: $($homeResponse.data.user.latitude), $($homeResponse.data.user.longitude)" -ForegroundColor Gray
    Write-Host "Nearby users: $($homeResponse.data.nearby_users.Count)" -ForegroundColor Gray
    
    # Test 3: General
    Write-Host "`n3️⃣ Testing General..." -ForegroundColor Yellow
    $generalResponse = Invoke-RestMethod -Uri "$API_URL/api/general" -Method Get -Headers @{
        'Authorization' = "Bearer $token"
        'X-API-KEY' = $API_KEY
    }
    Write-Host "✅ General successful!" -ForegroundColor Green
    Write-Host "Total users: $($generalResponse.data.users.Count)" -ForegroundColor Gray
    
    Write-Host "`n🎉 ALL TESTS PASSED!" -ForegroundColor Green
    Write-Host "`n📚 Documentation: $API_URL/docs.html" -ForegroundColor Cyan
    Write-Host "🧪 Testing UI: $API_URL/index.html" -ForegroundColor Cyan
    
}
catch {
    Write-Host "❌ Error: $($_.Exception.Message)" -ForegroundColor Red
    if ($_.ErrorDetails) {
        Write-Host "Response: $($_.ErrorDetails.Message)" -ForegroundColor Red
    }
}
