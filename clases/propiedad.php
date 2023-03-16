<?php

namespace App;

class propiedad {

    //Base de datos

    protected static $db;
    protected static $columnasDB = ['titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 
    'estacionamiento', 'creado', 'vendedores_id'];
    
    //Arreglo con mensajes de errores
    protected static $errores = [];

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
        $this -> imagen = $args['imagen'] ?? '';
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
        $query =  " INSERT INTO propiedades (";
        $query .= join(', ',array_keys($atributos));
        $query .= " ) 
        VALUES (' "; 
        $query .= join("', '",array_values($atributos));
        $query .= " ');";

        //debugg($query);

        $resultado = self::$db->query($query);


        return $resultado;
    }

    public function atributos() {
        $atributos = [];

        foreach(self::$columnasDB as $columna) {
            if($columna==='id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    //volver Atributos inmunes a código malicioso

    public function sanitizarAtributos(){
        $atributos = $this->atributos();
        //debugg($atributos);
        $sanitizado = [];

        foreach($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }

        return $sanitizado;
    }

    //Subida de archivos
    public function setImagen($imagen) {
        //Asignar al atributo de imagen el nombre de la imagen
        if($imagen) {
            $this -> imagen = $imagen;
        }

    }

    //Validación
    public static function getErrores() {
        return self::$errores;
    }


    public function validar() {
        if(!$this->titulo){
            self::$errores[] = 'El titulo es indispensable';
        };

        if(!$this->precio){
            self::$errores[] = 'Se requiere el precio';
        };

        if(!$this->descripcion){
            self::$errores[] = 'Descripción requerida';
        };

        if(!$this->habitaciones){
            self::$errores[] = 'Ingrese al menos 1 habitación';
        };

        if(!$this->wc){
            self::$errores[] = 'Ingrese al menos 1 baño';
        };

        if(!$this->estacionamiento){
            self::$errores[] = 'Ingrese al menos 1 estacionamiento';
        };

        if(!$this->vendedores_id){
            self::$errores[] = 'Ingrese al menos 1 vendedor';
        };

       
        if(!$this->imagen){
            self::$errores[] = 'La imagen es obligatoria';
        };

        // //Validar por tamaño (100Kb máximo)
        // $medida = 1000*1000;

        // if($this->imagen['size'] > $medida) {
        //     self::$errores[] = 'La imagen es muy pesada';
        // }

        return self::$errores;
    }
  
}