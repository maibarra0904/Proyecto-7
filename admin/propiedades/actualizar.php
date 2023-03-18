<?php
    
    //Reporte de error si existe
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    use App\propiedad;
    use Intervention\Image\ImageManagerStatic as Image;

    require __DIR__.'../../../includes/app.php';  
    
    //Configuración de un usuario autenticado
    autenticar();

    //Validar la URL por ID valido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    //echo $id;

    if(!$id) {
        header('Location: /admin');
    }

    //Obtener datos de la propiedad
    $propiedad = propiedad::find($id);
    
    //debugg($propiedad);
    //Consulta para obtener vendedores
    $consulta = 'SELECT * FROM vendedores';
    $resconsult = mysqli_query($db,$consulta);

    //Arreglo con mensajes de errores
    $errores = propiedad::getErrores();

    $titulo = $propiedad->titulo;
    $precio = $propiedad->precio;
    $descripcion = $propiedad->descripcion;
    $habitaciones = $propiedad->habitaciones;
    $wc = $propiedad->wc;
    $estacionamiento = $propiedad->estacionamiento;
    $vendedores_id = $propiedad->vendedores_id;
    $imagenProp = $propiedad->imagen;

    //Ejecución de código después que usuario envía todos los datos del formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        //Asignando files a una variable
        //$imagen = $_FILES['imagen'];

        $args = $_POST['propiedad'];



        $propiedad -> sincronizar($args);

        //debugg($propiedad);

        $errores = $propiedad->validar();

        //Generar un nombre único
        $nombreImagen = md5( uniqid( rand(), true)).'.jpg';

        //Realizar un resize
        if($_FILES['propiedad']['tmp_name']['imagen']) {
            $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
            $propiedad->setImagen($nombreImagen);
        }

        if(empty($errores)){

            $image->save(CARPETA_IMAGENES . $nombreImagen);

            $resultado = $propiedad->guardar();

        } else {
            //echo "Registro no insertado";
        };

        
    };

    //require __DIR__.'../../../includes/funciones.php';    
    incluirTemplate('headers');
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Actualizar Propiedad</h1>
        <a href="/admin" class="boton boton-verde">Regresar</a>
        <?php foreach ($errores as $error): ?>
            <div class="alert error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>


    <form action="" class="formulario" method="POST" enctype="multipart/form-data">
        
        <?php include '../../includes/templates/formulario_propiedades.php' ?>
        
        <input type="hidden" name="propiedad[actualizado]" value="<?php echo date('Y-m-d'); ?>">
        <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
    </form>

    </main>

<?php
    incluirTemplate('footers');
?>