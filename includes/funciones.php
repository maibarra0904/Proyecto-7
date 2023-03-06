<?php

require 'app.php';

function incluirTemplate ($nombre,$inicio = false) {
    include TEMPLATES_URL.$nombre.'.php';
};

function autenticar() {
    session_start();

    $auth = $_SESSION['login'];

    if(!$auth) {
        header('Location: /');
        session_abort();
    }
};