<?php

    //Conexión a BD
    require 'includes/config/database.php';
    $db = conectarDB();

    //Autenticar el usuario

    $errores = [];
    

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $email = mysqli_real_escape_string( $db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) );
        $password = mysqli_real_escape_string($db, $_POST['password']);
    
        if(!$email) {
            $errores[] = 'El email es obligatorio o no es válido';
        }
        
        if(!$password) {
            $errores[] = 'El password es inválido o no existe';
        }

        if(empty($errores)){
            //Revisar si el usuario existe.

            $query = "SELECT * FROM usuarios WHERE email = '$email'";

            //Leemos la conexión

            $resultado = mysqli_query($db, $query);

            //var_dump($query);

            //Verificar si el usuario existe
            if( $resultado-> num_rows) {
                //Se llama la consulta anterior
                $usuario = mysqli_fetch_assoc($resultado);

                //Compara la contraseña de la consulta con la ingresada por el usuario en el formulario
                $auth = password_verify($password, $usuario['password']);

                if(!$auth) {
                    $errores[] = 'El password es incorrecto';
                }

                var_dump($auth);

            } else {
                $errores[] = 'El usuario no existe';
            }
        }
    
    }

    //var_dump($_POST);
    //Incluir el header
    require 'includes/funciones.php';    
    incluirTemplate('headers');
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Iniciar Sesión</h1>

        <?php foreach($errores as $error) : ?>
            <div class="alert error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>

        <form method="POST" class="formulario">
        <fieldset>

            <legend>Email y Password</legend>
                
                <label for="email">E-mail</label>
                <input type="email" name="email" placeholder="Tu e-mail" id="email" value="<?php echo $email; ?>">

                <label for="password">Password</label>
                <input type="password" name="password" placeholder="Tu password" id="password">

            </fieldset>

            <input type="submit" value="Iniciar Sesión" class="boton boton-verde">

        </form>

    </main>

    
<?php
    incluirTemplate('footers');
?>