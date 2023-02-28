<?php
    require __DIR__.'../../../includes/config/database.php';   
    $db = conectarDB();

    echo "<pre>";
    var_dump($_SERVER);
    echo "</pre>";

    echo "<pre>";
    var_dump($_POST);
    echo "</pre>";

    require __DIR__.'../../../includes/funciones.php';    
    incluirTemplate('headers');
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Crear</h1>
        <a href="/admin" class="boton boton-verde">Crear</a>
    

    <form action="" class="formulario" method="POST" action="/admin/propiedades/crear.php">
        <fieldset>
            <legend>Información General</legend>

            <label for="titulo">Titulo:</label>
            <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad">

            <label for="previo">Precio:</label>
            <input type="number" id="precio" name="precio" placeholder="Precio Propiedad">

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" accept="image/jpeg, image/png">

            <label for="descripcion">Descripcion:</label>
            <textarea id="descripcion"></textarea>
        </fieldset>

        <fieldset>
            <legend>Información Propiedad</legend>

            <label for="habitaciones">Habitaciones:</label>
            <input type="number" name="habitaciones" placeholder="Ej: 3" min="1" max="9">

            <label for="habitaciones">Baños:</label>
            <input type="number" name="baños" placeholder="Ej: 2" min="1" max="9">

            <label for="estacionamiento">Estacionamiento:</label>
            <input type="number" name="estacionamiento" placeholder="Ej: 1" min="1" max="9">
        </fieldset>

        <fieldset>
            <legend>Vendedor</legend>
            <select>
                <option value="0" selected disabled>---Seleccione Vendedor---</option>
                <option value="1">Mario</option>
                <option value="2">Evelyn</option>
            </select>
        </fieldset>

        <input type="submit" value="Crear Propiedad" class="boton boton-verde">
    </form>

    </main>

<?php
    incluirTemplate('footers');
?>