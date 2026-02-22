@echo off
echo Probando conexion a MySQL...
echo.
echo Intento 1: Sin contrasena
"C:\Program Files\MySQL\MySQL Server 8.0\bin\mysql.exe" -u root -e "SELECT 'Conexion exitosa sin contrasena' as resultado;" 2>nul
if %errorlevel%==0 (
    echo [OK] MySQL funciona SIN contrasena
    echo Configurando .env...
    exit /b 0
)

echo.
echo Intento 2: Contrasena vacia
"C:\Program Files\MySQL\MySQL Server 8.0\bin\mysql.exe" -u root -p"" -e "SELECT 'Conexion exitosa con contrasena vacia' as resultado;" 2>nul
if %errorlevel%==0 (
    echo [OK] MySQL funciona con contrasena vacia
    exit /b 0
)

echo.
echo Intento 3: Contrasena 'root'
"C:\Program Files\MySQL\MySQL Server 8.0\bin\mysql.exe" -u root -p"root" -e "SELECT 'Conexion exitosa' as resultado;" 2>nul
if %errorlevel%==0 (
    echo [OK] MySQL funciona con contrasena: root
    exit /b 0
)

echo.
echo Intento 4: Contrasena 'password'
"C:\Program Files\MySQL\MySQL Server 8.0\bin\mysql.exe" -u root -p"password" -e "SELECT 'Conexion exitosa' as resultado;" 2>nul
if %errorlevel%==0 (
    echo [OK] MySQL funciona con contrasena: password
    exit /b 0
)

echo.
echo Intento 5: Contrasena 'admin'
"C:\Program Files\MySQL\MySQL Server 8.0\bin\mysql.exe" -u root -p"admin" -e "SELECT 'Conexion exitosa' as resultado;" 2>nul
if %errorlevel%==0 (
    echo [OK] MySQL funciona con contrasena: admin
    exit /b 0
)

echo.
echo [ERROR] No se pudo conectar con las contrasenas comunes.
echo.
echo SOLUCION: Abre MySQL Workbench o restablece la contrasena manualmente.
echo O dime cual es tu contrasena de MySQL para configurar el .env
pause
