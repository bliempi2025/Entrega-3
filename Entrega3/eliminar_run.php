<?php
session_start();
header('Content-Type: application/json');
require 'conex.php';

// 1. Verificar sesión
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'No autorizado']);
    exit;
}

// 2. Obtener datos
$data = json_decode(file_get_contents('php://input'), true);
$run_id = $data['id'] ?? null;
$user_id = $_SESSION['user_id'];

if (!$run_id) {
    echo json_encode(['status' => 'error', 'message' => 'ID no válido']);
    exit;
}

// 3. Eliminar SOLO si coincide el ID del run Y el user_id (Seguridad)
$stmt = $conn->prepare("DELETE FROM speedruns WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $run_id, $user_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(['status' => 'success', 'message' => 'Run eliminado correctamente.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No se pudo eliminar (quizás no eres el dueño).']);
}

$stmt->close();
$conn->close();
?>