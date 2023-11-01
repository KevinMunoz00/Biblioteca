<?php require 'partials/header.php'; // Incluye el encabezado de la página.
require 'database.php'; // Incluye el archivo de configuración de la base de datos.

$message = ''; // Variable para almacenar mensajes de error o éxito.

if (!empty($_POST['NombreAutor'])) {
	// Si el campo "NombreAutor" no está vacío en el formulario enviado.
	$sql = "INSERT INTO autor(nombreAutor) VALUES(:nombreAutor)";
	$stmt = $conn->prepare($sql); // Prepara una declaración SQL.
	$stmt->bindParam(':nombreAutor', $_POST['NombreAutor']); // Vincula el valor del campo NombreAutor a la consulta.

	if ($stmt->execute()) {
		$message = 'Se ha creado un autor exitosamente'; // Si la inserción en la base de datos fue exitosa, muestra un mensaje de éxito.
	} else {
		$message = 'Ha ocurrido un error al ingresar los datos'; // Si hubo un error en la inserción, muestra un mensaje de error.
	}
}

$records = $conn->prepare('SELECT idautor, nombreAutor FROM autor'); // Prepara una consulta para seleccionar datos de la tabla autor.
$records->execute(); // Ejecuta la consulta.

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
				<th scope="col">Nombre</th>
				<th scope="col">Enlace</th>
				<th scope="col">Enlace</th>
			</tr>
		</thead>
		<tbody>
			<?php if ($records->rowcount() > 0): ?>
				<?php for ($i = 0; $i < $results = $records->fetch(PDO::FETCH_ASSOC); $i++): ?>
					<!-- Si hay registros en la tabla autor, muestra una tabla con los datos. -->
					<tr>
						<th scope="col">
							<?= $results['idautor'] ?>
						</th>
						<td>
							<?= $results['nombreAutor'] ?>
						</td>
						<td>
							<a class="btn btn-primary" href="editarautor.php?id=<?= $results['idautor'] ?>">Editar</a>
						</td>
						<td>
							<a class="btn btn-primary" href="eliminarautor.php?id=<?= $results['idautor'] ?>">Eliminar</a>
						</td>
					</tr>
				<?php endfor; ?>
			<?php endif; ?>
		</tbody>
	</table>
</div>

<form class="contform" method="POST" action="autor.php">
	<h2 class="h2">Formulario Autores</h2>
	<div class="form-group">
		<label class="control-label">Nombre del Autor:</label>
		<input type="text" class="form-control" name="NombreAutor" placeholder="Escribe el Nombre: ">
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-primary">Agregar</button>
	</div>
</form>

<?php require 'partials/footer.php' // Incluye el pie de página.?>