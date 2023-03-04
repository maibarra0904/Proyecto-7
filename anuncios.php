<?php
    require 'includes/funciones.php';    
    incluirTemplate('headers');
?>

    <main class="contenedor seccion">
            <h2>Casas y Departamentos en Venta</h2>

            <?php
                $limite = 9;
                include 'includes/templates/anuncios.php';
            ?>
            
    </main>


<?php
    incluirTemplate('footers');
?>