<?php
    //Configuración de un usuario autenticado
    
    require __DIR__.'../../includes/app.php';
    
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    
    autenticar();

    use App\propiedad;
    use App\vendedor;

    // Implementar un método para obtener todas las propiedades
    $propiedades = propiedad::all();
    $vendedores = vendedor::all();

    //debugg($vendedores);

    $db = conectarDB();



    //Muestra mensaje condicional (en caso que no preceda del formulario "resultado==1" no se hace nada)
    //caso contrario muestra el mensaje
    $resultado = $_GET['resultado'] ?? null;
    

    //Configuración del botón para eliminar el registro
    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        //debugg($_POST);
        
        $id = $_POST['id']; //Es necesario pasar el "Request_Method para que $_POST funcione"
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if($id){

            $tipo = $_POST['tipo'];

            if(validarTipoContenido($tipo)) {

                //Compara lo que vamos a eliminar
                if($tipo === 'vendedor') {
                    $vendedor = vendedor::find($id);
                    $vendedor->eliminar();
                } else if($tipo === 'propiedad'){
                    $propiedad = propiedad::find($id);
                    $propiedad->eliminar();
                }

            } else {

            }
            
            
            
        };
    }

    //Incluir el template de encabezado
      
    incluirTemplate('headers');
?>

    <main class="contenedor seccion">
        <h1>Administrador de bienes raices</h1>

        <?php 
            $mensaje = notificacionEvento(intval($resultado));
            if($mensaje) { ?>
                <p class="alert exito"><?php echo s($mensaje) ?></p>
                <?php header("refresh:2;url=/admin");
                ?>
        <?php };?>

        <h5 class="ancho"></h5>
        <h2 class="admTitulo">Propiedades</h2>
        <h5 class="ancho"></h5>

        <a href="/admin/propiedades/crear.php" class="boton boton-amarillo">Nueva Propiedad</a>

        <table class="propiedades">
            <thead>
                <th>ID</th>
                <th>Titulos</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Acciones</th>

            </thead>
            
            <!-- Paso 4: Mostrar los resultados -->

            <tbody>
                <?php foreach( $propiedades as $propiedad): ?>
                
                    <tr>
                        <td> <?php echo $propiedad->id; ?> </td>
                        <td> <?php echo $propiedad->titulo; ?> </td>
                        <td> <img src="/imagenes/<?php echo $propiedad->imagen; ?>" class="imagen-tabla"> </td>
                        <td> $ <?php echo $propiedad->precio; ?> </td>
                        <td>
                            <form method="POST" class="w-100" onsubmit="return confirm('¿Estás seguro de eliminar la publicación: <?php echo $propiedad->titulo ?>?')">

                                <input type="hidden" name="id" value="<?php echo $propiedad->id ?>">
                                <input type="hidden" name="tipo" value="propiedad">
                                <input type="submit" class="boton-rojo-block" value="Eliminar">
                            </form>
                            
                            <a href="/admin/propiedades/actualizar.php?id=<?php echo $propiedad->id; ?>" class="boton-verde-block">Actualizar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>

        </table>
        <h5 class="ancho"></h5>
        <h2 class="admTitulo">Vendedores</h2>
        <h5 class="ancho"></h5>

        <a href="/admin/vendedores/crear.php" class="boton boton-amarillo">Nuevo Vendedor</a>

        <table class="propiedades">
            <thead>
                <th>ID</th>
                <th>Nombre</th>
                <th>Telefono</th>
                <th>Acciones</th>
            </thead>
            
            <!-- Paso 4: Mostrar los resultados -->

            <tbody>
                <?php foreach( $vendedores as $vendedor): ?>
                
                    <tr>
                        <td> <?php echo $vendedor->id; ?> </td>
                        <td> <?php echo $vendedor->nombre . ' ' . $vendedor->apellido; ?> </td>
                        <td> <?php echo $vendedor->telefono; ?> </td>
                        <td>
                            <form method="POST" class="w-100" onsubmit="return confirm('¿Estás seguro de eliminar el vendedor: <?php echo $vendedor->nombre . ' ' . $vendedor->apellido?>?')">

                                <input type="hidden" name="id" value="<?php echo $vendedor->id ?>">
                                <input type="hidden" name="tipo" value="vendedor">
                                <input type="submit" class="boton-rojo-block" value="Eliminar">
                            </form>
                            
                            <a href="/admin/vendedores/actualizar.php?id=<?php echo $vendedor->id; ?>" class="boton-verde-block">Actualizar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>

        </table>

    </main>

<?php

    //Paso 5: Cerrar la conexión
    //mysqli_close($db);

    incluirTemplate('footers');
?>