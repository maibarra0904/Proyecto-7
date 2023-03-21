<?php
    //Forma de verificar si una sesion esta activa y traer las variables de sesion autenticada
    if(!isset($_SESSION)) {
        session_start();
    }
    
    $auth = $_SESSION['login'] ?? false;

    $current_url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

    

    $parsed_url = parse_url($current_url);
    $host = $parsed_url['host'];
    //debugg($_SERVER['HTTP_HOST']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienes Raices</title>
    <link rel="stylesheet" href="/build/css/app.css">
</head>
<body>
    
    <header class="header <?php echo $inicio ? 'inicio' : ''; ?>">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="../../index.php">
                    <img src="/build/img/logo.svg" alt="Logotipo de Bienes Raices">
                    
                </a>

                <div class="mobile-menu">
                    <img src="/build/img/barras.svg" alt="icono menu responsive">
                </div>

                

                <div class="derecha" id="menu">
                    
                    <div class="superior">
                        <?php if($auth) { 
                            if(strpos($_SERVER['REQUEST_URI'],'/admin') === false){ ?> 
                            <a href="/admin/" class="adm">Admin</a> <?php }; 
                            //debugg(strpos($_SERVER['REQUEST_URI'],'/admin')!== false);
                            ?> 
                            <a href="/cerrar-sesion.php" class="cie">Cerrar Sesión</a>
                        <?php } else { if($_SERVER['REQUEST_URI']!='/login.php') : ?>
                            <a href="login.php" class="ini">Iniciar Sesión</a>
                        <?php endif; }; ?>
                        <img class="dark-mode-boton" src="/build/img/dark-mode.svg" alt="boton oscuro">
                    </div>
                        

                    <nav class="navegacion">
                        <a href="../../nosotros.php">Nosotros</a>
                        <a href="../../anuncios.php">Anuncios</a>
                        <a href="../../blog.php">Blog</a>
                        <a href="../../contacto.php">Contacto</a>
                        
                    </nav>
                    
                </div>
                
            </div>

            <?php if($inicio) { ?>
                <h1>Venta de Casas y Departamentos Exclusivos de Lujo</h1>
            <?php } ?>
            
        </div>

        

    </header>
