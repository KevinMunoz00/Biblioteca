<?php

  require 'database.php';

  $message = '';

  if ((!empty($_POST['correo'])) && (!empty($_POST['contrasena'])) && (!empty($_POST['nombreu'])) && (!empty($_POST['apellidou'])) && (!empty($_POST['rango'])) && (!empty($_POST['celular']))) {

    $sql = "INSERT INTO usuario(nombreUsuario, apellidoUsuario, correo, contrasena, rango, celular) VALUES(:nombreu, :apellidou, :correo, :contrasena, :rango, :celular)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nombreu', $_POST['nombreu']);
    $stmt->bindParam(':apellidou', $_POST['apellidou']);
    $stmt->bindParam(':correo', $_POST['correo']);
    $stmt->bindParam(':rango', $_POST['rango']);
    $stmt->bindParam(':celular', $_POST['celular']);
    $password = password_hash($_POST['contrasena'], PASSWORD_BCRYPT);
    $stmt->bindParam(':contrasena', $password);


    if ($stmt->execute()) {
      $message = 'Se ha creado un usuario exitosamente';
    } else {
      $message = 'Ha ocurrido un error creando la contraseña';
    }
  }
?>

<?php require 'partials/header.php' ?>

  <?php if(!empty($message)): ?>
    <p> <?= $message ?></p>
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