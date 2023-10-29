<?php 
	require 'partials/header.php';
	require 'database.php';

	$carta = $_GET['id'];

	$records = $conn->prepare('SELECT idautor, nombreAutor FROM autor WHERE idautor = :idautor');
	$records->bindParam(':idautor', $carta);
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

	<form class="contform" method="POST" action="procesoautor.php">
		<h2 class="h2">Editar Autor</h2>
		<div class="form-group">
			<label class="control-label">Nombre del Autor:</label>
			<input type="text" class="form-control" name="nombreAutor" placeholder="Escribe el nombre: " value="<?= $results['nombreAutor']?>">
		</div>
		<input type="hidden" name="idautor" value="<?= $results['idautor']?>">
		<div class="form-group">
			<button type="submit" class="btn btn-primary">Modificar</button>
		</div>
	</form>

<?php require 'partials/footer.php' ?>