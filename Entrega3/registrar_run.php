<?php
session_start(); // Necesario para acceder a $_SESSION
header('Content-Type: application/json');
require 'conex.php';

$response = array();

// Verificar login
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Debes iniciar sesión.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id']; // ID del usuario logueado
    $nickname = $_SESSION['user'];   // Usamos el nick de la sesión para evitar fraudes
    
    $game = $_POST['game'];
    $category = $_POST['category'];
    $time_record = $_POST['time_record'];
    $video_link = $_POST['video_link'];

    if (!empty($game) && !empty($category) && !empty($time_record)) {
        // Insertamos incluyendo el user_id
        $stmt = $conn->prepare("INSERT INTO speedruns (user_id, nickname, game, category, time_record, video_link) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $user_id, $nickname, $game, $category, $time_record, $video_link);

        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = '¡Speedrun registrado con éxito!';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Error SQL: ' . $stmt->error;
        }
        $stmt->close();
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Completa todos los campos.';
    }
}

$conn->close();
echo json_encode($response);
?>