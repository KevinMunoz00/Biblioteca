<?php require 'partials/header.php';
	require 'database.php';

	$message = '';

	if (!empty($_POST['NombreSolicitante']) && !empty($_POST['cedula']) && !empty($_POST['fecha']) && !empty($_POST['razonPrestamo'])) {
		$sql = "INSERT INTO cartasolicitud(NombreSolicitante, cedula, fecha, razonPrestamo) VALUES(:NombreSolicitante, :cedula, :fecha, :razonPrestamo)";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':NombreSolicitante', $_POST['NombreSolicitante']);
		$stmt->bindParam(':cedula', $_POST['cedula']);
		$stmt->bindParam(':fecha', $_POST['fecha']);
		$stmt->bindParam(':razonPrestamo', $_POST['razonPrestamo']);

		if ($stmt->execute()) {
	      $message = 'Se ha creado una carta exitosamente';
	    } else {
	      $message = 'Ha ocurrido un error al ingresar los datos';
	    }
	}

		$records = $conn->prepare('SELECT idcarta, NombreSolicitante, cedula, fecha, razonPrestamo FROM cartasolicitud');
		$records->execute();


?>
	<?php if(!empty($message)): ?>
	    <p> <?= $message ?></p>
	<?php endif; ?>

	<div class="table-responsive">
		<table class="table table-hover">
			<thead>
				<tr>
					<th scope="col">No.</th>
					<th scope="col">NombreSolicitante</th>
					<th scope="col">Cedula</th>
					<th scope="col">fecha</th>
					<th scope="col">Razon</th>
					<th scope="col">Enlace</th>
					<th scope="col">Enlace</th>
				</tr>
			</thead>
			<tbody>
				<?php if ($records->rowcount() > 0): ?>
					<?php for ($i=0; $i < $results = $records->fetch(PDO::FETCH_ASSOC); $i++): ?>
						<tr>
							<th scope="col"><?= $results['idcarta'] ?></th>
							<td><?= $results['NombreSolicitante'] ?></td>
							<td><?= $results['cedula'] ?></td>
							<td><?= $results['fecha'] ?></td>
							<td><?= $results['razonPrestamo'] ?></td>
							<td>
								<a class="btn btn-primary" href="editarcarta.php?id=<?= $results['idcarta'] ?>">Editar</a>
							</td>
							<td>
								<a class="btn btn-primary" href="eliminarcarta.php?id=<?= $results['idcarta'] ?>">Eliminar</a>
							</td>
						</tr>
					<?php endfor; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>

	<form class="contform" method="POST" action="carta.php">
		<h2 class="h2">Formulario Carta de Solicitud</h2>
		<div class="form-group">
			<label class="control-label">Nombre del Solicitante:</label>
			<input type="text" class="form-control" name="NombreSolicitante" placeholder="Escribe tu Nombre: ">
		</div>
		<div class="form-group">
			<label class="control-label">Cedula:</label>
			<input type="number" class="form-control" name="cedula" placeholder="Escribe tu Cedula: ">
		</div>
		<div class="form-group">
			<label class="control-label">Fecha:</label>
			<input type="date" name="fecha" placeholder="Introduzca la fecha">
		</div>
		<div class="form-group">
			<label class="control-label">Razon del Prestamo:</label>
			<textarea class="form-control" placeholder="razon:" name="razonPrestamo"></textarea>
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-primary">Agregar</button>
		</div>
	</form>

<?php require 'partials/footer.php' ?>