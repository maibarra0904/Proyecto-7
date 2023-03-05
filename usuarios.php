<?php 

//Importar la conexión
require 'includes/config/database.php';
$db = conectarDB();

//Crear un email y password
$email = 'correo@correo.com';
$password = '123456';

//Hashear el password (reservarlo para evitar revelaciones)
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

var_dump($passwordHash);

//Query para crear el usuario
$query = "INSERT INTO usuarios (email, password) VALUES ('$email', '$passwordHash');";
echo $query;

//exit;
//Agregarlo a la base de datos
mysqli_query($db, $query);
