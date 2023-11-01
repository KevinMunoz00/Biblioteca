<?php
require 'partials/header.php'; // Incluye el encabezado de la página.
require 'database.php'; // Incluye el archivo de configuración de la base de datos.

$carta = $_GET['id']; // Obtiene el valor del parámetro 'id' de la URL.

$records = $conn->prepare('SELECT idcarta, NombreSolicitante, cedula, fecha, razonPrestamo FROM cartasolicitud WHERE idcarta = :idcarta');
$records->bindParam(':idcarta', $carta); // Vincula el valor de 'idcarta' al parámetro en la consulta SQL.
$records->execute(); // Ejecuta la consulta para obtener los detalles de la carta.
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

<form class="contform" method="POST" action="procesocarta.php">
	<h2 class="h2">Editar Carta de Solicitud</h2>
	<div class="form-group">
		<label class="control-label">Nombre del Solicitante:</label>
		<input type="text" class="form-control" name="nombreSolicitante" placeholder="Escribe tu Nombre: "
			value="<?= $results['NombreSolicitante'] ?>">
	</div>
	<div class="form-group">
		<label class="control-label">Cedula:</label>
		<input type="number" class="form-control" name="cedula" placeholder="Escribe tu Cedula: "
			value="<?= $results['cedula'] ?>">
	</div>
	<div class="form-group">
		<label class="control-label">Fecha:</label>
		<input type="date" name="fecha" placeholder="Introduzca la fecha" value="<?= $results['fecha'] ?>">
	</div>
	<div class="form-group">
		<label class="control-label">Razon del Prestamo:</label>
		<textarea class="form-control" placeholder="razon:"
			name="razonPrestamo"><?= $results['razonPrestamo'] ?></textarea>
	</div>
	<input type="hidden" name="idcarta" value="<?= $results['idcarta'] ?>">
	<!-- Campo oculto para enviar el ID de la carta. -->
	<div class="form-group">
		<button type="submit" class="btn btn-primary">Modificar</button>
	</div>
</form>

<?php require 'partials/footer.php'; // Incluye el pie de página. ?>