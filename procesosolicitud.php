<?php 
	require 'partials/header.php';

	$message = 'sta vaciio';

	if(!empty($_POST['idsolicitud']) && !empty($_POST['usuarioId']) && !empty($_POST['libroId']) && !empty($_POST['fechaPrestamo']) && !empty($_POST['tiempoPrestamo'])){

		$sql = "UPDATE solicitud SET  usuarioId = :usuarioId, libroId = :libroId, fechaPrestamo = :fechaPrestamo, tiempoPrestamo = :tiempoPrestamo WHERE idsolicitud = :idsolicitud";

	    $stmt = $conn->prepare($sql);
	    $stmt->bindParam(':usuarioId', $_POST['usuarioId']);
	    $stmt->bindParam(':libroId', $_POST['libroId']);
	    $stmt->bindParam(':fechaPrestamo', $_POST['fechaPrestamo']);
	    $stmt->bindParam(':tiempoPrestamo', $_POST['tiempoPrestamo']);
	    $stmt->bindParam(':idsolicitud', $_POST['idsolicitud']);


	    if ($stmt->execute()) {
	      $message = 'Se han modificado los datos Exitosamente';
	      header('Location: /proyectoBiblioteca/solicitud.php');
	    } else {
	      $message = 'Ha ocurrido un error al modificar los datos';
	    }
	}

?>

  <?php if(!empty($message)): ?>
    <p> <?= $message ?></p>
  <?php endif; ?>


<?php require 'partials/footer.php' ?>