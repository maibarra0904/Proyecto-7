<?php

namespace App;

class propiedad {

    //Base de datos

    protected static $db;
    protected static $columnasDB = ['titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 
    'estacionamiento', 'creado', 'vendedores_id', 'actualizado'];
    
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
    public $actualizado;

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
        $this -> vendedores_id = $args['vendedores_id'] ?? 1;
        $this -> descripcion_amp = $args['descripcion_amp'] ?? '';
        $this -> actualizado = $args['actualizado'] ?? '';

    }

    public function guardar() {
        if(isset($this->id)) {
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

    public function actualizar() {
        //Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        $valores = [];
        foreach($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        $query =  " UPDATE propiedades SET ";
        $query .= join(', ', $valores );
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";

        $resultado = self::$db->query($query);

        if($resultado) {
            //Redireccionar al usuario para evitar datos duplicados

            header('Location: /admin?resultado=2'); //Se crea variable dentro para llamarla en index
        }

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

        //Elimina la imagen previa
        if(isset($this->id)) {
            $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);

        }


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

    //Lista todas las propiedades
    public static function all(){
        
        $query = "SELECT * FROM propiedades";

        $resultado = self::consultarSQL($query);
        //$resultado = self::$db->query($query);
        return $resultado;
        
    }


    // Busca un registro por su id
    public static function find($id){
        
        $query = "SELECT * FROM propiedades WHERE id = $id";

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
            $array[] = self::crearObjeto($registro);
        }
        
        //Librar la memoria
        $resultado->free();

        //Retornar los resultados
        return $array;
    }

    protected static function crearObjeto($registro) {
        $objeto = new self;

        foreach($registro as $key => $value) {
            if(property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }
        
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