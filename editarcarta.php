<?php 
	require 'partials/header.php';
	require 'database.php';

	$carta = $_GET['id'];

	$records = $conn->prepare('SELECT idcarta, NombreSolicitante, cedula, fecha, razonPrestamo FROM cartasolicitud WHERE idcarta = :idcarta');
	$records->bindParam(':idcarta', $carta);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);

	$message = '';

	if(!count($results) > 0){
		$message = 'Hubo un problema en el codigo';
	}
?>
	
	<?php if(!empty($message)): ?>
	    <p> <?= $message ?></p>
	<?php endif; ?>

	<form class="contform" method="POST" action="procesocarta.php">
		<h2 class="h2">Editar Carta de Solicitud</h2>
		<div class="form-group">
			<label class="control-label">Nombre del Solicitante:</label>
			<input type="text" class="form-control" name="nombreSolicitante" placeholder="Escribe tu Nombre: " value="<?= $results['NombreSolicitante']?>">
		</div>
		<div class="form-group">
			<label class="control-label">Cedula:</label>
			<input type="number" class="form-control" name="cedula" placeholder="Escribe tu Cedula: " value="<?= $results['cedula']?>">
		</div>
		<div class="form-group">
			<label class="control-label">Fecha:</label>
			<input type="date" name="fecha" placeholder="Introduzca la fecha" value="<?= $results['fecha']?>">
		</div>
		<div class="form-group">
			<label class="control-label">Razon del Prestamo:</label>
			<textarea class="form-control" placeholder="razon:" name="razonPrestamo"><?= $results['razonPrestamo']?></textarea>
		</div>
		<input type="hidden" name="idcarta" value="<?= $results['idcarta']?>">
		<div class="form-group">
			<button type="submit" class="btn btn-primary">Modificar</button>
		</div>
	</form>

<?php require 'partials/footer.php' ?>