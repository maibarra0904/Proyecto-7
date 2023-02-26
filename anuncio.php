<?php
    $inicio = false;
    include 'includes/templates/headers.php';
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Casa en Venta frente al bosque</h1>

        <picture>
            <source srcset="build/img/destacada.webp" type="image/wepb">
            <source srcset="build/img/destacada.jpg" type="image/jpeg">
            <img loading="lazy" src="build/img/destacada.jpg" alt="imagen de la propiedad">
        </picture>

        <div class="resumen-propiedad">
            <p class="precio">$350.000</p>
        </div>

        <ul class="iconos-caracteristicas">
            <li>
                <img class="icon" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                <p>3</p>
            </li>
            <li>
                <img class="icon" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono 
                estacionamiento">
                <p>3</p>
            </li>
            <li>
                <img class="icon" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono 
                habitaciones">
                <p>4</p>
            </li>

        </ul>

        <p>
            Mauris turpis nunc, blandit et, volutpat molestie, porta ut, ligula. 
            Pellentesque commodo eros a enim. Aenean imperdiet. Etiam ultricies nisi vel augue. 
            Vestibulum facilisis, purus nec pulvinar iaculis, ligula mi congue nunc, vitae euismod ligula urna in dolor. 
            Praesent adipiscing. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. 
            Curabitur ligula sapien, tincidunt non, euismod vitae, posuere imperdiet, leo. 
            Etiam imperdiet imperdiet orci. Sed magna purus, fermentum eu, tincidunt eu, varius ut, felis.
        </p>

        <p>
            Duis lobortis massa imperdiet quam. Phasellus viverra nulla ut metus varius laoreet. 
            Donec posuere vulputate arcu. Nam commodo suscipit quam. 
            Duis vel nibh at velit scelerisque suscipit.
        </p>

    </main>

    <footer class="footer seccion">
        <div class="contenedor contenedor-footer">
            <nav class="navegacion">
                <a href="nosotros.html">Nosotros</a>
                <a href="anuncios.html">Anuncios</a>
                <a href="blog.html">Blog</a>
                <a href="contacto.html">Contacto</a>
            </nav>
        </div>
        <p class="copyright">Todos los derechos Reservados 2023 &copy;</p>
    </footer>

    <script src="build/js/bundle.min.js"></script>
</body>
</html>