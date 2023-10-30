<?php session_start(); 
	require 'database.php'; 
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Crud Proyecto Biblioteca</title>
	 <!-- BootStrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" 
        rel="stylesheet" 
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" 
        crossorigin="anonymous">
    <!-- CSS -->
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
	<div class="nave">
		<h2 class="tituloh2"><a class="nav-link" href="/ProyectoBiblioteca">Proyecto Biblioteca</a></h2>

	</div>
	<div class="principall">
		<?php if (!isset($_SESSION['user_id'])) : ?>
			<ul>
				<li>
					<a href="carta.php">Carta</a>
				</li>
			</ul>
		<?php else: ?>
			<?php 
				$records = $conn->prepare('SELECT idusuario, correo, nombreUsuario, contrasena, rango FROM usuario WHERE idusuario = :idusuario');
				$records->bindParam(':idusuario', $_SESSION['user_id']);
				$records->execute();
				$results = $records->fetch(PDO::FETCH_ASSOC);
				$user = null;

				if (count($results) > 0) {
					$user = $results;
				}
			?>
			<?php if(!empty($user)): ?>
				<?php switch ($user['rango']): case -99: break; ?>
					<?php case 1: ?> 
						<ul>
							<li>
								<a href="solicitud.php">Solicitud</a>
							</li>
							<li>
								<a href="entrega.php">Entrega</a>
							</li>
						</ul>
					<?php break; ?>
					<?php case 2: ?> 
						<ul>
							<li>
								<a href="solicitud.php">Solicitud</a>
							</li>
							<li>
								<a href="entrega.php">Entrega</a>
							</li>
						</ul>
					<?php break; ?>
					<?php case 3: ?>
						<ul>
							<li>
								<a href="dewey.php">Dewey</a>
							</li>
							<li>
								<a href="clasificacion.php">Clasificación</a>
							</li>
							<li>
								<a href="entrega.php">Entrega</a>
							</li>
							<li>
								<a href="multa.php">Multa</a>
							</li>
							<li>
								<a href="libro.php">Libro</a>
							</li>
							<li>
								<a href="solicitudvisitante.php">SolicitudVisitante</a>
							</li>
							<li>
								<a href="metricas.php">Metricas</a>
							</li>
						</ul> 
					<?php break; ?>
					<?php case 4: ?>
						 <ul>
							<li>
								<a href="dewey.php">Dewey</a>
							</li>
							<li>
								<a href="clasificacion.php">Clasificación</a>
							</li>
							<li>
								<a href="solicitud.php">Solicitud</a>
							</li>
							<li>
								<a href="entrega.php">Entrega</a>
							</li>
							<li>
								<a href="multa.php">Multa</a>
							</li>
							<li>
								<a href="libro.php">Libro</a>
							</li>
							<li>
								<a href="solicitudvisitante.php">SolicitudVisitante</a>
							</li>
							<li>
								<a href="autor.php">Autor</a>
							</li>
							<li>
								<a href="editorial.php">Editorial</a>
							</li>
							<li>
								<a href="metricas.php">Metricas</a>
							</li>
						</ul>
					<?php break; ?>
					<?php case 5: ?>
						<ul>
							<li>
								<a href="carta.php">Carta</a>
							</li>
							<li>
								<a href="dewey.php">Dewey</a>
							</li>
							<li>
								<a href="clasificacion.php">Clasificación</a>
							</li>
							<li>
								<a href="solicitud.php">Solicitud</a>
							</li>
							<li>
								<a href="entrega.php">Entrega</a>
							</li>
							<li>
								<a href="multa.php">Multa</a>
							</li>
							<li>
								<a href="libro.php">Libro</a>
							</li>
							<li>
								<a href="solicitudvisitante.php">SolicitudVisitante</a>
							</li>
							<li>
								<a href="autor.php">Autor</a>
							</li>
							<li>
								<a href="editorial.php">Editorial</a>
							</li>
							<li>
								<a href="metricas.php">Metricas</a>
							</li>
						</ul> 
					<?php break; ?>
					<?php default: ?>
						<h2>rango desconocido</h2>
					<?php break; ?>
				<?php endswitch; ?>
			<?php endif; ?>
		<?php endif; ?>
	</div>


	<!--
				<ul>
					<li>
						<a href="carta.php">Carta</a>
					</li>
					<li>
						<a href="dewey.php">Dewey</a>
					</li>
					<li>
						<a href="clasificacion.php">Clasificación</a>
					</li>
					<li>
						<a href="solicitud.php">Solicitud</a>
					</li>
					<li>
						<a href="entrega.php">Entrega</a>
					</li>
					<li>
						<a href="multa.php">Multa</a>
					</li>
					<li>
						<a href="libro.php">Libro</a>
					</li>
					<li>
						<a href="solicitudvisitante.php">SolicitudVisitante</a>
					</li>
					<li>
						<a href="autor.php">Autor</a>
					</li>
					<li>
						<a href="editorial.php">Editorial</a>
					</li>
				</ul>
	 -->