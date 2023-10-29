<?php 
	require 'partials/header.php';
	require 'database.php';

	$carta = $_GET['id'];

	$records = $conn->prepare('SELECT idlibro, nombreLibro, clasificacionId, deweyId, editorialId, autorId, cantidadlibros FROM libro WHERE idlibro = :idlibro');
	$records->bindParam(':idlibro', $carta);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);

	$message = '';

	if(!count($results) > 0){
		$message = 'Hubo un problema en el codigo';
	}

	#consultar clasificacion
	$recordsclasi = $conn->prepare('SELECT idclasificacion, tipoClasificacion FROM clasificacion');
	
	#consultar dewey
	$recordsdew = $conn->prepare('SELECT idcdd, nombreDewey FROM cdd');
	
	#consultar editorial
	$recordsedit = $conn->prepare('SELECT ideditorial, nombreEditorial FROM editorial');
	
	#consultar autor
	$recordsaut = $conn->prepare('SELECT idautor, nombreAutor FROM autor');

	$recordsclasi->execute();
	$recordsdew->execute();
	$recordsedit->execute();
	$recordsaut->execute();
?>
	
	<?php if(!empty($message)): ?>
	    <p> <?= $message ?></p>
	<?php endif; ?>

	<form class="contform" method="POST" action="procesolibro.php">
		<h2 class="h2">Editar Libro</h2>
		<div class="form-group">
			<label class="control-label">Nombre del libro:</label>
			<input type="text" class="form-control" name="nombreLibro" placeholder="Escribe el nombre del libro: " value="<?= $results['nombreLibro'] ?>">
		</div>
		<div class="form-group">
			<label class="control-label">Clasificación:</label>
			<select class="form-select" name="clasificacionId">
				<?php if ($recordsclasi->rowcount() > 0): ?>
				<?php for ($i=0; $i < $resultsclasi = $recordsclasi->fetch(PDO::FETCH_ASSOC); $i++): ?>
					<option value="<?= $resultsclasi['idclasificacion'] ?>"><?= $resultsclasi['tipoClasificacion'] ?></option>
				<?php endfor; ?>
				<?php endif; ?>
			</select>
		</div>
		<div class="form-group">
			<label class="control-label">Dewey:</label>
			<select class="form-select" name="deweyId">
				<?php if ($recordsdew->rowcount() > 0): ?>
				<?php for ($i=0; $i < $resultsdew = $recordsdew->fetch(PDO::FETCH_ASSOC); $i++): ?>
					<option value="<?= $resultsdew['idcdd'] ?>"><?= $resultsdew['nombreDewey'] ?></option>
				<?php endfor; ?>
				<?php endif; ?>
			</select>
		</div>
		<div class="form-group">
			<label class="control-label">Editorial:</label>
			<select class="form-select" name="editorialId">
				<?php if ($recordsedit->rowcount() > 0): ?>
				<?php for ($i=0; $i < $resultsedit = $recordsedit->fetch(PDO::FETCH_ASSOC); $i++): ?>
					<option value="<?= $resultsedit['ideditorial'] ?>"><?= $resultsedit['nombreEditorial'] ?></option>
				<?php endfor; ?>
				<?php endif; ?>
			</select>
		</div>
		<div class="form-group">
			<label class="control-label">Autor:</label>
			<select class="form-select" name="autorId">
				<?php if ($recordsaut->rowcount() > 0): ?>
				<?php for ($i=0; $i < $resultsaut = $recordsaut->fetch(PDO::FETCH_ASSOC); $i++): ?>
					<option value="<?= $resultsaut['idautor'] ?>"><?= $resultsaut['nombreAutor'] ?></option>
				<?php endfor; ?>
				<?php endif; ?>
			</select>
		</div>
		<div class="form-group">
			<label class="control-label">Cantidad de Libros:</label>
			<textarea class="form-control" placeholder="Cantidad:" name="cantidadlibros"><?= $results['cantidadlibros'] ?></textarea>
		</div>
		<input type="hidden" name="idlibro" value="<?= $results['idlibro']?>">
		<div class="form-group">
			<button type="submit" class="btn btn-primary">Modificar</button>
		</div>
	</form>

<?php require 'partials/footer.php' ?>