<?php

  require 'database.php';

  $message = '';

  // Verificar si se han enviado datos del formulario y si están completos.
  if ((!empty($_POST['correo'])) && (!empty($_POST['contrasena'])) && (!empty($_POST['nombreu'])) && (!empty($_POST['apellidou'])) && (!empty($_POST['rango'])) && (!empty($_POST['celular']))) {

    // Preparar la consulta SQL para insertar un nuevo usuario en la base de datos.
    $sql = "INSERT INTO usuario(nombreUsuario, apellidoUsuario, correo, contrasena, rango, celular) VALUES(:nombreu, :apellidou, :correo, :contrasena, :rango, :celular)";
    $stmt = $conn->prepare($sql);
    
    // Vincular los valores del formulario a los parámetros de la consulta.
    $stmt->bindParam(':nombreu', $_POST['nombreu']);
    $stmt->bindParam(':apellidou', $_POST['apellidou']);
    $stmt->bindParam(':correo', $_POST['correo']);
    $stmt->bindParam(':rango', $_POST['rango']);
    $stmt->bindParam(':celular', $_POST['celular']);
    // Hash de la contraseña antes de almacenarla en la base de datos.
    $password = password_hash($_POST['contrasena'], PASSWORD_BCRYPT);
    $stmt->bindParam(':contrasena', $password);

// Ejecutar la consulta y verificar si se creó el usuario con éxito.
    if ($stmt->execute()) {
      $message = 'Se ha creado un usuario exitosamente'; 
    } else {
      $message = 'Ha ocurrido un error creando la contraseña';
    }
  }
?>

<?php require 'partials/header.php' ?>

  <?php if(!empty($message)): ?>
    <p> <?= $message ?></p> <!-- Mostrar un mensaje de éxito o error según el resultado del registro. -->
  <?php endif; ?>

  <h1>Registrarse</h1>
  <span>o <a href="iniciarsesion.php">Iniciar Sesion</a></span>

  <form class="contform" action="registrar.php" method="POST">
    <h2 class="h2">Formulario Registro:</h2>
    <input type="text" name="correo" placeholder="Ingrese su correo:">
    <input type="password" name="contrasena" placeholder="Ingresa tu Contraseña">
    <input type="password" name="confirmar_contrasena" placeholder="Confirma la Contraseña">
    <input type="text" name="nombreu" placeholder="Escribe tu Nombre">
    <input type="text" name="apellidou" placeholder="Escribe tu Apellido">
    <input type="number" name="rango" placeholder=":Rango:">
    <input type="number" name="celular" placeholder="Digita tu Numero celular:">
    <input type="submit" value="enviar">
  </form>

<?php require 'partials/footer.php' ?>