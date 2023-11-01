<?php 
	require 'partials/header.php';
	require 'database.php';

	$carta = $_GET['id'];

	$sql = "DELETE FROM clasificacion WHERE idclasificacion ='$carta'";
	$stmt = $conn->prepare($sql);

	if ($stmt->execute()) {
      $message = 'Se ha Eliminado una clasificacion exitosamente';
      header('Location: /Biblioteca-main/clasificacion.php');
    } else {
      $message = 'Ha ocurrido un error al Eliminar la clasificacion';
    }
?>

	<?php if(!empty($message)): ?>
    	<p> <?= $message ?></p>
  	<?php endif; ?>

<?php require 'partials/footer.php' ?>