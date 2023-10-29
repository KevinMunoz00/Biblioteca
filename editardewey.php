<?php 
	require 'partials/header.php';
	require 'database.php';

	$carta = $_GET['id'];

	$records = $conn->prepare('SELECT idcdd, nombreDewey FROM cdd WHERE idcdd = :idcdd');
	$records->bindParam(':idcdd', $carta);
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

	<form class="contform" method="POST" action="procesodewey.php">
		<h2 class="h2">Editar Categoria de Dewey</h2>
		<div class="form-group">
			<label class="control-label">Nombre de la Categoria:</label>
			<input type="text" class="form-control" name="nombreDewey" placeholder="Escribe tu Nombre: " value="<?= $results['nombreDewey']?>">
		</div>
		<input type="hidden" name="idcdd" value="<?= $results['idcdd']?>">
		<div class="form-group">
			<button type="submit" class="btn btn-primary">Modificar</button>
		</div>
	</form>

<?php require 'partials/footer.php' ?>