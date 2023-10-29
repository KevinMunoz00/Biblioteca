<?php require 'partials/header.php';
	require 'database.php';

	$message = '';

	if (!empty($_POST['usuarioId']) && !empty($_POST['libroId']) && !empty($_POST['fechaPrestamo']) && !empty($_POST['tiempoPrestamo'])) {

		$sql = "INSERT INTO solicitud(usuarioId, libroId, fechaPrestamo, tiempoPrestamo) VALUES(:usuarioId, :libroId, :fechaPrestamo, :tiempoPrestamo)";

		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':usuarioId', $_POST['usuarioId']);
		$stmt->bindParam(':libroId', $_POST['libroId']);
		$stmt->bindParam(':fechaPrestamo', $_POST['fechaPrestamo']);
		$stmt->bindParam(':tiempoPrestamo', $_POST['tiempoPrestamo']);

		if ($stmt->execute()) {
	      $message = 'Se ha realizado una solicitud exitosamente';
	    } else {
	      $message = 'Ha ocurrido un error al ingresar los datos';
	    }
	}
		#consultar solicitud
		$records = $conn->prepare('SELECT idsolicitud, usuarioId, libroId, fechaPrestamo, tiempoPrestamo FROM solicitud');
		$records->execute();

		#consultar usuarios
		$recordsusu = $conn->prepare('SELECT idusuario, nombreUsuario FROM usuario');
		$recordsusu2 = $conn->prepare('SELECT idusuario, nombreUsuario FROM usuario');

		#consultar libros
		$recordslib = $conn->prepare('SELECT idlibro, nombreLibro FROM libro');
		$recordslib2 = $conn->prepare('SELECT idlibro, nombreLibro FROM libro');

		$recordsusu->execute();
		$recordslib->execute();
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
					<th scope="col">FechaPrestamo</th>
					<th scope="col">TiempoPrestamo(Semanas)</th>
					<th scope="col">Enlace</th>
					<th scope="col">Enlace</th>
				</tr>
			</thead>
			<tbody>
				<?php if ($records->rowcount() > 0): ?>
					<?php for ($i=0; $i < $results = $records->fetch(PDO::FETCH_ASSOC); $i++): ?>
						<tr>
							<th scope="col"><?= $results['idsolicitud'] ?></th>
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
							<td><?= $results['fechaPrestamo'] ?></td>
							<td><?= $results['tiempoPrestamo'] ?></td>
							<td>
								<a class="btn btn-primary" href="editarsolicitud.php?id=<?= $results['idsolicitud'] ?>">Editar</a>
							</td>
							<td>
								<a class="btn btn-primary" href="eliminarsolicitud.php?id=<?= $results['idsolicitud'] ?>">Eliminar</a>
							</td>
						</tr>
					<?php endfor; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>

	<form class="contform" method="POST" action="solicitud.php">
		<h2 class="h2">Formulario de Solicitudes</h2>
		
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
			<input type="date" class="form-control" name="fechaPrestamo" placeholder="FECHA: ">
		</div>
		<div class="form-group">
			<label class="control-label">tiempo del prestamo:</label>
			<input type="number" class="form-control" name="tiempoPrestamo" placeholder="en Semanas: ">
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-primary">Agregar</button>
		</div>
	</form>

<?php require 'partials/footer.php' ?>