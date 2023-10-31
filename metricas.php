<?php
date_default_timezone_set('America/Bogota');
require 'partials/header.php'; // Incluye el encabezado común

// Realiza la conexión a la base de datos aquí (usando require 'database.php' o tu lógica de conexión).
require 'database.php';

// Consulta 1: Número de entidades y registros
$query1 = "SELECT COUNT(*) AS NumeroEntidades, table_name AS Entidad, table_rows AS Registros
          FROM information_schema.tables
          WHERE table_schema = 'proyectobiblioteca'
          GROUP BY table_name";
$result1 = $conn->query($query1);
$guardar1 = $conn->query($query1);

// Almacena los resultados en un arreglo
$resultadoDatos1 = array();
while ($row = $guardar1->fetch(PDO::FETCH_ASSOC)) {
    $resultadoDatos1[] = $row;
}

// Consulta 2: Número de índices por tabla, Numero de Columnas y Llaves foraneas
$query2 = "SELECT
t.table_name AS Entidad,
AUTO_INCREMENT AS AutoIncrement,
COUNT(c.column_name) AS NumeroColumnas,
(
    SELECT COUNT(k.COLUMN_NAME)
    FROM information_schema.key_column_usage AS k
    WHERE k.table_name = t.table_name AND k.table_schema = t.table_schema
) AS NumeroLlavesForaneas
    FROM
    information_schema.tables AS t
    LEFT JOIN
    information_schema.columns AS c
    ON
    t.table_name = c.table_name
    AND t.table_schema = c.table_schema
    WHERE
    t.table_schema = 'proyectobiblioteca'
    GROUP BY
    t.table_name;";
$result2 = $conn->query($query2);
$guardar2 = $conn->query($query2);

// Almacena los resultados en un arreglo
$resultadoDatos2 = array();
while ($row = $guardar2->fetch(PDO::FETCH_ASSOC)) {
    $resultadoDatos2[] = $row;
}


// Consulta 3: Tamaño de tabla
$query3 = "SELECT table_name AS Entidad, (data_length + index_length) / 1024 / 1024 AS TamañoMB
          FROM information_schema.tables
          WHERE table_schema = 'proyectobiblioteca'
          ORDER BY (data_length + index_length) DESC";
$result3 = $conn->query($query3);

// Almacena los resultados en un arreglo
$tamanioTablasData = array();
while ($row = $result3->fetch(PDO::FETCH_ASSOC)) {
    $tamanioTablasData[] = $row;
}

// Consulta 6: Tamaño de la Base de Datos
$query6 = "SELECT table_schema 'Base de datos', SUM(data_length + index_length) / 1024 / 1024 'Tamaño (MB)'
          FROM information_schema.tables
          WHERE table_schema = 'proyectobiblioteca'";
$result6 = $conn->query($query6);
$guardar6 = $conn->query($query6);


// Almacena los resultados en un arreglo
$resultadoDatos6 = array();
while ($row = $guardar6->fetch(PDO::FETCH_ASSOC)) {
    $resultadoDatos6[] = $row;
}


// Convierte los arrays de datos en formato JSON
$jsonData1 = json_encode($resultadoDatos1);
$jsonData2 = json_encode($resultadoDatos2);
$jsonData3 = json_encode($tamanioTablasData);
$jsonData6 = json_encode($resultadoDatos6);

// Define el nombre de la carpeta donde se almacenarán los archivos
$carpeta = 'datos';

// Verifica si la carpeta existe, y si no, créala
if (!is_dir($carpeta)) {
    mkdir($carpeta);
}

// Obtiene la fecha y hora actual
$fechaHora = date('Y-m-d_H-i-s');

// Define los nombres de los archivos con la fecha y hora
$archivo1 = $carpeta . '/data1' . '.txt';
$archivo2 = $carpeta . '/data2' . '.txt';
$archivo3 = $carpeta . '/data3' . '.txt';
$archivo6 = $carpeta . '/data6' . '.txt';

// Escribe los datos JSON en los archivos
file_put_contents($archivo1, $jsonData1 . " Fecha = " . $fechaHora . PHP_EOL, FILE_APPEND | LOCK_EX);
file_put_contents($archivo2, $jsonData2 . " Fecha = " . $fechaHora . PHP_EOL, FILE_APPEND | LOCK_EX);
file_put_contents($archivo3, $jsonData3 . " Fecha = " . $fechaHora . PHP_EOL, FILE_APPEND | LOCK_EX);
file_put_contents($archivo6, $jsonData6 . " Fecha = " . $fechaHora . PHP_EOL, FILE_APPEND | LOCK_EX);


?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container mt-4">
    <h1 class="text-center">Métricas de la Base de Datos</h1>

    <div class="container row col-12" style="margin: 5vh 0;">
        <!-- Número de Entidades y Registros -->
        <h2>Número de Entidades y Registros</h2>
        <div class="d-flex justify-content-center align-items-center">
            <table class="col-5 table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Entidad</th>
                        <th>Número de Registros</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $entidades = [];
                    $registros = [];

                    while ($row = $result1->fetch(PDO::FETCH_ASSOC)) {
                        $entidades[] = $row['Entidad'];
                        $registros[] = $row['Registros'];
                    }

                    foreach (array_combine($entidades, $registros) as $entidad => $registro) {
                    ?>
                        <tr>
                            <td><?= $entidad ?></td>
                            <td><?= $registro ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <div class="col-6">
                <h2>Gráfico de Barras</h2>
                <canvas id="entidades-registros-chart"></canvas>
            </div>
            <script>
                const ctx2 = document.getElementById('entidades-registros-chart').getContext('2d');

                new Chart(ctx2, {
                    type: 'bar',
                    data: {
                        labels: <?= json_encode($entidades) ?>,
                        datasets: [{
                            label: 'Número de Registros',
                            data: <?= json_encode($registros) ?>,
                            backgroundColor: 'rgba(54, 162, 235, 0.6)', // Color de las barras
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>
        </div>
    </div>

    <div class="container row col-12" style="margin: 5vh 0;">
        <h2 style="text-align: center;">Entidades, Registros, Índices y Llaves Foráneas</h2>
        <table class="col-8 table table-striped table-bordered table-hover" style="margin: 0 auto;">
            <thead>
                <tr>
                    <th>Entidad</th>
                    <th>N° Auto Increment</th>
                    <th>N° de Columnas</th>
                    <th>N° de Llaves Foráneas</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result2->fetch(PDO::FETCH_ASSOC)) : ?>
                    <tr>
                        <td><?= $row['Entidad'] ?></td>
                        <td><?= $row['AutoIncrement'] ?></td>
                        <td><?= $row['NumeroColumnas'] ?></td>
                        <td><?= $row['NumeroLlavesForaneas'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div class="container row col-12" style="margin: 5vh 0;">
        <!-- Tamaño de la Base de Datos -->
        <h2 style="text-align: center;">Tamaño de la Base de Datos</h2>
        <div class="col-md-6 d-flex justify-conter-center align-items-center">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Base de Datos</th>
                        <th>Tamaño (MB)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result6->fetch(PDO::FETCH_ASSOC)) : ?>
                        <tr>
                            <td><?= $row['Base de datos'] ?></td>
                            <td><?= $row['Tamaño (MB)'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="col-md-6">
            <!-- Tamaño de Tablas -->
            <h4 style="margin: 1vh 0;">Tamaño de Tablas</h4>
            <canvas id="tamanio-tablas-chart"></canvas>
        </div>
        <script>
            const ctx = document.getElementById('tamanio-tablas-chart').getContext('2d');
            const entidadData = <?php echo json_encode($tamanioTablasData); ?>

            // Convierte los valores a números
            entidadData.forEach(item => {
                item['TamañoMB'] = parseFloat(item['TamañoMB']);
            });

            // Calcula la suma total del tamaño de las tablas
            const totalSize = entidadData.reduce((acc, item) => acc + item['TamañoMB'], 0);

            // Calcula los porcentajes
            entidadData.forEach(item => {
                item['TamañoMB'] = (item['TamañoMB'] / totalSize) * 100;
            });

            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: entidadData.map(item => item.Entidad),
                    datasets: [{
                        data: entidadData.map(item => item['TamañoMB']),
                        backgroundColor: ['#FF5733', '#33FF57', '#3333FF', '#FF33AA', '#FFFF00', '#00FF00', '#0000FF', '#FF00FF', '#00FFFF', '#000000', '#c13d60'], // Colores para las partes del pastel
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': ' + context.parsed.toFixed(3) + '%'; // Mostrar el porcentaje con tres decimales
                                }
                            }
                        }
                    }
                }
            });
        </script>

    </div>
</div>




<?php require 'partials/footer.php'; // Incluye el pie de página común 
?>