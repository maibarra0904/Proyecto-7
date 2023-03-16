
<?php
//Reporte de error si existe
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>

<?php
    //Usuario autenticado
    require __DIR__.'../../../includes/app.php';  

    use App\propiedad;
    use Intervention\Image\ImageManagerStatic as Image;

    // $propiedad = new propiedad;

    // debugg($propiedad);

    autenticar();

    //Base de datos
    //require __DIR__.'../../../includes/config/database.php';   
    $db = conectarDB();

    //Consulta para obtener vendedores
    $consulta = 'SELECT * FROM vendedores';
    $resconsult = mysqli_query($db,$consulta);

    //Arreglo de errores
    $errores  = propiedad::getErrores();

    $titulo = "";
    $precio = "";
    $descripcion = "";
    $habitaciones = "";
    $wc = "";
    $estacionamiento = "";
    $vendedores_id = "";

    //Ejecución de código después que usuario envía todos los datos del formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        /** Crea una nueva instancia **/
        $propiedad = new propiedad($_POST);

        /** SUBIDA DE ARCHIVOS **/
        
        //Generar un nombre único
        $nombreImagen = md5( uniqid( rand(), true)).'.jpg';

        //Setear la imagen: Relizar un resize a la imagen con intervention
        if($_FILES['imagen']['tmp_name']) {
            $image = Image::make($_FILES['imagen']['tmp_name'])->fit(800,600);
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

            if($resultado) {
                //Redireccionar al usuario para evitar datos duplicados

                header('Location: /admin?resultado=1'); //Se crea variable dentro para llamarla en index
            }
        } else {
            //echo "Registro no insertado";
        };

        
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
        <fieldset>
            <legend>Información General</legend>

            <label for="titulo">Titulo:</label>
            <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad" value="<?php echo $titulo; ?>">

            <label for="previo">Precio:</label>
            <input type="number" id="precio" name="precio" placeholder="Precio Propiedad" value="<?php echo $precio; ?>">

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

            <label for="descripcion" >Descripcion:</label>
            <textarea id="descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>
        </fieldset>

        <fieldset>
            <legend>Información Propiedad</legend>

            <label for="habitaciones">Habitaciones:</label>
            <input type="number" name="habitaciones" placeholder="Ej: 3" min="1" max="9" value="<?php echo $habitaciones; ?>">

            <label for="wc">Baños:</label>
            <input type="number" name="wc" placeholder="Ej: 2" min="1" max="9" value="<?php echo $wc; ?>">

            <label for="estacionamiento">Estacionamiento:</label>
            <input type="number" name="estacionamiento" placeholder="Ej: 1" min="1" max="9" value="<?php echo $estacionamiento; ?>">
        </fieldset>

        <fieldset>
            <legend>Vendedor</legend>
            <select name="vendedores_id">
                <option value="" <?php echo $vendedores_id===''?'selected':'';?> disabled>---Seleccione Vendedor---</option>
                <?php while ($vendedores = mysqli_fetch_assoc($resconsult)): ?>
                    <option value="<?php echo $vendedores['id'];?>" <?php echo $vendedores['id']===$vendedores_id?'selected':'';?>> <?php echo $vendedores['nombre']." ".$vendedores['apellido'];?> </option>
                <?php endwhile; ?>
            </select>
        </fieldset>
        <input type="hidden" name="creado" value="<?php echo date('Y-m-d'); ?>">
        <input type="submit" value="Crear Propiedad" class="boton boton-verde">
    </form>

    </main>

<?php
    incluirTemplate('footers');
?>