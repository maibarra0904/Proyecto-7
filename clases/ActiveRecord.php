<?php

namespace App;


class ActiveRecord {
    
    //Base de datos

    protected static $db;
    protected static $columnasDB = [];

    protected static $tabla = '';
    
    //Arreglo con mensajes de errores
    protected static $errores = [];

    //protected static $args = [];

    //Es necesario declarar las variables para no marcar errores en vsCode mas no porque sean necesarias
    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    //public $creado;
    public $vendedores_id;
    //public $descripcion_amp;
    //public $actualizado;

    public static function setDB($database) {
        //Static se referencia con self
        self::$db = $database;
    }



    public function guardar() {
        if(!is_null($this->id)) {
            $this->actualizar();
        }
        else {
            $this->crear();
        }
    }
    public function crear() {

        //Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        //debugg($atributos);
        //Insertar base de datos
        $query =  " INSERT INTO " . static::$tabla . " (";
        $query .= join(', ',array_keys($atributos));
        $query .= " ) 
        VALUES (' "; 
        $query .= join("', '",array_values($atributos));
        $query .= " ');";

        //debugg($query);

        $resultado = self::$db->query($query);
        //debugg($resultado);

        if($resultado) {
            //Redireccionar al usuario para evitar datos duplicados

            header('Location: /admin?resultado=1'); //Se crea variable dentro para llamarla en index
        }

        return $resultado;
    }

    public function actualizar() {
        //Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        $valores = [];
        foreach($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        $query =  " UPDATE " . static::$tabla . " SET ";
        $query .= join(', ', $valores );
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";

        $resultado = self::$db->query($query);

        if($resultado) {
            //Redireccionar al usuario para evitar datos duplicados

            header('Location: /admin?resultado=2'); //Se crea variable dentro para llamarla en index
        }

        debugg($resultado);
    }

    //Eliminar un registro
    public function eliminar() {
        //Eliminar la propiedad
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";

        //debugg($query);

        $resultado = self::$db->query($query);

        if($resultado) {
            $this->borrarImagen();
            header('Location: /admin?resultado=3');
        }
        return $resultado;
    }

    //Identificar y unir los atributos de la BD
    public function atributos() {
        $atributos = [];

        foreach(static::$columnasDB as $columna) {
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

        //Elimina la imagen previa
        if(!is_null($this->id)) {
           $this->borrarImagen();

        }


        //Asignar al atributo de imagen el nombre de la imagen
        if($imagen) {
            $this->imagen = $imagen;
        }

    }

    //Borrar imagen
    public function borrarImagen() {
        //Comprobar si el archivo existe
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);

        if($existeArchivo) {
            unlink(CARPETA_IMAGENES . $this->imagen);
        }

    }

    //Validación
    public static function getErrores() {
        return static::$errores;
    }


    public function validar() {
        
        static::$errores = [];
        return static::$errores;
    }

    //Lista todas las propiedades
    public static function all(){
        
        $query = "SELECT * FROM " . static::$tabla; //static permite utilizar una variable creada en la clase
        //padre en las clases heredadas

        $resultado = self::consultarSQL($query);
        //$resultado = self::$db->query($query);
        return $resultado;
        
    }


    // Busca un registro por su id
    public static function find($id){
        
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = $id";

        $resultado = self::consultarSQL($query);
        //$resultado = self::$db->query($query);
        return array_shift( $resultado );
        
    }



    public static function consultarSQL($query) {
        //Consultar la base de datos
        $resultado = self::$db->query($query);

        //Iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }
        
        //debugg($array);

        //Librar la memoria
        $resultado->free();

        //Retornar los resultados
        return $array;
    }

    protected static function crearObjeto($registro) {
        $objeto = new static;

        foreach($registro as $key => $value) {
            if(property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }
        //debugg($objeto);
        
        return $objeto;
    }

    //Sincroniza el objeto en memoria con los cambios realizados por el usuario
    public function sincronizar($args = []) {
        foreach($args as $key => $value) {
            if(property_exists($this, $key)  && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }

}
