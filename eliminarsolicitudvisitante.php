<?php 
	require 'partials/header.php';
	require 'database.php';

	$carta = $_GET['id'];

	$sql = "DELETE FROM solicitudvisitante WHERE idsolicitudvisitante ='$carta'";
	$stmt = $conn->prepare($sql);

	if ($stmt->execute()) {
      $message = 'Se ha Eliminado una solicitud del visitante exitosamente';
      header('Location: /proyectoBiblioteca/solicitudvisitante.php');
    } else {
      $message = 'Ha ocurrido un error al Eliminar la solicitud del visitante';
    }
?>

	<?php if(!empty($message)): ?>
    	<p> <?= $message ?></p>
  	<?php endif; ?>

<?php require 'partials/footer.php' ?>