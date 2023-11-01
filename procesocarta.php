<?php 
	require 'partials/header.php';

	$message = 'sta vaciio';

	if(!empty($_POST['idcarta']) && !empty($_POST['nombreSolicitante']) && !empty($_POST['cedula']) && !empty($_POST['fecha']) && !empty($_POST['razonPrestamo'])){

		$sql = "UPDATE cartasolicitud SET nombreSolicitante = :nombreSolicitante, cedula = :cedula, fecha = :fecha, razonPrestamo = :razonPrestamo WHERE idcarta = :idcarta";

	    $stmt = $conn->prepare($sql);
	    $stmt->bindParam(':nombreSolicitante', $_POST['nombreSolicitante']);
	    $stmt->bindParam(':cedula', $_POST['cedula']);
	    $stmt->bindParam(':fecha', $_POST['fecha']);
	    $stmt->bindParam(':razonPrestamo', $_POST['razonPrestamo']);
	    $stmt->bindParam(':idcarta', $_POST['idcarta']);


	    if ($stmt->execute()) {
	      $message = 'Se han modificado los datos Exitosamente';
	      header('Location: /Biblioteca-main/carta.php');
	    } else {
	      $message = 'Ha ocurrido un error al modificar los datos';
	    }
	}

?>

  <?php if(!empty($message)): ?>
    <p> <?= $message ?></p>
  <?php endif; ?>


<?php require 'partials/footer.php' ?>