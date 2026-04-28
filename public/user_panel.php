<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Terminal Dashboard</title>
    <style>
        :root { --green: #00ff41; --bg: #050505; }
        body { background: var(--bg); color: var(--green); font-family: 'JetBrains Mono', monospace; padding: 40px; }
        .terminal-box { border: 2px solid var(--green); box-shadow: 0 0 15px rgba(0,255,65,0.4); padding: 25px; border-radius: 8px; }
        .header { border-bottom: 1px solid var(--green); margin-bottom: 20px; display: flex; justify-content: space-between; }
    </style>
</head>
<body>
    <div class="terminal-box">
        <div class="header">
            <span>SYS_STATUS: ONLINE</span>
            <span>USER_ID: <?php echo "FRANCISCO_REYES"; ?></span>
        </div>
        <h2>> ACCESO_A_INVENTARIO_ESTABLECIDO</h2>
        <p>Esperando comandos del operador...</p>
    </div>
</body>
</html>
