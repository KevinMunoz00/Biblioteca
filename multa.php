<?php require 'partials/header.php';
	require 'database.php';

	$message = '';

	if (!empty($_POST['tipoMulta']) && !empty($_POST['valorMulta'])) {
		$sql = "INSERT INTO multa(tipoMulta, valorMulta) VALUES(:tipoMulta, :valorMulta)";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':tipoMulta', $_POST['tipoMulta']);
		$stmt->bindParam(':valorMulta', $_POST['valorMulta']);

		if ($stmt->execute()) {
	      $message = 'Se ha creado una multa exitosamente';
	    } else {
	      $message = 'Ha ocurrido un error al ingresar los datos';
	    }
	}

		$records = $conn->prepare('SELECT idmulta, tipoMulta, valorMulta FROM multa');
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
					<th scope="col">Multa</th>
					<th scope="col">Valor</th>
					<th scope="col">Enlace</th>
					<th scope="col">Enlace</th>
				</tr>
			</thead>
			<tbody>
				<?php if ($records->rowcount() > 0): ?>
					<?php for ($i=0; $i < $results = $records->fetch(PDO::FETCH_ASSOC); $i++): ?>
						<tr>
							<th scope="col"><?= $results['idmulta'] ?></th>
							<td><?= $results['tipoMulta'] ?></td>
							<td><?= $results['valorMulta'] ?></td>
							<td>
								<a class="btn btn-primary" href="editarmulta.php?id=<?= $results['idmulta'] ?>">Editar</a>
							</td>
							<td>
								<a class="btn btn-primary" href="eliminarmulta.php?id=<?= $results['idmulta'] ?>">Eliminar</a>
							</td>
						</tr>
					<?php endfor; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>

	<form class="contform" method="POST" action="multa.php">
		<h2 class="h2">Formulario de Multas</h2>
		<div class="form-group">
			<label class="control-label">Tipo de Multa:</label>
			<input type="text" class="form-control" name="tipoMulta" placeholder="Escribe la multa: ">
		</div>
		<div class="form-group">
			<label class="control-label">valor de la Multa:</label>
			<input type="number" class="form-control" name="valorMulta" placeholder="Escribe el Valor: ">
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-primary">Agregar</button>
		</div>
	</form>

<?php require 'partials/footer.php' ?>