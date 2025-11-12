<?php
// iniciamos la sesion
session_start(); 

require_once 'conex.php';

// recibimos los datos del formulario 
$username = $_POST['username'];
$password_plana = $_POST['password'];

// hasheamos la contraseña para compararla con la de la BD
$password_hasheada = md5($password_plana);

try {
    // buscamos al usuario en la BD
    $sql = "SELECT * FROM usuarios WHERE username = :username AND password = :password";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username, 'password' => $password_hasheada]);

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // verificamos si el usuario existe y las credenciales son correctas
    if ($usuario) {

        // si las credenciales son correctas, iniciamos la sesion
        $_SESSION['loggedin'] = true;
        $_SESSION['user_id'] = $usuario['id']; // la id es importante para hacer lo del CRUD
        $_SESSION['username'] = $usuario['username'];

        // redirigimos al usuario a la pagina principal
        header('Location: index.php');
        exit;
    } else {
        // credenciales incorrectas 
        header('Location: login.php?error=1');
        exit;
    }

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>