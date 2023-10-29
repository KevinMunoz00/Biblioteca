<?php require 'partials/header.php';
	require 'database.php';

	$message = '';

	if (!empty($_POST['nombreEditorial'])) {
		$sql = "INSERT INTO editorial(nombreEditorial) VALUES(:nombreEditorial)";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':nombreEditorial', $_POST['nombreEditorial']);

		if ($stmt->execute()) {
	      $message = 'Se ha creado una editorial exitosamente';
	    } else {
	      $message = 'Ha ocurrido un error al ingresar los datos';
	    }
	}

		$records = $conn->prepare('SELECT ideditorial, nombreEditorial FROM editorial');
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
					<th scope="col">Nombre</th>
					<th scope="col">Enlace</th>
					<th scope="col">Enlace</th>
				</tr>
			</thead>
			<tbody>
				<?php if ($records->rowcount() > 0): ?>
					<?php for ($i=0; $i < $results = $records->fetch(PDO::FETCH_ASSOC); $i++): ?>
						<tr>
							<th scope="col"><?= $results['ideditorial'] ?></th>
							<td><?= $results['nombreEditorial'] ?></td>
							<td>
								<a class="btn btn-primary" href="editareditorial.php?id=<?= $results['ideditorial'] ?>">Editar</a>
							</td>
							<td>
								<a class="btn btn-primary" href="eliminareditorial.php?id=<?= $results['ideditorial'] ?>">Eliminar</a>
							</td>
						</tr>
					<?php endfor; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>

	<form class="contform" method="POST" action="editorial.php">
		<h2 class="h2">Formulario Editoriales</h2>
		<div class="form-group">
			<label class="control-label">Nombre de la Editorial:</label>
			<input type="text" class="form-control" name="nombreEditorial" placeholder="Escribe el nombre de la Editorial: ">
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-primary">Agregar</button>
		</div>
	</form>

<?php require 'partials/footer.php' ?>