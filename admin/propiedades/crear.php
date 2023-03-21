
<?php
//Reporte de error si existe
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>

<?php
    //Usuario autenticado
    require __DIR__.'../../../includes/app.php';

    use App\ActiveRecord;
    use App\propiedad;
    use App\vendedor;
    use Intervention\Image\ImageManagerStatic as Image;

    $propiedad = new propiedad;

    //Consulta para obtener todos los vendedores
    $vendedores = vendedor::all();
    
    // $ar=[];
    // foreach($vendedores as $vendedor) {
    //     $ar[] = $vendedor->nombre;
    // };

    // debugg($ar);

    autenticar();

    //Base de datos
    //require __DIR__.'../../../includes/config/database.php';   
    $db = conectarDB();

    //Consulta para obtener vendedores
    $consulta = 'SELECT * FROM vendedores';
    $resconsult = mysqli_query($db,$consulta);

    //Arreglo de errores
    $errores  = propiedad::getErrores();

    //Ejecución de código después que usuario envía todos los datos del formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        /** Crea una nueva instancia **/
        $propiedad = new propiedad($_POST['propiedad']);

        /** SUBIDA DE ARCHIVOS **/
        
        //Generar un nombre único
        $nombreImagen = md5( uniqid( rand(), true)).'.jpg';

        //Setear la imagen: Relizar un resize a la imagen con intervention
        if($_FILES['propiedad']['tmp_name']['imagen']) {
            $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
            $propiedad->setImagen($nombreImagen);
        }
        

        //Validar errores
        $errores = $propiedad->validar();


        if(empty($errores)){

            //Crear Carpeta
            if(!is_dir(CARPETA_IMAGENES)) {
                mkdir(CARPETA_IMAGENES);
            }

            //Guarda la imagen en el servidor
            $image->save(CARPETA_IMAGENES . $nombreImagen);

            //Guarda la propiedad
            $resultado = $propiedad->guardar();

            //$resultado = mysqli_query($db, $query);

            
        } 
        
    };

    //require __DIR__.'../../../includes/funciones.php';    
    incluirTemplate('headers');
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Crear</h1>
        <a href="/admin" class="boton boton-verde">Regresar</a>
        <?php foreach ($errores as $error): ?>
            <div class="alert error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>


    <form action="" class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">
        <!-- enctype junto con el metodo $_FILES permiten mostrar las propiedades del archivo que se sube -->
        
        <?php include '../../includes/templates/formulario_propiedades.php' ?>
        
        <input type="hidden" name="propiedad[creado]" value="<?php echo date('Y-m-d'); ?>">
        <input type="hidden" name="propiedad[actualizado]" value="<?php echo date('Y-m-d'); ?>">
        <input type="submit" value="Crear Propiedad" class="boton boton-verde">
    </form>

    </main>

<?php
    incluirTemplate('footers');
?>