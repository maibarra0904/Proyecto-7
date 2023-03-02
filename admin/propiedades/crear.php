<?php
    //Base de datos
    require __DIR__.'../../../includes/config/database.php';   
    $db = conectarDB();

    $titulo = "";
    $precio = "";
    $descripcion = "";
    $habitaciones = "";
    $wc = "";
    $estacionamiento = "";
    $vendedores_id = "";


    //Arreglo con mensajes de errores
    $errores = [];

    //Ejecución de código después que usuario envía todos los datos del formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $titulo = $_POST['titulo'];
        $precio = $_POST['precio'];
        $descripcion = $_POST['descripcion'];
        $habitaciones = $_POST['habitaciones'];
        $wc = $_POST['wc'];
        $estacionamiento = $_POST['estacionamiento'];
        $vendedores_id = $_POST['vendedor'];
        
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

        if(empty($errores)){
            //Insertar en la base de datos
            $query =  " INSERT INTO propiedades (titulo, precio, descripcion, habitaciones, wc, 
            estacionamiento, vendedores_id) VALUES ('$titulo', $precio, '$descripcion', $habitaciones,
            $wc, $estacionamiento, $vendedores_id);";

            //echo $query;

            $resultado = mysqli_query($db, $query);

            if($resultado) {
                //echo "Insertado Correctamente";
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
        <a href="/admin" class="boton boton-verde">Crear</a>
        <?php foreach ($errores as $error): ?>
            <div class="alert error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>


    <form action="" class="formulario" method="POST" action="/admin/propiedades/crear.php">
        <fieldset>
            <legend>Información General</legend>

            <label for="titulo">Titulo:</label>
            <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad" value="<?php echo $titulo; ?>">

            <label for="previo">Precio:</label>
            <input type="number" id="precio" name="precio" placeholder="Precio Propiedad" value="<?php echo $precio; ?>">

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" accept="image/jpeg, image/png">

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
            <select name="vendedor" value="<?php echo $vendedores_id; ?>">
                <option value="0" selected disabled>---Seleccione Vendedor---</option>
                <option value="1">Mario</option>
                <option value="2">Evelyn</option>
            </select>
        </fieldset>

        <input type="submit" value="Crear Propiedad" class="boton boton-verde">
    </form>

    </main>

<?php
    incluirTemplate('footers');
?>