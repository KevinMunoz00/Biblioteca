<?php
require 'partials/header.php'; // Incluye el encabezado de la página.
require 'database.php'; // Incluye el archivo de configuración de la base de datos.

$carta = $_GET['id']; // Obtiene el valor del parámetro 'id' de la URL.

$records = $conn->prepare('SELECT idcdd, nombreDewey FROM cdd WHERE idcdd = :idcdd');
$records->bindParam(':idcdd', $carta); // Vincula el valor de 'idcdd' al parámetro en la consulta SQL.
$records->execute(); // Ejecuta la consulta para obtener los detalles de la categoría Dewey.
$results = $records->fetch(PDO::FETCH_ASSOC); // Obtiene los resultados como un arreglo asociativo.

$message = '';

if (!count($results) > 0) {
	$message = 'Hubo un problema en el código'; // Verifica si no se encontraron resultados y muestra un mensaje de error.
}
?>

<?php if (!empty($message)): ?>
	<p>
		<?= $message ?>
	</p> <!-- Muestra el mensaje de error. -->
<?php endif; ?>

<form class="contform" method="POST" action="procesodewey.php">
	<h2 class="h2">Editar Categoria de Dewey</h2>
	<div class="form-group">
		<label class="control-label">Nombre de la Categoria:</label>
		<input type="text" class="form-control" name="nombreDewey" placeholder="Escribe la Categoría: "
			value="<?= $results['nombreDewey'] ?>">
	</div>
	<input type="hidden" name="idcdd" value="<?= $results['idcdd'] ?>">
	<!-- Campo oculto para enviar el ID de la categoría Dewey. -->
	<div class="form-group">
		<button type="submit" class="btn btn-primary">Modificar</button>
	</div>
</form>

<?php require 'partials/footer.php'; // Incluye el pie de página. ?>