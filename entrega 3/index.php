<?php include("conexion.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Speedruns</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">

<div class="container mt-5">
    <h1 class="text-center mb-4">🏁 Lista de Speedruns</h1>

    <div class="text-end mb-3">
        <a href="crear.php" class="btn btn-success">+ Agregar Nuevo</a>
    </div>

    <?php
    // Consulta de todos los registros
    $resultado = $conexion->query("SELECT * FROM speedruns ORDER BY id DESC");
    ?>

    <table class="table table-dark table-hover text-center align-middle">
        <thead>
            <tr>
                <th>ID</th>
                <th>Juego</th>
                <th>Jugador</th>
                <th>Tiempo</th>
                <th>Video</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($fila = $resultado->fetch_assoc()) { ?>
            <tr>
                <td><?= $fila['id'] ?></td>
                <td><?= $fila['juego'] ?></td>
                <td><?= $fila['jugador'] ?></td>
                <td><?= $fila['tiempo'] ?></td>

                <!--  Botón agregado que abre el enlace de YouTube -->
                <td>
                    <a href="<?= $fila['video'] ?>" target="_blank" class="btn btn-danger">
                        Ver video
                    </a>
                </td>

                <td>
                    <a href="editar.php?id=<?= $fila['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                    <a href="eliminar.php?id=<?= $fila['id'] ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Seguro que quieres eliminar este registro?');">Eliminar</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>