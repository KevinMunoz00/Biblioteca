<?php require 'partials/header.php';
	require 'database.php';

	$message = '';

	if (!empty($_POST['NombreAutor'])) {
		$sql = "INSERT INTO autor(nombreAutor) VALUES(:nombreAutor)";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':nombreAutor', $_POST['NombreAutor']);

		if ($stmt->execute()) {
	      $message = 'Se ha creado un autor exitosamente';
	    } else {
	      $message = 'Ha ocurrido un error al ingresar los datos';
	    }
	}

		$records = $conn->prepare('SELECT idautor, nombreAutor FROM autor');
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
							<th scope="col"><?= $results['idautor'] ?></th>
							<td><?= $results['nombreAutor'] ?></td>
							<td>
								<a class="btn btn-primary" href="editarautor.php?id=<?= $results['idautor'] ?>">Editar</a>
							</td>
							<td>
								<a class="btn btn-primary" href="eliminarautor.php?id=<?= $results['idautor'] ?>">Eliminar</a>
							</td>
						</tr>
					<?php endfor; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>

	<form class="contform" method="POST" action="autor.php">
		<h2 class="h2">Formulario Autores</h2>
		<div class="form-group">
			<label class="control-label">Nombre del Autor:</label>
			<input type="text" class="form-control" name="NombreAutor" placeholder="Escribe el Nombre: ">
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-primary">Agregar</button>
		</div>
	</form>

<?php require 'partials/footer.php' ?>