<?php

function conectarDB() : mysqli {
    $db = new mysqli('localhost', 'root', 'LMip092132493@', 'bienesraices_crud');
    if(!$db) {
        echo "Error no se pudo conectar";
        exit;
    }

    return $db;
}