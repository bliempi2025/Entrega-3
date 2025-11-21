<?php
session_start();
header('Content-Type: application/json');
require 'conex.php';

// 1. Verificar sesión
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'No autorizado']);
    exit;
}

// 2. Recibir datos JSON
$data = json_decode(file_get_contents('php://input'), true);

$id = $data['id'];
$game = $data['game'];
$category = $data['category'];
$time_record = $data['time_record'];
$video_link = $data['video_link'];
$user_id = $_SESSION['user_id'];

// 3. ACTUALIZAR (UPDATE) verificando user_id para seguridad
$sql = "UPDATE speedruns SET game=?, category=?, time_record=?, video_link=? WHERE id=? AND user_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssii", $game, $category, $time_record, $video_link, $id, $user_id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(['status' => 'success', 'message' => 'Run actualizado correctamente.']);
    } else {
        // Si no hubo cambios o el ID no coincidía
        echo json_encode(['status' => 'success', 'message' => 'Datos guardados (sin cambios detectados).']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error al actualizar.']);
}

$stmt->close();
$conn->close();
?>