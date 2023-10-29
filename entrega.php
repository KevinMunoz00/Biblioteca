<?php require 'partials/header.php';
	require 'database.php';

	$message = '';

	if (!empty($_POST['usuarioId']) && !empty($_POST['libroId']) && !empty($_POST['multaId']) && !empty($_POST['fechaEntrega'])) {

		$sql = "INSERT INTO entrega(usuarioId, libroId, multaId, fechaEntrega) VALUES(:usuarioId, :libroId, :multaId, :fechaEntrega)";

		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':usuarioId', $_POST['usuarioId']);
		$stmt->bindParam(':libroId', $_POST['libroId']);
		$stmt->bindParam(':multaId', $_POST['multaId']);
		$stmt->bindParam(':fechaEntrega', $_POST['fechaEntrega']);

		if ($stmt->execute()) {
	      $message = 'Se ha realizado una entrega exitosamente';
	    } else {
	      $message = 'Ha ocurrido un error al ingresar los datos';
	    }
	}
		#consultar entrega
		$records = $conn->prepare('SELECT identrega, usuarioId, libroId, multaId, fechaEntrega FROM entrega');
		$records->execute();

		#consultar usuarios
		$recordsusu = $conn->prepare('SELECT idusuario, nombreUsuario FROM usuario');
		$recordsusu2 = $conn->prepare('SELECT idusuario, nombreUsuario FROM usuario');

		#consultar libros
		$recordslib = $conn->prepare('SELECT idlibro, nombreLibro FROM libro');
		$recordslib2 = $conn->prepare('SELECT idlibro, nombreLibro FROM libro');

		#consultar Multa
		$recordsmul = $conn->prepare('SELECT idmulta, tipoMulta FROM multa');
		$recordsmul2 = $conn->prepare('SELECT idmulta, tipoMulta FROM multa');

		$recordsusu->execute();
		$recordslib->execute();
		$recordsmul->execute();
?>
	<?php if(!empty($message)): ?>
	    <p> <?= $message ?></p>
	<?php endif; ?>

	<div class="table-responsive">
		<table class="table table-hover">
			<thead>
				<tr>
					<th scope="col">No.</th>
					<th scope="col">Usuario</th>
					<th scope="col">Libro</th>
					<th scope="col">Multa</th>
					<th scope="col">FechaEntrega</th>
					<th scope="col">Enlace</th>
					<th scope="col">Enlace</th>
				</tr>
			</thead>
			<tbody>
				<?php if ($records->rowcount() > 0): ?>
					<?php for ($i=0; $i < $results = $records->fetch(PDO::FETCH_ASSOC); $i++): ?>
						<tr>
							<th scope="col"><?= $results['identrega'] ?></th>
							<td>
								<?php $recordsusu2->execute(); ?>

								<?php for ($i=0; $i < $resultsusu2 = $recordsusu2->fetch(PDO::FETCH_ASSOC); $i++) : ?> 
									<?php if ($resultsusu2['idusuario'] == $results['usuarioId']): ?>
										<?= $resultsusu2['nombreUsuario'] ?> 
									<?php endif; ?>
								<?php endfor; ?>
							</td>
							<td>
								<?php $recordslib2->execute(); ?>

								<?php for ($i=0; $i < $resultslib2 = $recordslib2->fetch(PDO::FETCH_ASSOC); $i++) : ?> 
									<?php if ($resultslib2['idlibro'] == $results['libroId']): ?>
										<?= $resultslib2['nombreLibro'] ?> 
									<?php endif; ?>
								<?php endfor; ?>
							</td>
							<td>
								<?php $recordsmul2->execute(); ?>

								<?php for ($i=0; $i < $resultsmul2 = $recordsmul2->fetch(PDO::FETCH_ASSOC); $i++) : ?> 
									<?php if ($resultsmul2['idmulta'] == $results['multaId']): ?>
										<?= $resultsmul2['tipoMulta'] ?>
									<?php endif; ?>
								<?php endfor; ?>
							</td>
							<td><?= $results['fechaEntrega'] ?></td>
							<td>
								<a class="btn btn-primary" href="editarentrega.php?id=<?= $results['identrega'] ?>">Editar</a>
							</td>
							<td>
								<a class="btn btn-primary" href="eliminarentrega.php?id=<?= $results['identrega'] ?>">Eliminar</a>
							</td>
						</tr>
					<?php endfor; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>

	<form class="contform" method="POST" action="entrega.php">
		<h2 class="h2">Formulario de Entregas</h2>
		
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
			<input type="date" class="form-control" name="fechaEntrega" placeholder="FECHA: ">
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-primary">Agregar</button>
		</div>
	</form>

<?php require 'partials/footer.php' ?>