<?php

//require 'app.php';
define('TEMPLATES_URL', __DIR__.'/templates/');
define('FUNCIONES_URL', __DIR__.'funciones.php');

function incluirTemplate ($nombre,$inicio = false) {
    include TEMPLATES_URL.$nombre.'.php';
};

function autenticar() {
    session_start();

    $auth = $_SESSION['login'];

    if(!$auth) {
        header('Location: /');
        session_unset();
        session_destroy();
        exit;
    }

    

    $actividad = $_SESSION['ultima_actividad'];

    $_SESSION['ultima_actividad'] = time();

    //Programación de cierre de sesión después de 5 minutos
    if (isset($actividad) && (time() - $actividad > 300)) {
        // Cerrar la sesión
        //header("Refresh:5");
        header('Location: /');
        
        session_unset();
        session_destroy();
        exit;
    }

};