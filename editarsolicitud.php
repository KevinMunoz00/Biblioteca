<?php 
	require 'partials/header.php';
	require 'database.php';

	$carta = $_GET['id'];

	$records = $conn->prepare('SELECT idsolicitud, usuarioId, libroId, fechaPrestamo, tiempoPrestamo FROM solicitud WHERE idsolicitud = :idsolicitud');
	$records->bindParam(':idsolicitud', $carta);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);

	$message = '';

	if(!count($results) > 0){
		$message = 'Hubo un problema en el codigo';
	}

	#consultar usuarios
	$recordsusu = $conn->prepare('SELECT idusuario, nombreUsuario FROM usuario');

	#consultar libros
	$recordslib = $conn->prepare('SELECT idlibro, nombreLibro FROM libro');

	$recordsusu->execute();
	$recordslib->execute();
?>
	
	<?php if(!empty($message)): ?>
	    <p> <?= $message ?></p>
	<?php endif; ?>

	<form class="contform" method="POST" action="procesosolicitud.php">
		<h2 class="h2">Editar Solicitud</h2>
		
		<div class="form-group">
			<label class="control-label">Usuarios:</label>
			<select class="form-select" name="usuarioId">
				<?php if ($recordsusu->rowcount() > 0): ?>
				<?php for ($i=0; $i < $resultsusu = $recordsusu->fetch(PDO::FETCH_ASSOC); $i++): ?>
					<option value="<?= $resultsusu['idusuario'] ?>"><?= $resultsusu['nombreUsuario'] ?></option>
				<?php endfor; ?>
				<?php endif; ?>
			</select>
		</div>
		<div class="form-group">
			<label class="control-label">Libros:</label>
			<select class="form-select" name="libroId">
				<?php if ($recordslib->rowcount() > 0): ?>
				<?php for ($i=0; $i < $resultslib = $recordslib->fetch(PDO::FETCH_ASSOC); $i++): ?>
					<option value="<?= $resultslib['idlibro'] ?>"><?= $resultslib['nombreLibro'] ?></option>
				<?php endfor; ?>
				<?php endif; ?>
			</select>
		</div>
		<div class="form-group">
			<label class="control-label">Fecha de Solicitud:</label>
			<input type="date" class="form-control" name="fechaPrestamo" placeholder="FECHA: " value="<?= $results['fechaPrestamo'] ?>">
		</div>
		<div class="form-group">
			<label class="control-label">Tiempo de prestamo:</label>
			<input type="number" class="form-control" name="tiempoPrestamo" placeholder="FECHA: " value="<?= $results['tiempoPrestamo'] ?>">
		</div>
		<input type="hidden" name="idsolicitud" value="<?= $results['idsolicitud']?>">
		<div class="form-group">
			<button type="submit" class="btn btn-primary">Modificar</button>
		</div>
	</form>

<?php require 'partials/footer.php' ?>