<?php
// 1. Listar datos de la BD: Realiza una consulta SELECT para obtener todos los registros de la tabla 'speedruns'.
// 2. Devolver JSON: Formatea los resultados en un array y los codifica a JSON para ser enviados a JavaScript.

header('Content-Type: application/json');
require 'conex.php';

$runs = array(); // Array para guardar los registros

$sql = "SELECT id, nickname, game, category, time_record, video_link FROM speedruns ORDER BY game, time_record ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Obtener cada fila de resultados y añadirla al array
    while($row = $result->fetch_assoc()) {
        $runs[] = $row;
    }
}

$conn->close();

// Imprimir el array en formato JSON
echo json_encode($runs);
?>