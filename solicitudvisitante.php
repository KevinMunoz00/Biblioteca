<?php require 'partials/header.php';
	require 'database.php';

	$message = '';

	if (!empty($_POST['usuarioId']) && !empty($_POST['libroId']) && !empty($_POST['cartaId']) && !empty($_POST['fechaPrestamo']) && !empty($_POST['tiempoPrestamo'])) {

		$sql = "INSERT INTO solicitudvisitante(cartaId, libroId, usuarioId, fechaPrestamo, tiempoPrestamo) VALUES(:cartaId, :libroId, :usuarioId, :fechaPrestamo, :tiempoPrestamo)";

		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':cartaId', $_POST['cartaId']);
		$stmt->bindParam(':libroId', $_POST['libroId']);
		$stmt->bindParam(':usuarioId', $_POST['usuarioId']);
		$stmt->bindParam(':fechaPrestamo', $_POST['fechaPrestamo']);
		$stmt->bindParam(':tiempoPrestamo', $_POST['tiempoPrestamo']);

		if ($stmt->execute()) {
	      $message = 'Se ha aprobado la solicitud del visitante exitosamente';
	    } else {
	      $message = 'Ha ocurrido un error al ingresar los datos';
	    }
	}
		#consultar solicitudvisitante
		$records = $conn->prepare('SELECT idsolicitudvisitante, cartaId, libroId, usuarioId, fechaPrestamo, tiempoPrestamo FROM solicitudvisitante');
		$records->execute();

		#consultar usuarios
		$recordsusu = $conn->prepare('SELECT idusuario, nombreUsuario, rango FROM usuario');
		$recordsusu2 = $conn->prepare('SELECT idusuario, nombreUsuario, rango FROM usuario');

		#consultar libros
		$recordslib = $conn->prepare('SELECT idlibro, nombreLibro FROM libro');
		$recordslib2 = $conn->prepare('SELECT idlibro, nombreLibro FROM libro');

		#consultar carta
		$recordscar = $conn->prepare('SELECT idcarta, nombreSolicitante FROM cartasolicitud');
		$recordscar2 = $conn->prepare('SELECT idcarta, nombreSolicitante FROM cartasolicitud');

		$recordsusu->execute();
		$recordslib->execute();
		$recordscar->execute();
?>
	<?php if(!empty($message)): ?>
	    <p> <?= $message ?></p>
	<?php endif; ?>

	<div class="table-responsive">
		<table class="table table-hover">
			<thead>
				<tr>
					<th scope="col">No.</th>
					<th scope="col">UsuarioVerificacion</th>
					<th scope="col">Libro</th>
					<th scope="col">Solicitante</th>
					<th scope="col">FechaPrestamo</th>
					<th scope="col">tiempoPrestamo(Horas)</th>
					<th scope="col">Enlace</th>
					<th scope="col">Enlace</th>
				</tr>
			</thead>
			<tbody>
				<?php if ($records->rowcount() > 0): ?>
					<?php for ($i=0; $i < $results = $records->fetch(PDO::FETCH_ASSOC); $i++): ?>
						<tr>
							<th scope="col"><?= $results['idsolicitudvisitante'] ?></th>
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
								<?php $recordscar2->execute(); ?>

								<?php for ($i=0; $i < $resultscar2 = $recordscar2->fetch(PDO::FETCH_ASSOC); $i++) : ?> 
									<?php if ($resultscar2['idcarta'] == $results['cartaId']): ?>
										<?= $resultscar2['nombreSolicitante'] ?>
									<?php endif; ?>
								<?php endfor; ?>
							</td>
							<td><?= $results['fechaPrestamo'] ?></td>
							<td><?= $results['tiempoPrestamo'] ?></td>
							<td>
								<a class="btn btn-primary" href="editarsolicitudvisitante.php?id=<?= $results['idsolicitudvisitante'] ?>">Editar</a>
							</td>
							<td>
								<a class="btn btn-primary" href="eliminarsolicitudvisitante.php?id=<?= $results['idsolicitudvisitante'] ?>">Eliminar</a>
							</td>
						</tr>
					<?php endfor; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>

	<form class="contform" method="POST" action="solicitudvisitante.php">
		<h2 class="h2">Formulario de Verficación de Cartas para Prestamos a Visitantes.</h2>
		
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
			<label class="control-label">Libro:</label>
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
			<input type="date" class="form-control" name="fechaPrestamo" placeholder="FECHA: ">
		</div>
		<div class="form-group">
			<label class="control-label">Tiempo de Prestamo:</label>
			<input type="number" class="form-control" name="tiempoPrestamo" placeholder="En Horas: ">
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-primary">Agregar</button>
		</div>
	</form>

<?php require 'partials/footer.php' ?>