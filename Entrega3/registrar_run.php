<?php
header('Content-Type: application/json');

require 'conex.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $nickname = $conn->real_escape_string($_POST['nickname']);
    $game = $conn->real_escape_string($_POST['game']);
    $category = $conn->real_escape_string($_POST['category']);
    $time_record = $conn->real_escape_string($_POST['time_record']);
    $video_link = $conn->real_escape_string($_POST['video_link']);

    if (!empty($nickname) && !empty($game) && !empty($category) && !empty($time_record) && !empty($video_link)) {
        
        $stmt = $conn->prepare("INSERT INTO speedruns (nickname, game, category, time_record, video_link) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nickname, $game, $category, $time_record, $video_link);

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

echo json_encode($response);
?>