<?php 
	require 'partials/header.php';
	require 'database.php';

	$carta = $_GET['id'];

	$sql = "DELETE FROM cdd WHERE idcdd ='$carta'";
	$stmt = $conn->prepare($sql);

	if ($stmt->execute()) {
      $message = 'Se ha Eliminado una categoria exitosamente';
      header('Location: /Biblioteca-main/dewey.php');
    } else {
      $message = 'Ha ocurrido un error al Eliminar la categoria';
    }
?>

	<?php if(!empty($message)): ?>
    	<p> <?= $message ?></p>
  	<?php endif; ?>

<?php require 'partials/footer.php' ?>