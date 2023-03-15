<?php

namespace App;

class propiedad {

    //Base de datos

    protected static $db;
    protected static $columnasDB = ['titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 
    'estacionamiento', 'creado', 'vendedores_id'];
    

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedores_id;
    public $descripcion_amp;

    public static function setDB($database) {
        //Static se referencia con self
        self::$db = $database;
    }

    public function __construct($args = [])
    {
    
        //Todo lo que está como public, se lo referencia con this
        $this -> id = $args['id'] ?? '';
        $this -> titulo = $args['titulo'] ?? '';
        $this -> precio = $args['precio'] ?? '';
        $this -> imagen = $args['imagen'] ?? 'imagen.jpg';
        $this -> descripcion = $args['descripcion'] ?? '';
        $this -> habitaciones = $args['habitaciones'] ?? '';
        $this -> wc = $args['wc'] ?? '';
        $this -> estacionamiento = $args['estacionamiento'] ?? '';
        $this -> creado = $args['creado'] ?? '';
        $this -> vendedores_id = $args['vendedores_id'] ?? '';
        $this -> descripcion_amp = $args['descripcion_amp'] ?? '';

    }

    public function guardar() {

        //Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        //Insertar base de datos
        $query =  " INSERT INTO propiedades (titulo, precio, imagen, descripcion, habitaciones, wc, 
        estacionamiento, creado, vendedores_id) VALUES ('$this->titulo', $this->precio, '$this->imagen', '$this->descripcion', $this->habitaciones,
        $this->wc, $this->estacionamiento, '$this->creado', $this->vendedores_id);";


        $resultado = self::$db->query($query);


        //debugg($resultado);
    }

    public function atributos() {
        $atributos = [];

        foreach(self::$columnasDB as $columna) {
            if($columna==='id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }


    public function sanitizarAtributos(){
        $atributos = $this->atributos();
        //debugg($atributos);
        $sanitizado = [];

        foreach($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }

        return $sanitizado;
    }
  
}