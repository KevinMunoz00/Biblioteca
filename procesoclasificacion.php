<?php 
	require 'partials/header.php';

	$message = 'sta vaciio';

	if(!empty($_POST['idclasificacion']) && !empty($_POST['usuarioId']) && !empty($_POST['descripcion']) && !empty($_POST['tipoClasificacion'])){

		$sql = "UPDATE clasificacion SET tipoClasificacion = :tipoClasificacion, usuarioId = :usuarioId, descripcion = :descripcion WHERE idclasificacion = :idclasificacion";

	    $stmt = $conn->prepare($sql);
	    $stmt->bindParam(':tipoClasificacion', $_POST['tipoClasificacion']);
	    $stmt->bindParam(':usuarioId', $_POST['usuarioId']);
	    $stmt->bindParam(':descripcion', $_POST['descripcion']);
	    $stmt->bindParam(':idclasificacion', $_POST['idclasificacion']);


	    if ($stmt->execute()) {
	      $message = 'Se han modificado los datos Exitosamente';
	      header('Location: /Biblioteca-main/clasificacion.php');
	    } else {
	      $message = 'Ha ocurrido un error al modificar los datos';
	    }
	}

?>

  <?php if(!empty($message)): ?>
    <p> <?= $message ?></p>
  <?php endif; ?>


<?php require 'partials/footer.php' ?>