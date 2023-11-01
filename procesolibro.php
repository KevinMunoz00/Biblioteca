<?php 
	require 'partials/header.php';

	$message = 'sta vaciio';

	if(!empty($_POST['idlibro']) && !empty($_POST['clasificacionId']) && !empty($_POST['deweyId']) && !empty($_POST['editorialId']) && !empty($_POST['autorId']) && !empty($_POST['nombreLibro']) && !empty($_POST['cantidadlibros'])){

		$sql = "UPDATE libro SET  clasificacionId = :clasificacionId, deweyId = :deweyId, editorialId = :editorialId, autorId = :autorId, nombreLibro = :nombreLibro, cantidadlibros = :cantidadlibros WHERE idlibro = :idlibro";

	    $stmt = $conn->prepare($sql);
	    $stmt->bindParam(':clasificacionId', $_POST['clasificacionId']);
	    $stmt->bindParam(':deweyId', $_POST['deweyId']);
	    $stmt->bindParam(':editorialId', $_POST['editorialId']);
	    $stmt->bindParam(':autorId', $_POST['autorId']);
	    $stmt->bindParam(':nombreLibro', $_POST['nombreLibro']);
	    $stmt->bindParam(':cantidadlibros', $_POST['cantidadlibros']);
	    $stmt->bindParam(':idlibro', $_POST['idlibro']);


	    if ($stmt->execute()) {
	      $message = 'Se han modificado los datos Exitosamente';
	      header('Location: /Biblioteca-main/libro.php');
	    } else {
	      $message = 'Ha ocurrido un error al modificar los datos';
	    }
	}

?>

  <?php if(!empty($message)): ?>
    <p> <?= $message ?></p>
  <?php endif; ?>


<?php require 'partials/footer.php' ?>