<?php 
	require 'partials/header.php';
	require 'database.php';

	$carta = $_GET['id'];

	$records = $conn->prepare('SELECT idmulta, tipoMulta, valorMulta FROM multa WHERE idmulta = :idmulta');
	$records->bindParam(':idmulta', $carta);
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

	<form class="contform" method="POST" action="procesomulta.php">
		<h2 class="h2">Editar Multa</h2>
		<div class="form-group">
			<label class="control-label">Tipo de Multa:</label>
			<input type="text" class="form-control" name="tipoMulta" placeholder="Escribe la multa: " value="<?= $results['tipoMulta']?>">
		</div>
		<div class="form-group">
			<label class="control-label">Valor de la Multa:</label>
			<input type="number" class="form-control" name="valorMulta" placeholder="Escribe el Valor: " value="<?= $results['valorMulta']?>">
		</div>
		<input type="hidden" name="idmulta" value="<?= $results['idmulta']?>">
		<div class="form-group">
			<button type="submit" class="btn btn-primary">Modificar</button>
		</div>
	</form>

<?php require 'partials/footer.php' ?>