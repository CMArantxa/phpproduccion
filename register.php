<?php
if(isset($_POST["username"])){
    include("conexion.php");
    $username=$_POST["username"];
    $password=$_POST["password"];
    $email=$_POST["email"];
    // Procesar la imagen
    $image = $_FILES["file"]["name"];
    $target_dir = "assets/img/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);

    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Verificar si la imagen es real o falsa
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["file"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Verificar si el archivo ya existe
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Verificar el tamaño de la imagen
    if ($_FILES["file"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Permitir ciertos formatos de archivo
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Verificar si $uploadOk está configurado en 0 por un error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // Si todo está bien, intenta subir el archivo
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            $sql="insert into user (username,email,password,image) values (?,?,?,?)";
            $stm=$conn->prepare($sql);
            $stm->bindParam(1,$username);
            $stm->bindParam(2,$email);
            $stm->bindParam(3,$password);
            $stm->bindParam(4,$image);
            $stm->execute();
            if($stm->rowCount()>0){
                $msg="Usuario creado correctamente";
            }else{
                $msg="Error al crear el Usuario";
            }

        }
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <style>
        h2{
            color:#4caf50;
    text-align: center;
    margin-top: 20px;
    margin-bottom: 50px;
    font-size: 22px;
        }
        form {
    max-width: 400px; /* Aumentar el ancho del formulario */
    margin: 0 auto;
    padding: 30px; /* Aumentar el espacio dentro del formulario */
    border: 1px solid #ccc;
    border-radius: 10px; /* Aumentar el radio de las esquinas */
}

label {
    font-weight: bold;
    margin-bottom: 10px; /* Aumentar el espacio entre las etiquetas y los campos de entrada */
    font-size: 18px; /* Aumentar el tamaño de la fuente de las etiquetas */
}

input[type="text"],
input[type="email"],
input[type="password"],
input[type="file"] {
    width: 100%;
    padding: 12px; /* Aumentar el espacio dentro de los campos de entrada */
    margin-bottom: 15px; /* Aumentar el espacio entre los campos de entrada */
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    font-size: 16px; /* Aumentar el tamaño de la fuente de los campos de entrada */
}

button[type="submit"] {
    background-color: #4caf50;
    color: white;
    padding: 12px 20px; /* Aumentar el espacio dentro del botón */
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px; /* Aumentar el tamaño de la fuente del botón */
}

button[type="submit"]:hover {
    background-color: #45a049;
}


    </style>
    <h2>Regístrate</h2>
    <form action="register.php" method="post" enctype="multipart/form-data">
        <label for="username">Username:</label><br>
        <input type="text" name="username" id="username" placeholder="username"><br>
        
        <label for="email">Email:</label><br>
        <input type="email" name="email" id="email" placeholder="email"><br>
        
        <label for="password">Password:</label><br>
        <input type="password" name="password" id="password" placeholder="password"><br>
        
        <label for="file">Archivo:</label><br>
        <input type="file" name="file" id="file"><br>
        
        <button type="submit">Enviar</button>
    </form>
</body>
</html>

    <?php
    if(isset($msg)){
        echo "<p>".$msg."</p>";
    }
    ?>
</body>
</html>