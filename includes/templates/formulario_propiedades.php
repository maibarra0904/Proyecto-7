
<fieldset>
    <legend>Información General</legend>

    <label for="titulo">Titulo:</label>
    <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad" value="<?php echo s($propiedad->titulo); ?>">

    <label for="previo">Precio:</label>
    <input type="number" id="precio" name="precio" placeholder="Precio Propiedad" value="<?php echo s($propiedad->precio); ?>">

    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

    <label for="descripcion" >Descripcion:</label>
    <textarea id="descripcion" name="descripcion"><?php echo s($propiedad->descripcion); ?></textarea>
</fieldset>

<fieldset>
    <legend>Información Propiedad</legend>

    <label for="habitaciones">Habitaciones:</label>
    <input type="number" name="habitaciones" placeholder="Ej: 3" min="1" max="9" value="<?php echo s($propiedad->habitaciones); ?>">

    <label for="wc">Baños:</label>
    <input type="number" name="wc" placeholder="Ej: 2" min="1" max="9" value="<?php echo s($propiedad->wc); ?>">

    <label for="estacionamiento">Estacionamiento:</label>
    <input type="number" name="estacionamiento" placeholder="Ej: 1" min="1" max="9" value="<?php echo s($propiedad->estacionamiento); ?>">
</fieldset>

<!-- <fieldset>
    <legend>Vendedor</legend>
    <select name="vendedores_id">
        <option value="" <?php echo $vendedores_id===''?'selected':'';?> disabled>---Seleccione Vendedor---</option>
        <?php while ($vendedores = mysqli_fetch_assoc($resconsult)): ?>
            <option value="<?php echo $vendedores['id'];?>" <?php echo $vendedores['id']===$vendedores_id?'selected':'';?>> <?php echo $vendedores['nombre']." ".$vendedores['apellido'];?> </option>
        <?php endwhile; ?>
    </select>
</fieldset> -->
<input type="hidden" name="creado" value="<?php echo date('Y-m-d'); ?>">