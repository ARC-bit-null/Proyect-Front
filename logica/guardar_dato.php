<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $archivo = 'datos.json';
    
    // 1. Recoger los datos del formulario
    $nuevoDato = [
        "etiqueta" => $_POST['etiqueta'],
        "valor" => (int)$_POST['valor'],
        "fecha" => date("Y-m-d H:i:s")
    ];

    // 2. Leer lo que ya existe en el archivo
    $contenidoActual = file_exists($archivo) ? json_decode(file_get_contents($archivo), true) : [];
    
    // 3. Añadir el nuevo dato
    $contenidoActual[] = $nuevoDato;

    // 4. Guardar de vuelta al JSON
    file_put_contents($archivo, json_encode($contenidoActual, JSON_PRETTY_PRINT));

    // 5. Regresar a la página principal
    header("Location: index.html");
}
?>
