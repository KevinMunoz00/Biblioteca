<?php 
	require 'partials/header.php';
	require 'database.php';

	$carta = $_GET['id'];

	$records = $conn->prepare('SELECT idsolicitudvisitante, usuarioId, libroId, cartaId, fechaPrestamo, tiempoPrestamo FROM solicitudvisitante WHERE idsolicitudvisitante = :idsolicitudvisitante');
	$records->bindParam(':idsolicitudvisitante', $carta);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);

	$message = '';

	if(!count($results) > 0){
		$message = 'Hubo un problema en el codigo';
	}

	#consultar usuarios
	$recordsusu = $conn->prepare('SELECT idusuario, nombreUsuario, rango FROM usuario');

	#consultar libros
	$recordslib = $conn->prepare('SELECT idlibro, nombreLibro FROM libro');

	#consultar cartas
	$recordscar = $conn->prepare('SELECT idcarta, nombreSolicitante FROM cartasolicitud');

	$recordsusu->execute();
	$recordslib->execute();
	$recordscar->execute();
?>
	
	<?php if(!empty($message)): ?>
	    <p> <?= $message ?></p>
	<?php endif; ?>

	<form class="contform" method="POST" action="procesosolicitudvisitante.php">
		<h2 class="h2">Editar Verificación:</h2>
		
		<div class="form-group">
			<label class="control-label">Verificador:</label>
			<select class="form-select" name="usuarioId">
				<?php if ($recordsusu->rowcount() > 0): ?>
				<?php for ($i=0; $i < $resultsusu = $recordsusu->fetch(PDO::FETCH_ASSOC); $i++): ?>
					<?php if($resultsusu['rango'] >= 3): ?>
						<option value="<?= $resultsusu['idusuario'] ?>"><?= $resultsusu['nombreUsuario'] ?></option>
					<?php endif; ?>
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
			<label class="control-label">Solicitante:</label>
			<select class="form-select" name="cartaId">
				<?php if ($recordscar->rowcount() > 0): ?>
				<?php for ($i=0; $i < $resultscar = $recordscar->fetch(PDO::FETCH_ASSOC); $i++): ?>
					<option value="<?= $resultscar['idcarta'] ?>"><?= $resultscar['nombreSolicitante'] ?></option>
				<?php endfor; ?>
				<?php endif; ?>
			</select>
		</div>
		<div class="form-group">
			<label class="control-label">Fecha de Verificación:</label>
			<input type="date" class="form-control" name="fechaPrestamo" placeholder="FECHA: " value="<?= $results['fechaPrestamo'] ?>">
		</div>
		<div class="form-group">
			<label class="control-label">Tiempo de Prestamo:</label>
			<input type="number" class="form-control" name="tiempoPrestamo" placeholder="En Horas: " value="<?= $results['tiempoPrestamo'] ?>">
		</div>
		<input type="hidden" name="idsolicitudvisitante" value="<?= $results['idsolicitudvisitante']?>">
		<div class="form-group">
			<button type="submit" class="btn btn-primary">Modificar</button>
		</div>
	</form>

<?php require 'partials/footer.php' ?>