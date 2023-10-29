<?php 
	require 'partials/header.php';
	require 'database.php';

	$carta = $_GET['id'];

	$records = $conn->prepare('SELECT ideditorial, nombreEditorial FROM editorial WHERE ideditorial = :ideditorial');
	$records->bindParam(':ideditorial', $carta);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);

	$message = '';

	if(!count($results) > 0){
		$message = 'Hubo un problema en el codigo';
	}
?>
	
	<?php if(!empty($message)): ?>
	    <p> <?= $message ?></p>
	<?php endif; ?>

	<form class="contform" method="POST" action="procesoeditorial.php">
		<h2 class="h2">Editar Editorial</h2>
		<div class="form-group">
			<label class="control-label">Nombre de la editorial:</label>
			<input type="text" class="form-control" name="nombreEditorial" placeholder="Escribe el nombre de la editorial: " value="<?= $results['nombreEditorial']?>">
		</div>
		<input type="hidden" name="ideditorial" value="<?= $results['ideditorial']?>">
		<div class="form-group">
			<button type="submit" class="btn btn-primary">Modificar</button>
		</div>
	</form>

<?php require 'partials/footer.php' ?>