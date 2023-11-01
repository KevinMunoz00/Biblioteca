<?php 
	require 'partials/header.php';

	$message = 'sta vaciio';

	if(!empty($_POST['ideditorial']) && !empty($_POST['nombreEditorial'])){

		$sql = "UPDATE editorial SET nombreEditorial = :nombreEditorial WHERE ideditorial = :ideditorial";

	    $stmt = $conn->prepare($sql);
	    $stmt->bindParam(':nombreEditorial', $_POST['nombreEditorial']);
	    $stmt->bindParam(':ideditorial', $_POST['ideditorial']);


	    if ($stmt->execute()) {
	      $message = 'Se han modificado los datos Exitosamente';
	      header('Location: /Biblioteca-main/editorial.php');
	    } else {
	      $message = 'Ha ocurrido un error al modificar los datos';
	    }
	}

?>

  <?php if(!empty($message)): ?>
    <p> <?= $message ?></p>
  <?php endif; ?>


<?php require 'partials/footer.php' ?>