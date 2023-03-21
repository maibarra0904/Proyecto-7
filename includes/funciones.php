<?php

//require 'app.php';
define('TEMPLATES_URL', __DIR__.'/templates/');
define('FUNCIONES_URL', __DIR__.'funciones.php');
define('CARPETA_IMAGENES', __DIR__.'/../imagenes/');


function incluirTemplate ($nombre,$inicio = false) {
    include TEMPLATES_URL.$nombre.'.php';
};

function autenticar() {
    session_start();

    if(!$_SESSION['login']) {
        header('Location: /');
        session_unset();
        session_destroy();
        exit;
    }


    $actividad = $_SESSION['ultima_actividad'];

    $_SESSION['ultima_actividad'] = time();

    //Programación de cierre de sesión después de 5 minutos
    if (isset($actividad) && (time() - $actividad > 3000)) {
        // Cerrar la sesión
        //header("Refresh:5");
        header('Location: /');
        
        session_unset();
        session_destroy();
        exit;
    }

};

function debugg($variable) {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

//Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

//Validar tipo de contenido
function validarTipoContenido($tipo) {
    $tipos = ['propiedad', 'vendedor'];

    return in_array($tipo, $tipos);
}

function notificacionEvento($id) {

    $mensaje = '';
    $form = '';

    //Verifica url anterior
    $urlAnterior = $_SERVER['HTTP_REFERER'];

    if(isset($urlAnterior)) {
        if(strpos($urlAnterior,'propiedades')){
            $form = 'propiedad';
        } else if (strpos($urlAnterior,'vendedores')) {
            $form = 'vendedor';
        };
    }
    


    switch($id) {
        case 1:
            switch($form) {
                case 'propiedad':
                    $mensaje = 'Propiedad agregada correctamente';
                    break;
                case 'vendedor':
                    $mensaje = 'Vendedor agregado correctamente';
                    break;
                default:
                    $mensaje = false;
                    break;
            }
            break;
        case 2:
            switch($form) {
                case 'propiedad':
                    $mensaje = 'Propiedad actualizada correctamente';
                    break;
                case 'vendedor':
                    $mensaje = 'Vendedor actualizado correctamente';
                    break;
                default:
                    $mensaje = false;
                    break;
            }
            break;
        case 3:
            switch($form) {
                default:
                    $mensaje = 'Registro eliminado exitosamente';
                    break;
            }
            break;

    }


    return $mensaje;


}