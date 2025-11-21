<?php
header('Content-Type: application/json');
require 'conex.php';

$runs = array();

// Seleccionamos también user_id para saber quién puede borrar qué
$sql = "SELECT id, user_id, nickname, game, category, time_record, video_link FROM speedruns ORDER BY submission_date DESC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $runs[] = $row;
    }
}

$conn->close();
echo json_encode($runs);
?>