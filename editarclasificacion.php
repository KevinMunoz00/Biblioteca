<?php
require 'partials/header.php'; // Incluye el encabezado de la página.
require 'database.php'; // Incluye el archivo de configuración de la base de datos.

$carta = $_GET['id']; // Obtiene el valor del parámetro 'id' de la URL.

$records = $conn->prepare('SELECT idclasificacion, tipoClasificacion, usuarioId, descripcion FROM clasificacion WHERE idclasificacion = :idclasificacion');
$records->bindParam(':idclasificacion', $carta); // Vincula el valor de 'idclasificacion' al parámetro en la consulta SQL.
$records->execute(); // Ejecuta la consulta para obtener los detalles de la clasificación.
$results = $records->fetch(PDO::FETCH_ASSOC); // Obtiene los resultados como un arreglo asociativo.

$message = '';

if (!count($results) > 0) {
	$message = 'Hubo un problema en el código'; // Verifica si no se encontraron resultados y muestra un mensaje de error.
}

$records2 = $conn->prepare('SELECT idusuario, nombreUsuario, rango FROM usuario');
$records2->execute(); // Prepara una consulta para seleccionar datos de la tabla usuario.

?>

<?php if (!empty($message)): ?>
	<p>
		<?= $message ?>
	</p> <!-- Muestra el mensaje de error. -->
<?php endif; ?>

<form class="contform" method="POST" action="procesoclasificacion.php">
	<h2 class="h2">Editar Clasificaciones</h2>
	<div class="form-group">
		<label class="control-label">Nombre de la Clasificación:</label>
		<input type="text" class="form-control" name="tipoClasificacion" placeholder="Escribe la Clasificación: "
			value="<?= $results['tipoClasificacion'] ?>">
	</div>
	<div class="form-group">
		<label class="control-label">Usuarios:</label>
		<select class="form-select" name="usuarioId">
			<?php if ($records2->rowcount() > 0): ?>
				<?php for ($i = 0; $i < $results2 = $records2->fetch(PDO::FETCH_ASSOC); $i++): ?>
					<?php if ($results2['rango'] >= 3): ?>
						<option value="<?= $results2['idusuario'] ?>">
							<?= $results2['nombreUsuario'] ?>
						</option>
					<?php endif; ?>
				<?php endfor; ?>
			<?php endif; ?>
		</select>
	</div>
	<div class="form-group">
		<label class="control-label">Descripción:</label>
		<textarea class="form-control" placeholder="Descripción:"
			name="descripcion"><?= $results['descripcion'] ?></textarea>
	</div>
	<input type="hidden" name="idclasificacion" value="<?= $results['idclasificacion'] ?>">
	<!-- Campo oculto para enviar el ID de la clasificación. -->
	<div class="form-group">
		<button type="submit" class="btn btn-primary">Modificar</button>
	</div>
</form>

<?php require 'partials/footer.php'; // Incluye el pie de página. ?>