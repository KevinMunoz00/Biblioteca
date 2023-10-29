<?php require 'partials/header.php' ?>

<?php

	if (isset($_SESSION['user_id'])) {
		header('Location: /proyectoBiblioteca');
	}

	require 'database.php'; 

	if (!empty($_POST['correo']) && !empty($_POST['contrasena'])) {
		$records = $conn->prepare('SELECT idusuario, nombreUsuario, correo, contrasena FROM usuario WHERE correo = :correo');

		$records->bindParam(':correo', $_POST['correo']);
		$records->execute();
		$results = $records ->fetch(PDO::FETCH_ASSOC);

		$message = '';

		if (count($results) >  0 && password_verify($_POST['contrasena'], $results['contrasena'])){
			$_SESSION['user_id'] = $results['idusuario'];
			header('Location: /proyectoBiblioteca');
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