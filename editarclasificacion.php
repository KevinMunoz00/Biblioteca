<?php 
	require 'partials/header.php';
	require 'database.php';

	$carta = $_GET['id'];

	$records = $conn->prepare('SELECT idclasificacion, tipoClasificacion, usuarioId, descripcion FROM clasificacion WHERE idclasificacion = :idclasificacion');
	$records->bindParam(':idclasificacion', $carta);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);

	$message = '';

	if(!count($results) > 0){
		$message = 'Hubo un problema en el codigo';
	}

	$records2 = $conn->prepare('SELECT idusuario, nombreUsuario, rango FROM usuario');
	$records2->execute();
?>
	
	<?php if(!empty($message)): ?>
	    <p> <?= $message ?></p>
	<?php endif; ?>

	<form class="contform" method="POST" action="procesoclasificacion.php">
		<h2 class="h2">Editar Clasificaciones</h2>
		<div class="form-group">
			<label class="control-label">Nombre de la Clasificación:</label>
			<input type="text" class="form-control" name="tipoClasificacion" placeholder="Escribe la Clasificación: " value="<?= $results['tipoClasificacion'] ?>">
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
			<label class="control-label">Descripción:</label>
			<textarea class="form-control" placeholder="Decripción:" name="descripcion"><?= $results['descripcion'] ?></textarea>
		</div>
		<input type="hidden" name="idclasificacion" value="<?= $results['idclasificacion']?>">
		<div class="form-group">
			<button type="submit" class="btn btn-primary">Modificar</button>
		</div>
	</form>

<?php require 'partials/footer.php' ?>