<?php 
	require 'partials/header.php';

	$message = 'sta vaciio';

	if(!empty($_POST['identrega']) && !empty($_POST['usuarioId']) && !empty($_POST['libroId']) && !empty($_POST['multaId']) && !empty($_POST['fechaEntrega'])){

		$sql = "UPDATE entrega SET  usuarioId = :usuarioId, libroId = :libroId, multaId = :multaId, fechaEntrega = :fechaEntrega WHERE identrega = :identrega";

	    $stmt = $conn->prepare($sql);
	    $stmt->bindParam(':usuarioId', $_POST['usuarioId']);
	    $stmt->bindParam(':libroId', $_POST['libroId']);
	    $stmt->bindParam(':multaId', $_POST['multaId']);
	    $stmt->bindParam(':fechaEntrega', $_POST['fechaEntrega']);
	    $stmt->bindParam(':identrega', $_POST['identrega']);


	    if ($stmt->execute()) {
	      $message = 'Se han modificado los datos Exitosamente';
	      header('Location: /proyectoBiblioteca/entrega.php');
	    } else {
	      $message = 'Ha ocurrido un error al modificar los datos';
	    }
	}

?>

  <?php if(!empty($message)): ?>
    <p> <?= $message ?></p>
  <?php endif; ?>


<?php require 'partials/footer.php' ?>