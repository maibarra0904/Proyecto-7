<?php
    //Base de datos
    require __DIR__.'../../../includes/config/database.php';   
    $db = conectarDB();

    //Consulta para obtener vendedores
    $consulta = 'SELECT * FROM vendedores';
    $resconsult = mysqli_query($db,$consulta);

    //Arreglo con mensajes de errores
    $errores = [];

    $titulo = "";
    $precio = "";
    $descripcion = "";
    $habitaciones = "";
    $wc = "";
    $estacionamiento = "";
    $vendedores_id = "";

    //Ejecución de código después que usuario envía todos los datos del formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $titulo = mysqli_real_escape_string($db, $_POST['titulo']);
        $precio = mysqli_real_escape_string($db, $_POST['precio']);
        $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
        $habitaciones = mysqli_real_escape_string($db, $_POST['habitaciones']);
        $wc = mysqli_real_escape_string($db, $_POST['wc']);
        $estacionamiento = mysqli_real_escape_string($db, $_POST['estacionamiento']);
        $vendedores_id = mysqli_real_escape_string($db, $_POST['vendedor']);
        $creado = date('Y/m/d');
        
        //Asignando files a una variable
        $imagen = $_FILES['imagen'];

        // echo "<pre>";
        // var_dump($_FILES['imagen']);
        // echo "</pre>";

        // exit;

        if(!$titulo){
            $errores[] = 'El titulo es indispensable';
        };

        if(!$precio){
            $errores[] = 'Se requiere el precio';
        };

        if(!$descripcion){
            $errores[] = 'Descripción requerida';
        };

        if(!$habitaciones){
            $errores[] = 'Ingrese al menos 1 habitación';
        };

        if(!$wc){
            $errores[] = 'Ingrese al menos 1 baño';
        };

        if(!$estacionamiento){
            $errores[] = 'Ingrese al menos 1 estacionamiento';
        };

        if(!$vendedores_id){
            $errores[] = 'Ingrese al menos 1 vendedor';
        };

        if(!$imagen['name'] || $imagen['error']){
            $errores[] = 'La imagen es obligatoria';
        };

        //Validar por tamaño (100Kb máximo)
        $medida = 1000*1000;

        if($imagen['size'] > $medida) {
            $errores[] = 'La imagen es muy pesada';
        }


        if(empty($errores)){

            /** SUBIDA DE ARCHIVOS **/

            //Crear Carpeta
            $carpetaImagenes = __DIR__.'../../../imagenes/'; 

            if(!is_dir($carpetaImagenes)) {
                mkdir($carpetaImagenes);
            }
            
            //Generar un nombre único
            $nombreImagen = md5( uniqid( rand(), true)).'.jpg';
            
            //Subir la imagenes    
            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes.$nombreImagen);
            //exit;


            //Insertar en la base de datos
            $query =  " INSERT INTO propiedades (titulo, precio, imagen, descripcion, habitaciones, wc, 
            estacionamiento, creado, vendedores_id) VALUES ('$titulo', $precio, '$nombreImagen', '$descripcion', $habitaciones,
            $wc, $estacionamiento, '$creado', $vendedores_id);";

            //echo $query;

            $resultado = mysqli_query($db, $query);

            if($resultado) {
                //Redireccionar al usuario para evitar datos duplicados

                header('Location: /admin?resultado=1'); //Se crea variable dentro para llamarla en index
            }
        } else {
            //echo "Registro no insertado";
        };

        
    };

    require __DIR__.'../../../includes/funciones.php';    
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
            <select name="vendedor">
                <option value="" <?php echo $vendedores_id===''?'selected':'';?> disabled>---Seleccione Vendedor---</option>
                <?php while ($vendedores = mysqli_fetch_assoc($resconsult)): ?>
                    <option value="<?php echo $vendedores['id'];?>" <?php echo $vendedores['id']===$vendedores_id?'selected':'';?>> <?php echo $vendedores['nombre']." ".$vendedores['apellido'];?> </option>
                <?php endwhile; ?>
            </select>
        </fieldset>

        <input type="submit" value="Crear Propiedad" class="boton boton-verde">
    </form>

    </main>

<?php
    incluirTemplate('footers');
?>