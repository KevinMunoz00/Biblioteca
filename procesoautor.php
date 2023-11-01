<?php 
	require 'partials/header.php';

	$message = 'sta vaciio';

	if(!empty($_POST['idautor']) && !empty($_POST['nombreAutor'])){

		$sql = "UPDATE autor SET nombreAutor = :nombreAutor WHERE idautor = :idautor";

	    $stmt = $conn->prepare($sql);
	    $stmt->bindParam(':nombreAutor', $_POST['nombreAutor']);
	    $stmt->bindParam(':idautor', $_POST['idautor']);


	    if ($stmt->execute()) {
	      $message = 'Se han modificado los datos Exitosamente';
	      header('Location: /Biblioteca-main/autor.php');
	    } else {
	      $message = 'Ha ocurrido un error al modificar los datos';
	    }
	}

?>

  <?php if(!empty($message)): ?>
    <p> <?= $message ?></p>
  <?php endif; ?>


<?php require 'partials/footer.php' ?>