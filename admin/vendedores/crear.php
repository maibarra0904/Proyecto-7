<?php
    //Usuario autenticado
    require __DIR__.'../../../includes/app.php';
    use App\vendedor;

    autenticar();

    $vendedor = new vendedor;

    $errores = vendedor::getErrores();

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        //Crear la nueva instancia
        $vendedor = new vendedor($_POST['vendedor']);

        //Validar que no haya campos vacíos
        $errores = $vendedor->validar();


        //Programar en caso que no haya errores
        if(empty($errores)) {
            $vendedor->guardar();
        }
    }

    incluirTemplate('headers');
?>
    <main class="contenedor seccion contenido-centrado">
        <h1>Registrar Vendedor(a)</h1>
        <a href="/admin" class="boton boton-verde">Regresar</a>
        <?php foreach ($errores as $error): ?>
            <div class="alert error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>


    <form action="" class="formulario" method="POST" action="/admin/vendedores/crear.php" enctype="multipart/form-data">
        <!-- enctype junto con el metodo $_FILES permiten mostrar las propiedades del archivo que se sube -->
        
        <?php include '../../includes/templates/formulario_vendedores.php' ?>
        
        <input type="hidden" name="vendedor[creado]" value="<?php echo date('Y-m-d'); ?>">
        <input type="hidden" name="vendedor[actualizado]" value="<?php echo date('Y-m-d'); ?>">
        <input type="submit" value="Registrar Vendedor" class="boton boton-verde">
    </form>

    </main>

<?php
    incluirTemplate('footers');
?>