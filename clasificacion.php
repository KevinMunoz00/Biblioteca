<?php require 'partials/header.php';
	require 'database.php';

	$message = '';

	if (!empty($_POST['tipoClasificacion']) && !empty($_POST['usuarioId']) && !empty($_POST['descripcion'])) {

		$sql = "INSERT INTO Clasificacion(tipoClasificacion, usuarioId, descripcion) VALUES(:tipoClasificacion, :usuarioId, :descripcion)";

		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':tipoClasificacion', $_POST['tipoClasificacion']);
		$stmt->bindParam(':usuarioId', $_POST['usuarioId']);
		$stmt->bindParam(':descripcion', $_POST['descripcion']);

		if ($stmt->execute()) {
	      $message = 'Se ha creado una Clasificación exitosamente';
	    } else {
	      $message = 'Ha ocurrido un error al ingresar los datos';
	    }
	}

		$records = $conn->prepare('SELECT idclasificacion, usuarioId, tipoClasificacion, descripcion FROM Clasificacion');
		$records->execute();

		$records2 = $conn->prepare('SELECT idusuario, nombreUsuario, rango FROM usuario');

		$records2->execute();

		$records3 = $conn->prepare('SELECT idusuario, nombreUsuario, rango FROM usuario');
		
?>
	<?php if(!empty($message)): ?>
	    <p> <?= $message ?></p>
	<?php endif; ?>

	<div class="table-responsive">
		<table class="table table-hover">
			<thead>
				<tr>
					<th scope="col">No.</th>
					<th scope="col">usuario</th>
					<th scope="col">Clasificación</th>
					<th scope="col">descripción</th>
					<th scope="col">Enlace</th>
					<th scope="col">Enlace</th>
				</tr>
			</thead>
			<tbody>
				<?php if ($records->rowcount() > 0): ?>
					<?php for ($i=0; $i < $results = $records->fetch(PDO::FETCH_ASSOC); $i++): ?>
						<tr>
							<th scope="col"><?= $results['idclasificacion'] ?></th>
							<td>
								<?php $records3->execute(); ?>

								<?php for ($i=0; $i < $results3 = $records3->fetch(PDO::FETCH_ASSOC); $i++) : ?> 
									<?php if ($results3['idusuario'] == $results['usuarioId']): ?>
										<?= $results3['nombreUsuario'] ?> 
									<?php endif; ?>
								<?php endfor; ?>
							</td>
							<td><?= $results['tipoClasificacion'] ?></td>
							<td><?= $results['descripcion'] ?></td>
							<td>
								<a class="btn btn-primary" href="editarclasificacion.php?id=<?= $results['idclasificacion'] ?>">Editar</a>
							</td>
							<td>
								<a class="btn btn-primary" href="eliminarclasificacion.php?id=<?= $results['idclasificacion'] ?>">Eliminar</a>
							</td>
						</tr>
					<?php endfor; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>

	<form class="contform" method="POST" action="Clasificacion.php">
		<h2 class="h2">Formulario de Clasificaciones</h2>
		<div class="form-group">
			<label class="control-label">Nombre de la Clasificación:</label>
			<input type="text" class="form-control" name="tipoClasificacion" placeholder="Escribe la Clasificación: ">
		</div>
		<div class="form-group">
			<label class="control-label">Usuarios:</label>
			<select class="form-select" name="usuarioId">
				<?php if ($records2->rowcount() > 0): ?>
				<?php for ($i=0; $i < $results2 = $records2->fetch(PDO::FETCH_ASSOC); $i++): ?>
					<?php if($results2['rango'] >= 3): ?>
						<option value="<?= $results2['idusuario'] ?>"><?= $results2['nombreUsuario'] ?></option>
					<?php endif; ?>
				<?php endfor; ?>
				<?php endif; ?>
			</select>
		</div>
		<div class="form-group">
			<label class="control-label">Decripción:</label>
			<textarea class="form-control" placeholder="Decripción:" name="descripcion"></textarea>
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-primary">Agregar</button>
		</div>
	</form>

<?php require 'partials/footer.php' ?>