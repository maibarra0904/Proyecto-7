<?php
    //Usuario autenticado
    require __DIR__.'../../../includes/app.php';
    use App\vendedor;

    autenticar();

    //Validar que sea un id válido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id) {
        header('Location: /admin');
    }

    //Obtener el arreglo del vendedor
    $vendedor = vendedor::find($id);

    //Arreglo con mensaje de errores
    $errores = vendedor::getErrores();

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        //Asignar los valores
        $args = $_POST['vendedor'];

        //Sincronizar el objeto en memoria con lo que el usuario escribió
        $vendedor->sincronizar($args);

        //Validación
        $errores = $vendedor->validar();

        if(empty($errores)) {
            $vendedor->guardar();
        }

    }

    incluirTemplate('headers');
?>
    <main class="contenedor seccion contenido-centrado">
        <h1>Actualizar Vendedor(a)</h1>
        <a href="/admin" class="boton boton-verde">Regresar</a>
        <?php foreach ($errores as $error): ?>
            <div class="alert error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>


    <form action="" class="formulario" method="POST" action="/admin/vendedores/crear.php" enctype="multipart/form-data">
        <!-- enctype junto con el metodo $_FILES permiten mostrar las propiedades del archivo que se sube -->
        
        <?php include '../../includes/templates/formulario_vendedores.php' ?>
        
        <input type="hidden" name="propiedad[creado]" value="<?php echo date('Y-m-d'); ?>">
        <input type="hidden" name="propiedad[actualizado]" value="<?php echo date('Y-m-d'); ?>">
        <input type="submit" value="Registrar Vendedor" class="boton boton-verde">
    </form>

    </main>

<?php
    incluirTemplate('footers');
?>