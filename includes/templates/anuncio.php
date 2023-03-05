<?php
    
    //Se elije la propiedad
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);


    // Importar la conexión
    require __DIR__.'/../config/database.php';
    $db = conectarDB();
    // consultar

    $query = "SELECT * FROM propiedades WHERE id=$id";

    // obtener resultados
    $resultado = mysqli_query($db, $query);
    
    //var_dump($propiedad);
    
    //Si no hay una propiedad con ese id redireccionar a la página principal
    if(!$id || !$resultado->num_rows) {
        header('Location: /');
    }


    if($propiedad = mysqli_fetch_assoc($resultado)):;

?>


<h1> <?php echo $propiedad['titulo']; ?> </h1>

<picture>
            <!-- Se llama la imagen dinamicamente -->
    <img loading="lazy" src="/imagenes/<?php echo $propiedad['imagen']; ?>" alt="anuncio">  -->
        
</picture>

<div class="resumen-propiedad">
    <p class="precio">$ <?php echo number_format(intval(floatval($propiedad['precio']))); ?> </p>
</div>

<ul class="iconos-caracteristicas">
    <li>
        <img class="icon" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
        <p> <?php echo $propiedad['wc']; ?> </p>
    </li>
    <li>
        <img class="icon" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono 
        estacionamiento">
        <p> <?php echo $propiedad['estacionamiento']; ?> </p>
    </li>
    <li>
        <img class="icon" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono 
        habitaciones">
        <p> <?php echo $propiedad['habitaciones']; ?> </p>
    </li>

</ul>

<p>
    <?php echo $propiedad['descripcion']; ?>
</p>
<p>
    <?php echo $propiedad['descripcion_amp']; ?>
</p>


<?php
    endif;

    // Cerrar conexión
    mysqli_close($db);
?>


