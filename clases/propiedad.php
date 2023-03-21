<?php

namespace App;

class propiedad extends ActiveRecord {

    protected static $tabla = 'propiedades';
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 
    'estacionamiento', 'creado', 'vendedores_id', 'actualizado'];

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

    public function __construct($args = [])
    {
    
        //Todo lo que está como public, se lo referencia con this
        $this -> id = $args['id'] ?? null;
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