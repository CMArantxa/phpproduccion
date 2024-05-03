<?php
if(isset($_POST["email"])){
    try{
        require_once("conexion.php");
        $email=$_POST["email"];
        $password=$_POST["password"];
        $sql="select * from user where email=? and password=?";
        $stm=$conn->prepare($sql);
        $stm->bindParam(1,$email);
        $stm->bindParam(2,$password);
        $stm->execute();
        if($stm->rowCount()>0){
            $result=$stm->fetchAll(PDO::FETCH_ASSOC);
            $username=$result[0]["username"];
            $iduser=$result[0]["iduser"];
            session_start();
            $_SESSION["username"]=$username;
            $_SESSION["iduser"]=$iduser;
            header("Location: ./");
            exit();
        }else{
            $error="Usuario o Contraseña incorrecto";
        }
    }catch(Exception $e){
        $error="Error interno ".$e->getMessage();
    }
    
}
?>

<?php
if(isset($error)){
    echo $error;
}
?>
<?php
// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Aquí puedes agregar la lógica para verificar las credenciales del usuario
    // Por ejemplo, puedes comparar con valores almacenados en una base de datos
    
    // Ejemplo de verificación simple
    $valid_username = "usuario";
    $valid_password = "contraseña";

    if ($username === $valid_username && $password === $valid_password) {
        // Si las credenciales son válidas, redirigir a la página de inicio
        header("Location: inicio.php");
        exit;
    } else {
        // Si las credenciales son inválidas, mostrar un mensaje de error
        $error_message = "Credenciales incorrectas. Por favor, inténtalo de nuevo.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>Login</title>
</head>
<body>
    <style>
body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column; /* Cambiar a flex-direction: column para que el contenido esté apilado verticalmente */
    align-items: center; /* Centrar horizontalmente el contenido */
    height: 100vh;
}

.container {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 300px;
}

h2 {
    color:#4caf50;
    text-align: center;
    margin-top: 20px;
    margin-bottom: 50px;
    font-size: 22px;
}

form {
    display: flex;
    flex-direction: column;
}

label {
    margin-bottom: 5px;
}

input[type="text"],
input[type="password"],
input[type="submit"] {
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: calc(100% - 22px); /* Ajuste para compensar el ancho del borde */
}

input[type="submit"] {
    background-color: #4caf50;
    color: white;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

.error-message {
    color: #ff0000;
    margin-top: 10px;
}

p {
    text-align: center;
}

a {
    color: #007bff;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}


    </style>
    <h2>Log in</h2>
    <form action="login.php" method="post">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        <input type="submit" value="Login">
        <p>¿No tienes una cuenta? <a href="register.php">Regístrate aquí</a></p>
    </form>
 <?php if (isset($error_message)) echo "<p>$error_message</p>"; ?>
   </body>
</html>

