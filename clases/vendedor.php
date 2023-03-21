<?php

namespace App;

class vendedor extends ActiveRecord {

    protected static $tabla = 'vendedores';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono'];

    public $id;
    public $nombre;
    public $apellido;
    public $telefono;

    public function __construct($args = [])
    {
    
        //Todo lo que está como public, se lo referencia con this
        $this -> id = $args['id'] ?? null;
        $this -> nombre = $args['nombre'] ?? '';
        $this -> apellido = $args['apellido'] ?? '';
        $this -> telefono = $args['telefono'] ?? '';
        
    }

    public function validar() {
        if(!$this->nombre){
            self::$errores[] = 'Debes ingresar un nombre';
        };
        if(!$this->apellido){
            self::$errores[] = 'Debes ingresar un apellido';
        };

        if(!preg_match("/^\d{10}$/", $this->telefono)) {
            self::$errores[] = 'Debes ingresar un teléfono válido';
        }

        return self::$errores;
    }

}