<?php
    require 'includes/app.php';    
    incluirTemplate('headers');
?>

    <main class="contenedor seccion contenido-centrado">
            <?php
                include 'includes/templates/anuncio.php';
            ?>
    </main>

<?php
    incluirTemplate('footers');
?>