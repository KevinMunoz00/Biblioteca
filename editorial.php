<?php
require 'partials/header.php'; // Incluye el encabezado de la página.
require 'database.php'; // Incluye el archivo de configuración de la base de datos.

$carta = $_GET['id']; // Obtiene el valor del parámetro 'id' de la URL.

$records = $conn->prepare('SELECT idmulta, tipoMulta, valorMulta FROM multa WHERE idmulta = :idmulta');
$records->bindParam(':idmulta', $carta); // Vincula el valor de 'idmulta' al parámetro en la consulta SQL.
$records->execute(); // Ejecuta la consulta para obtener los detalles de la multa.
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

<form class="contform" method="POST" action="procesomulta.php">
	<h2 class="h2">Editar Multa</h2>
	<div class="form-group">
		<label class="control-label">Tipo de Multa:</label>
		<input type="text" class="form-control" name="tipoMulta" placeholder="Escribe la multa: "
			value="<?= $results['tipoMulta'] ?>">
	</div>
	<div class="form-group">
		<label class="control-label">Valor de la Multa:</label>
		<input type="number" class="form-control" name="valorMulta" placeholder="Escribe el Valor: "
			value="<?= $results['valorMulta'] ?>">
	</div>
	<input type="hidden" name="idmulta" value="<?= $results['idmulta'] ?>">
	<!-- Campo oculto para enviar el ID de la multa. -->
	<div class="form-group">
		<button type="submit" class="btn btn-primary">Modificar</button>
	</div>
</form>

<?php require 'partials/footer.php'; // Incluye el pie de página. ?>