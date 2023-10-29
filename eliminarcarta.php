<?php 
	require 'partials/header.php';
	require 'database.php';

	$carta = $_GET['id'];

	$sql = "DELETE FROM cartasolicitud WHERE idcarta ='$carta'";
	$stmt = $conn->prepare($sql);

	if ($stmt->execute()) {
      $message = 'Se ha Eliminado una carta exitosamente';
      header('Location: /proyectoBiblioteca/carta.php');
    } else {
      $message = 'Ha ocurrido un error al Eliminar la carta';
    }
?>

	<?php if(!empty($message)): ?>
    	<p> <?= $message ?></p>
  	<?php endif; ?>

<?php require 'partials/footer.php' ?>