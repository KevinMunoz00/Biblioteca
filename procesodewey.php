<?php 
	require 'partials/header.php';

	$message = 'Esta vacio';

	if(!empty($_POST['idcdd']) && !empty($_POST['nombreDewey'])){

		$sql = "UPDATE cdd SET nombreDewey = :nombreDewey WHERE idcdd = :idcdd";

	    $stmt = $conn->prepare($sql);
	    $stmt->bindParam(':nombreDewey', $_POST['nombreDewey']);
	    $stmt->bindParam(':idcdd', $_POST['idcdd']);


	    if ($stmt->execute()) {
	      $message = 'Se han modificado los datos Exitosamente';
	      header('Location: /Biblioteca-main/dewey.php');
	    } else {
	      $message = 'Ha ocurrido un error al modificar los datos';
	    }
	}

?>

  <?php if(!empty($message)): ?>
    <p> <?= $message ?></p>
  <?php endif; ?>


<?php require 'partials/footer.php' ?>