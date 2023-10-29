<?php
require 'partials/header.php'; // Incluye el encabezado de la página.
require 'database.php'; // Incluye el archivo de configuración de la base de datos.

$message = ''; // Variable para almacenar mensajes de error o éxito.

if (!empty($_POST['nombreDewey'])) {
	// Comprueba si el campo "nombreDewey" no está vacío en el formulario.
	$sql = "INSERT INTO cdd(nombreDewey) VALUES(:nombreDewey)";
	$stmt = $conn->prepare($sql); // Prepara una declaración SQL.
	$stmt->bindParam(':nombreDewey', $_POST['nombreDewey']); // Vincula el valor del campo nombreDewey a la consulta.

	if ($stmt->execute()) {
		$message = 'Se ha creado una nueva Clasificación'; // Si la inserción en la base de datos fue exitosa, muestra un mensaje de éxito.
	} else {
		$message = 'Ha ocurrido un error al ingresar los datos'; // Si hubo un error en la inserción, muestra un mensaje de error.
	}
}

$records = $conn->prepare('SELECT idcdd, nombreDewey FROM cdd');
$records->execute(); // Prepara una consulta para seleccionar datos de la tabla cdd.

?>
<?php if (!empty($message)): ?>
	<p>
		<?= $message ?>
	</p> <!-- Muestra el mensaje de éxito o error. -->
<?php endif; ?>

<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<tr>
				<th scope="col">No.</th>
				<th scope="col">Categoria</th>
				<th scope="col">Enlace</th>
				<th scope="col">Enlace</th>
			</tr>
		</thead>
		<tbody>
			<?php if ($records->rowcount() > 0): ?>
				<?php for ($i = 0; $i < $results = $records->fetch(PDO::FETCH_ASSOC); $i++): ?>
					<tr>
						<th scope="col">
							<?= $results['idcdd'] ?>
						</th>
						<td>
							<?= $results['nombreDewey'] ?>
						</td>
						<td>
							<a class="btn btn-primary" href="editardewey.php?id=<?= $results['idcdd'] ?>">Editar</a>
						</td>
						<td>
							<a class="btn btn-primary" href="eliminardewey.php?id=<?= $results['idcdd'] ?>">Eliminar</a>
						</td>
					</tr>
				<?php endfor; ?>
			<?php endif; ?>
		</tbody>
	</table>
</div>

<form class="contform" method="POST" action="dewey.php">
	<h2 class="h2">Formulario del Sistema Dewey de Clasificación</h2>
	<div class="form-group">
		<label class="control-label">Nombre de la Categoria:</label>
		<input type="text" class="form-control" name="nombreDewey" placeholder="Escribe la Categoria: ">
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-primary">Agregar</button>
	</div>
</form>

<?php require 'partials/footer.php'; // Incluye el pie de página. ?>