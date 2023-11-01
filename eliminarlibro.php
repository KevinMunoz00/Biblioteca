<?php 
	require 'partials/header.php';
	require 'database.php';

	$carta = $_GET['id'];

	$sql = "DELETE FROM libro WHERE idlibro ='$carta'";
	$stmt = $conn->prepare($sql);

	if ($stmt->execute()) {
      $message = 'Se ha Eliminado un libro exitosamente';
      header('Location: /Biblioteca-main/libro.php');
    } else {
      $message = 'Ha ocurrido un error al Eliminar el libro';
    }
?>

	<?php if(!empty($message)): ?>
    	<p> <?= $message ?></p>
  	<?php endif; ?>

<?php require 'partials/footer.php' ?>