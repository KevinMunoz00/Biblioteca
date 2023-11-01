<?php require 'partials/header.php' ?>

<?php
	require 'database.php';

	// Verificar si el usuario ha iniciado sesión.
	if (isset($_SESSION['user_id'])) {

		// Si el usuario ha iniciado sesión, obtener los datos del usuario desde la base de datos.
		$records = $conn->prepare('SELECT idusuario, correo, nombreUsuario, contrasena FROM usuario WHERE idusuario = :idusuario');

		$records->bindParam(':idusuario', $_SESSION['user_id']);
		$records->execute();
		$results = $records->fetch(PDO::FETCH_ASSOC);
		$user = null;

		if (count($results) > 0) {
			$user = $results;
			// Almacenar los datos del usuario en la variable $user si se encuentra en la base de datos.
		}
	}

	

?>
	<?php if(!empty($user)): ?>
		<!-- Mostrar contenido si el usuario ha iniciado sesión -->
	<div class="mx-auto col-md-6 text-center" style="border: 2px solid black">
		<h1>Bienvenido <?= $user['nombreUsuario'] ?></h1>
		<h5>Has Iniciado Sesion.</h5>
		<a href="cerrarsesion.php">Salir</a>
	</div>

	<?php else: ?>
		<!-- Mostrar contenido si el usuario no ha iniciado sesión -->
	<div class="mx-auto col-md-6 text-center" style="border: 2px solid black">
		<h1>Registrate o Inicia Sesion</h1>
		<a href="iniciarsesion.php">Iniciar Sesion</a> o
		<a href="registrar.php">Registrarse</a>
	</div>
	<?php endif; ?>
	<br>

<?php require 'partials/footer.php' ?>