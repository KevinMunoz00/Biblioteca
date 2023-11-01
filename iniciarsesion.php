<?php require 'partials/header.php' ?>

<?php

	// Verificar si el usuario ya ha iniciado sesión; si es así, redirigirlo a la página principal.
	if (isset($_SESSION['user_id'])) {
		header('Location: /Biblioteca-main');
	}

	require 'database.php'; 

	// Comprobar si se han enviado datos de correo y contraseña a través del formulario.
	if (!empty($_POST['correo']) && !empty($_POST['contrasena'])) {
		// Preparar una consulta SQL para seleccionar un usuario con el correo proporcionado.
		$records = $conn->prepare('SELECT idusuario, nombreUsuario, correo, contrasena FROM usuario WHERE correo = :correo');

		$records->bindParam(':correo', $_POST['correo']);
		$records->execute();

		// Obtener el resultado de la consulta como un arreglo asociativo.
		$results = $records ->fetch(PDO::FETCH_ASSOC);

		$message = '';
		
		// Comprobar si se encontró un usuario y si la contraseña proporcionada coincide con la almacenada.
		if (count($results) >  0 && password_verify($_POST['contrasena'], $results['contrasena'])){
			$_SESSION['user_id'] = $results['idusuario'];
			header('Location: /Biblioteca-main');
		} else {
			$message = 'Las credenciales no Coinciden.';
		}

	}
?>
	<h1>Iniciar Sesion</h1>
	<span>o <a href="registrar.php">Registrate</a></span>

	<?php if (!empty($message)) : ?>
		<p><?= $message ?></p>
	<?php endif;	?>

	<form class="contform" action="iniciarsesion.php" method="POST">
		<input type="text" name="correo" placeholder="Ingrese su correo:">
		<input type="password" name="contrasena" placeholder="Ingresa tu Contraseña">
		<input type="submit" value="enviar">
	</form>

<?php require 'partials/footer.php' ?>