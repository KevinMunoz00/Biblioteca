<?php require 'partials/header.php';
	require 'database.php';

	$message = '';

	if (!empty($_POST['nombreDewey'])) {
		$sql = "INSERT INTO cdd(nombreDewey) VALUES(:nombreDewey)";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':nombreDewey', $_POST['nombreDewey']);

		if ($stmt->execute()) {
	      $message = 'Se ha creado una nueva Clasificación';
	    } else {
	      $message = 'Ha ocurrido un error al ingresar los datos';
	    }
	}

		$records = $conn->prepare('SELECT idcdd, nombreDewey FROM cdd');
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
					<th scope="col">Categoria</th>
					<th scope="col">Enlace</th>
					<th scope="col">Enlace</th>
				</tr>
			</thead>
			<tbody>
				<?php if ($records->rowcount() > 0): ?>
					<?php for ($i=0; $i < $results = $records->fetch(PDO::FETCH_ASSOC); $i++): ?>
						<tr>
							<th scope="col"><?= $results['idcdd'] ?></th>
							<td><?= $results['nombreDewey'] ?></td>
							<td>
								<a class="btn btn-primary" href="editardewey.php?id=<?= $results['idcdd'] ?>">Editar</a>
							</td>
							<td>
								<a class="btn btn-primary" href="eliminardewey.php?id=<?= $results['idcdd'] ?>">Eliminar</a>
							</td>
						</tr>
					<?php endfor; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>

	<form class="contform" method="POST" action="dewey.php">
		<h2 class="h2">Formulario del Sistema Dewey de Clasificación</h2>
		<div class="form-group">
			<label class="control-label">Nombre de la Categoria:</label>
			<input type="text" class="form-control" name="nombreDewey" placeholder="Escribe la Categoria: ">
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-primary">Agregar</button>
		</div>
	</form>

<?php require 'partials/footer.php' ?>