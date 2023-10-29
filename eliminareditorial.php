<?php 
	require 'partials/header.php';
	require 'database.php';

	$carta = $_GET['id'];

	$sql = "DELETE FROM editorial WHERE ideditorial ='$carta'";
	$stmt = $conn->prepare($sql);

	if ($stmt->execute()) {
      $message = 'Se ha Eliminado una editorial exitosamente';
      header('Location: /proyectoBiblioteca/editorial.php');
    } else {
      $message = 'Ha ocurrido un error al Eliminar la editorial';
    }
?>

	<?php if(!empty($message)): ?>
    	<p> <?= $message ?></p>
  	<?php endif; ?>

<?php require 'partials/footer.php' ?>