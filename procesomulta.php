<?php 
	require 'partials/header.php';

	$message = 'sta vaciio';

	if(!empty($_POST['idmulta']) && !empty($_POST['tipoMulta']) && !empty($_POST['valorMulta'])){

		$sql = "UPDATE multa SET tipoMulta = :tipoMulta, valorMulta = :valorMulta WHERE idmulta = :idmulta";

	    $stmt = $conn->prepare($sql);
	    $stmt->bindParam(':tipoMulta', $_POST['tipoMulta']);
	    $stmt->bindParam(':valorMulta', $_POST['valorMulta']);
	    $stmt->bindParam(':idmulta', $_POST['idmulta']);


	    if ($stmt->execute()) {
	      $message = 'Se han modificado los datos Exitosamente';
	      header('Location: /Biblioteca-main/multa.php');
	    } else {
	      $message = 'Ha ocurrido un error al modificar los datos';
	    }
	}

?>

  <?php if(!empty($message)): ?>
    <p> <?= $message ?></p>
  <?php endif; ?>


<?php require 'partials/footer.php' ?>