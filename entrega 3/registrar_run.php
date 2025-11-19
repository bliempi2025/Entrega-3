<?php
// 1. Recibir datos de un formulario: Se usa el método POST para recibir los datos enviados por Fetch.
// 2. Guardar en BD: Los datos se validan y luego se insertan en la tabla 'speedruns'.
// 3. Notificar al usuario: El script devuelve una respuesta JSON con un estado (success/error) y un mensaje.

header('Content-Type: application/json'); // Indica que la respuesta será en formato JSON

// Incluir el archivo de conexión a la BD
require 'conex.php';

$response = array(); // Array para almacenar la respuesta que se enviará a JavaScript

// Verificar que el método de la petición sea POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Obtener y sanear los datos del formulario
    $nickname = $conn->real_escape_string($_POST['nickname']);
    $game = $conn->real_escape_string($_POST['game']);
    $category = $conn->real_escape_string($_POST['category']);
    $time_record = $conn->real_escape_string($_POST['time_record']);
    $video_link = $conn->real_escape_string($_POST['video_link']);

    // Validar que los campos no estén vacíos
    if (!empty($nickname) && !empty($game) && !empty($category) && !empty($time_record) && !empty($video_link)) {
        
        // Preparar la consulta SQL para evitar inyección SQL
        $stmt = $conn->prepare("INSERT INTO speedruns (nickname, game, category, time_record, video_link) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nickname, $game, $category, $time_record, $video_link);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = '¡Speedrun registrado con éxito!';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Error al registrar el speedrun: ' . $stmt->error;
        }
        $stmt->close();
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Todos los campos son obligatorios.';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Método de solicitud no válido.';
}

$conn->close();

// Devolver la respuesta en formato JSON
echo json_encode($response);
?>