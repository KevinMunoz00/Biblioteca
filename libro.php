<?php require 'partials/header.php';
	require 'database.php';

	$message = '';

	if (!empty($_POST['nombreLibro']) && !empty($_POST['clasificacionId']) && !empty($_POST['deweyId']) && !empty($_POST['editorialId']) && !empty($_POST['autorId']) && !empty($_POST['cantidadlibros'])) {

		$sql = "INSERT INTO libro(nombreLibro, clasificacionId, deweyId, editorialId, autorId, cantidadlibros) VALUES(:nombreLibro, :clasificacionId, :deweyId, :editorialId, :autorId, :cantidadlibros)";

		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':nombreLibro', $_POST['nombreLibro']);
		$stmt->bindParam(':clasificacionId', $_POST['clasificacionId']);
		$stmt->bindParam(':deweyId', $_POST['deweyId']);
		$stmt->bindParam(':editorialId', $_POST['editorialId']);
		$stmt->bindParam(':autorId', $_POST['autorId']);
		$stmt->bindParam(':cantidadlibros', $_POST['cantidadlibros']);

		if ($stmt->execute()) {
	      $message = 'Se ha creado un libro exitosamente';
	    } else {
	      $message = 'Ha ocurrido un error al ingresar los datos';
	    }
	}
		#consultar libro
		$records = $conn->prepare('SELECT idlibro, clasificacionId, deweyId, editorialId, autorId, nombreLibro, cantidadlibros FROM libro');
		$records->execute();

		#consultar clasificacion
		$recordsclasi = $conn->prepare('SELECT idclasificacion, tipoClasificacion FROM clasificacion');
		$recordsclasi2 = $conn->prepare('SELECT idclasificacion, tipoClasificacion FROM clasificacion');

		#consultar dewey
		$recordsdew = $conn->prepare('SELECT idcdd, nombreDewey FROM cdd');
		$recordsdew2 = $conn->prepare('SELECT idcdd, nombreDewey FROM cdd');

		#consultar editorial
		$recordsedit = $conn->prepare('SELECT ideditorial, nombreEditorial FROM editorial');
		$recordsedit2 = $conn->prepare('SELECT ideditorial, nombreEditorial FROM editorial');

		#consultar autor
		$recordsaut = $conn->prepare('SELECT idautor, nombreAutor FROM autor');
		$recordsaut2 = $conn->prepare('SELECT idautor, nombreAutor FROM autor');

		$recordsclasi->execute();
		$recordsdew->execute();
		$recordsedit->execute();
		$recordsaut->execute();
?>
	<?php if(!empty($message)): ?>
	    <p> <?= $message ?></p>
	<?php endif; ?>

	<div class="table-responsive">
		<table class="table table-hover">
			<thead>
				<tr>
					<th scope="col">No.</th>
					<th scope="col">nombre</th>
					<th scope="col">autor</th>
					<th scope="col">editorial</th>
					<th scope="col">Clasificación</th>
					<th scope="col">Dewey</th>
					<th scope="col">cantidad</th>
					<th scope="col">Enlace</th>
					<th scope="col">Enlace</th>
				</tr>
			</thead>
			<tbody>
				<?php if ($records->rowcount() > 0): ?>
					<?php for ($i=0; $i < $results = $records->fetch(PDO::FETCH_ASSOC); $i++): ?>
						<tr>
							<th scope="col"><?= $results['idlibro'] ?></th>
							<td><?= $results['nombreLibro'] ?></td>
							<td>
								<?php $recordsaut2->execute(); ?>

								<?php for ($i=0; $i < $resultsaut2 = $recordsaut2->fetch(PDO::FETCH_ASSOC); $i++) : ?> 
									<?php if ($resultsaut2['idautor'] == $results['autorId']): ?>
										<?= $resultsaut2['nombreAutor'] ?> 
									<?php endif; ?>
								<?php endfor; ?>
							</td>
							<td>
								<?php $recordsedit2->execute(); ?>

								<?php for ($i=0; $i < $resultsedit2 = $recordsedit2->fetch(PDO::FETCH_ASSOC); $i++) : ?> 
									<?php if ($resultsedit2['ideditorial'] == $results['editorialId']): ?>
										<?= $resultsedit2['nombreEditorial'] ?> 
									<?php endif; ?>
								<?php endfor; ?>
							</td>
							<td>
								<?php $recordsclasi2->execute(); ?>

								<?php for ($i=0; $i < $resultsclasi2 = $recordsclasi2->fetch(PDO::FETCH_ASSOC); $i++) : ?> 
									<?php if ($resultsclasi2['idclasificacion'] == $results['clasificacionId']): ?>
										<?= $resultsclasi2['tipoClasificacion'] ?> 
									<?php endif; ?>
								<?php endfor; ?>
							</td>
							<td>
								<?php $recordsdew2->execute(); ?>

								<?php for ($i=0; $i < $resultsdew2 = $recordsdew2->fetch(PDO::FETCH_ASSOC); $i++) : ?> 
									<?php if ($resultsdew2['idcdd'] == $results['deweyId']): ?>
										<?= $resultsdew2['nombreDewey'] ?> 
									<?php endif; ?>
								<?php endfor; ?>
							</td>
							<td><?= $results['cantidadlibros'] ?></td>
							<td>
								<a class="btn btn-primary" href="editarlibro.php?id=<?= $results['idlibro'] ?>">Editar</a>
							</td>
							<td>
								<a class="btn btn-primary" href="eliminarlibro.php?id=<?= $results['idlibro'] ?>">Eliminar</a>
							</td>
						</tr>
					<?php endfor; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>

	<form class="contform" method="POST" action="libro.php">
		<h2 class="h2">Formulario de Libros</h2>
		<div class="form-group">
			<label class="control-label">Nombre del libro:</label>
			<input type="text" class="form-control" name="nombreLibro" placeholder="Escribe el nombre del libro: ">
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
			<textarea class="form-control" placeholder="Cantidad:" name="cantidadlibros"></textarea>
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-primary">Agregar</button>
		</div>
	</form>

<?php require 'partials/footer.php' ?>