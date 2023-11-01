<?php 
	require 'partials/header.php';
	require 'database.php';

	$carta = $_GET['id'];

	$sql = "DELETE FROM multa WHERE idmulta ='$carta'";
	$stmt = $conn->prepare($sql);

	if ($stmt->execute()) {
      $message = 'Se ha Eliminado una multa exitosamente';
      header('Location: /Biblioteca-main/multa.php');
    } else {
      $message = 'Ha ocurrido un error al Eliminar la multa';
    }
?>

	<?php if(!empty($message)): ?>
    	<p> <?= $message ?></p>
  	<?php endif; ?>

<?php require 'partials/footer.php' ?>