<?php
session_start();
require_once("conexion.php");
include_once("./models/product.php");

$sql = "select * from product";
$consulta = $conn->prepare($sql);
// Ejecutar la consulta
$consulta->execute();
// Obtener los resultados
$resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
//Compruebo si hay carrito
if (isset($_SESSION["cart"])) {
    $cart = $_SESSION["cart"];
}

if (isset($_SESSION["username"])) {
    //comprobaria si hay carrito en la bbdd
    $user = $_SESSION["username"];
    $iduser = $_SESSION["iduser"];
   // if (!isset($cart) || count($cart) == 0) {
     //   try {
            $sql = "select * from cart_detail where idcart=(select idcart from cart where iduser=? order by date desc limit 1)";
            $stm = $conn->prepare($sql);
            $stm->bindParam(1, $iduser);
            $stm->execute();
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            $cart = array();
            foreach ($result as $key => $p) {
                $_SESSION["idcart"] = $p["idcart"];
                $product = new Product($p["idproduct"], $p["quantity"]);
                array_push($cart, $product); 
            }

            $_SESSION["cart"] = $cart;
            if(isset($_SESSION["idcart"])){
                $idcart=$_SESSION["idcart"];
            }

            //$_SESSION["idcart"]=$result[0]["idcart"];
  //      } catch (Exception $e) {
     //       var_dump($e->getMessage());
     //       exit();
   //     }
   // }
}
$idcart=isset($_SESSION["idcart"])?$_SESSION["idcart"]:"";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Contacto</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.container {
    background-color: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    max-width: 600px;
}

h2 {
    text-align: center;
}

.company-info {
    margin-bottom: 20px;
}

.company-info h3 {
    margin-bottom: 10px;
}

form {
    display: flex;
    flex-direction: column;
}

label {
    font-weight: bold;
    margin-bottom: 10px;
}

input[type="text"],
input[type="email"],
textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

button[type="submit"] {
    background-color: #4caf50;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button[type="submit"]:hover {
    background-color: #45a049;
}

    </style>
    <div class="container">
        <h2>Contacto</h2>
        <div class="company-info">
            <h3>Datos de la Empresa</h3>
            <p>FRUTITAS MOLONAS</p>
            <p>Dirección: 123 Calle Principal, Ciudad, País</p>
            <p>Teléfono: (123) 456-7890</p>
            <p>Email: info@empresa.com</p>
        </div>
        <form action="enviar.php" method="post">
            <label for="nombre">Nombre:</label><br>
            <input type="text" name="nombre" id="nombre" placeholder="Tu nombre" required><br>
            
            <label for="email">Email:</label><br>
            <input type="email" name="email" id="email" placeholder="Tu correo electrónico" required><br>
            
            <label for="mensaje">Mensaje:</label><br>
            <textarea name="mensaje" id="mensaje" rows="5" placeholder="Escribe tu mensaje aquí" required></textarea><br>
            
            <button type="submit">Enviar Mensaje</button>
        </form>
    </div>
</body>
</html>

