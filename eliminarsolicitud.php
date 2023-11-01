<?php 
	require 'partials/header.php';
	require 'database.php';

	$carta = $_GET['id'];

	$sql = "DELETE FROM solicitud WHERE idsolicitud ='$carta'";
	$stmt = $conn->prepare($sql);

	if ($stmt->execute()) {
      $message = 'Se ha Eliminado una solicitud exitosamente';
      header('Location: /Biblioteca-main/solicitud.php');
    } else {
      $message = 'Ha ocurrido un error al Eliminar la solicitud';
    }
?>

	<?php if(!empty($message)): ?>
    	<p> <?= $message ?></p>
  	<?php endif; ?>

<?php require 'partials/footer.php' ?>