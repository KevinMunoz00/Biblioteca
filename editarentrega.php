<?php 
	require 'partials/header.php';
	require 'database.php';

	$carta = $_GET['id'];

	$records = $conn->prepare('SELECT identrega, usuarioId, libroId, multaId, fechaEntrega FROM entrega WHERE identrega = :identrega');
	$records->bindParam(':identrega', $carta);
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

	#consultar Multa
	$recordsmul = $conn->prepare('SELECT idmulta, tipoMulta FROM multa');

	$recordsusu->execute();
	$recordslib->execute();
	$recordsmul->execute();
?>
	
	<?php if(!empty($message)): ?>
	    <p> <?= $message ?></p>
	<?php endif; ?>

	<form class="contform" method="POST" action="procesoentrega.php">
		<h2 class="h2">Editar Entrega</h2>
		
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
			<label class="control-label">Multas:</label>
			<select class="form-select" name="multaId">
				<?php if ($recordsmul->rowcount() > 0): ?>
				<?php for ($i=0; $i < $resultsmul = $recordsmul->fetch(PDO::FETCH_ASSOC); $i++): ?>
					<option value="<?= $resultsmul['idmulta'] ?>"><?= $resultsmul['tipoMulta'] ?></option>
				<?php endfor; ?>
				<?php endif; ?>
			</select>
		</div>
		<div class="form-group">
			<label class="control-label">Fecha de Entrega:</label>
			<input type="date" class="form-control" name="fechaEntrega" placeholder="FECHA: " value="<?= $results['fechaEntrega'] ?>">
		</div>
		<input type="hidden" name="identrega" value="<?= $results['identrega']?>">
		<div class="form-group">
			<button type="submit" class="btn btn-primary">Modificar</button>
		</div>
	</form>

<?php require 'partials/footer.php' ?>