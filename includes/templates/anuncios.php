<?php
    use App\propiedad;

    if($_SERVER['SCRIPT_NAME'] === '/anuncios.php') {
        $propiedades = propiedad::all();
    } else {
        $propiedades = propiedad::get(3);
    }


?>

<div class="contenedor-anuncios">
    <?php foreach($propiedades as $propiedad){ ?>
    <div class="anuncio">
        
        <picture>
            <!-- Se llama la imagen dinamicamente -->
            <img loading="lazy" src="/imagenes/<?php echo $propiedad->imagen; ?>" alt="anuncio">
        
        </picture>
        <div class="contenido-anuncio">
            <h3> <?php echo $propiedad->titulo; ?> </h3>
            
            <p class="parrafo-anuncio"> <?php echo $propiedad->descripcion; ?> </p>
            <p class="precio"> $ <?php echo number_format(intval(floatval($propiedad->precio))); ?> </p>
            
            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icon" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                    <p> <?php echo $propiedad->wc; ?> </p>
                </li>
                <li>
                    <img class="icon" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono 
                    estacionamiento">
                    <p> <?php echo $propiedad->estacionamiento; ?> </p>
                </li>
                <li>
                    <img class="icon" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono 
                    habitaciones">
                    <p> <?php echo $propiedad->habitaciones; ?> </p>
                </li>

            </ul>

            <a href="anuncio.php?id=<?php echo $propiedad->id; ?>" class="boton-amarillo-block">
                Ver Propiedad
            </a>
        </div>
    </div> <!-- anuncio -->
    <?php }; ?>
</div> <!-- contenedor-anuncio -->