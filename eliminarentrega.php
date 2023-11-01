<?php 
	require 'partials/header.php';
	require 'database.php';

	$carta = $_GET['id'];

	$sql = "DELETE FROM entrega WHERE identrega ='$carta'";
	$stmt = $conn->prepare($sql);

	if ($stmt->execute()) {
      $message = 'Se ha Eliminado una entrega exitosamente';
      header('Location: /Biblioteca-main/entrega.php');
    } else {
      $message = 'Ha ocurrido un error al Eliminar la entrega';
    }
?>

	<?php if(!empty($message)): ?>
    	<p> <?= $message ?></p>
  	<?php endif; ?>

<?php require 'partials/footer.php' ?>