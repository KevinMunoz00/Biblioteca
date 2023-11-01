<?php 
	require 'partials/header.php';

	$message = 'sta vaciio';

	if(!empty($_POST['idsolicitudvisitante']) && !empty($_POST['usuarioId']) && !empty($_POST['libroId']) && !empty($_POST['cartaId']) && !empty($_POST['fechaPrestamo']) && !empty($_POST['tiempoPrestamo'])){

		$sql = "UPDATE solicitudvisitante SET  usuarioId = :usuarioId, libroId = :libroId, cartaId = :cartaId, fechaPrestamo = :fechaPrestamo, tiempoPrestamo = :tiempoPrestamo WHERE idsolicitudvisitante = :idsolicitudvisitante";

	    $stmt = $conn->prepare($sql);
	    $stmt->bindParam(':usuarioId', $_POST['usuarioId']);
	    $stmt->bindParam(':libroId', $_POST['libroId']);
	    $stmt->bindParam(':cartaId', $_POST['cartaId']);
	    $stmt->bindParam(':fechaPrestamo', $_POST['fechaPrestamo']);
	    $stmt->bindParam(':tiempoPrestamo', $_POST['tiempoPrestamo']);
	    $stmt->bindParam(':idsolicitudvisitante', $_POST['idsolicitudvisitante']);


	    if ($stmt->execute()) {
	      $message = 'Se han modificado los datos Exitosamente';
	      header('Location: /Biblioteca-main/solicitudvisitante.php');
	    } else {
	      $message = 'Ha ocurrido un error al modificar los datos';
	    }
	}

?>

  <?php if(!empty($message)): ?>
    <p> <?= $message ?></p>
  <?php endif; ?>


<?php require 'partials/footer.php' ?>