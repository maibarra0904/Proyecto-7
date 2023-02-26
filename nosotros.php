<?php
    $inicio = false;
    include 'includes/templates/headers.php';
?>

    <main class="contenedor seccion">
        <h1>Conoce sobre Nosotros</h1>
        <div class="contenido-nosotros">
            
            <div class="imagen">
                <picture>
                    <source srcset="build/img/nosotros.webp" type="image/webp">
                    <source srcset="build/img/nosotros.jpg" type="image/jpeg">
                    <img loading="lazy" src="build/img/nosotros.webp" alt="Sobre Nosotros">
                </picture>
            </div>

            <div class="texto-nosotros">
                <blockquote>
                    25 Años de Experiencia
                </blockquote>

                <p>
                    Fusce vulputate eleifend sapien. Aliquam lobortis. Etiam sit amet orci eget eros faucibus tincidunt. 
                    Etiam vitae tortor. Sed libero.
                </p>

                <p>
                    Curabitur at lacus ac velit ornare lobortis. Praesent nec nisl a purus blandit viverra. 
                    Suspendisse nisl elit, rhoncus eget, elementum ac, condimentum eget, diam. Cras non dolor. 
                    Fusce convallis metus id felis luctus adipiscing.
                </p>

                
            </div>

        </div>
    </main>

    <section class="contenedor seccion">
        <h1>Más Sobre Nosotros</h1>
        <div class="iconos-nosotros">
            <div class="icono">
                <img src="build/img/icono1.svg" alt="Icono seguridad" loading="lazy">
                <h3>Seguridad</h3>
                <p>Vivamus aliquet elit ac nisl. In turpis. Pellentesque libero tortor, tincidunt et, 
                    tincidunt eget, semper nec, quam. Lorem ipsum dolor sit amet, consectetuer 
                    adipiscing elit.</p>
            </div>
            <div class="icono">
                <img src="build/img/icono2.svg" alt="Icono seguridad" loading="lazy">
                <h3>Precio</h3>
                <p>Vivamus aliquet elit ac nisl. In turpis. Pellentesque libero tortor, tincidunt et, 
                    tincidunt eget, semper nec, quam. Lorem ipsum dolor sit amet, consectetuer 
                    adipiscing elit.</p>
            </div>
            <div class="icono">
                <img src="build/img/icono3.svg" alt="Icono seguridad" loading="lazy">
                <h3>Tiempo</h3>
                <p>Vivamus aliquet elit ac nisl. In turpis. Pellentesque libero tortor, tincidunt et, 
                    tincidunt eget, semper nec, quam. Lorem ipsum dolor sit amet, consectetuer 
                    adipiscing elit.</p>
            </div>
        </div>
    </section>

    
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