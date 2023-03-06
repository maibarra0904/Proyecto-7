<?php
    //Configuración de un usuario autenticado
    require __DIR__.'../../includes/funciones.php';  
    
    autenticar();

    //*-- Pasos para crear la conexión en base de datos--*
    //Paso 1: Importar la conexión
    require __DIR__.'../../includes/config/database.php';
    $db = conectarDB();

    //Paso 2: Escribir el Query
    $query = "SELECT * FROM propiedades";

    //Paso 3: Consultar la BD
    $resultadoBD = mysqli_query($db,$query); 


    //Muestra mensaje condicional (en caso que no preceda del formulario "resultado==1" no se hace nada)
    //caso contrario muestra el mensaje
    $resultado = $_GET['resultado'] ?? null;
    

    //Configuración del botón para eliminar el registro
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id']; //Es necesario pasar el "Request_Method para que $_POST funcione"
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if($id){
            //Eliminar la imagen
            $query = "SELECT imagen FROM propiedades WHERE id = $id";
            //echo $query;
            $resultado = mysqli_query($db, $query);
            $propiedad = mysqli_fetch_assoc($resultado);

            // var_dump($propiedad['imagen']);
            // exit;
            unlink('../imagenes/'.$propiedad['imagen']);

            //Eliminar el registro
            $query = "DELETE FROM propiedades WHERE id = $id";
            $resultado = mysqli_query($db, $query);
            if($resultado) {
                header('Location: /admin?resultado=3');
            }
        };
    }

    //Incluir el template de encabezado
      
    incluirTemplate('headers');
?>

    <main class="contenedor seccion">
        <h1>Administrador de bienes raices</h1>

        <?php if($resultado==1):?>
            <p class="alert exito">Anuncio creado correctamente</p>
        <?php elseif($resultado==2):?>
            <p class="alert exito">Anuncio actualizado correctamente</p>
        <?php elseif($resultado==3):?>
            <p class="alert exito">Anuncio eliminado correctamente</p>
        <?php endif; ?>

        <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>

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
                <?php while($propiedad = mysqli_fetch_assoc($resultadoBD)): ?>
                
                    <tr>
                        <td> <?php echo $propiedad['id']; ?> </td>
                        <td> <?php echo $propiedad['titulo']; ?> </td>
                        <td> <img src="/imagenes/<?php echo $propiedad['imagen']; ?>" class="imagen-tabla"> </td>
                        <td> $ <?php echo $propiedad['precio']; ?> </td>
                        <td>
                            <form method="POST" class="w-100">

                                <input type="hidden" name="id" value="<?php echo $propiedad['id'] ?>">
                                <input type="submit" class="boton-rojo-block" value="Eliminar">
                            </form>
                            
                            <a href="/admin/propiedades/actualizar.php?id=<?php echo $propiedad['id']; ?>" class="boton-verde-block">Actualizar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>

            </tbody>

        </table>

    </main>

<?php

    //Paso 5: Cerrar la conexión
    mysqli_close($db);

    incluirTemplate('footers');
?>