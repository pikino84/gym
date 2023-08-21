<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

$serverName = "sqlexterno.database.windows.net";
$connectionOptions = array(
    "Database" => "COMERCIALDB",
    "Uid" => "israel",
    "PWD" => "Learsi01@",
    "CharacterSet" => "UTF-8"
);

$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    echo "Error de conexión a SQL Server.";
    die(print_r(sqlsrv_errors(), true));
} else {
    //echo "Conexión exitosa a SQL Server.";
}



$sql = "SELECT YEAR(m.CFECHA) AS Anio,
DATEPART(WEEK, m.CFECHA) AS Semana,
p.CIDPRODUCTO,
p.CNOMBREPRODUCTO,
SUM(p.CPRECIO1) AS CPRECIO1_acumulado
FROM [dbo].[admMovimientos] m
JOIN [dbo].[admProductos] p ON m.CIDPRODUCTO = p.CIDPRODUCTO
GROUP BY YEAR(m.CFECHA),
  DATEPART(WEEK, m.CFECHA),
  p.CIDPRODUCTO,
  p.CNOMBREPRODUCTO
ORDER BY YEAR(m.CFECHA) DESC,
  DATEPART(WEEK, m.CFECHA) DESC";
$result = sqlsrv_query($conn, $sql);

// Iniciar la tabla HTML
echo '<table>';
echo '<thead>';
echo '<tr>';
echo '<th>Año</th>';
echo '<th>Producto</th>';

// Obtener las semanas únicas
$semanas = array_unique(array_column($result, 'Semana'));
sort($semanas);

// Crear las columnas de semanas en el encabezado de la tabla
foreach ($semanas as $semana) {
    echo '<th>Semana ' . $semana . '</th>';
}
echo '</tr>';
echo '</thead>';
echo '<tbody>';

// Recorrer los resultados y generar las filas de la tabla
foreach ($result as $fila) {
    echo '<tr>';
    echo '<td>' . $fila['Anio'] . '</td>';
    echo '<td>' . $fila['CNOMBREPRODUCTO'] . '</td>';

    // Inicializar el acumulado para cada producto
    $acumulado = 0;

    // Recorrer las semanas y mostrar el acumulado para cada semana
    foreach ($semanas as $semana) {
        if ($fila['Semana'] == $semana) {
            $acumulado += $fila['CPRECIO1_acumulado'];
        }
        echo '<td>' . $acumulado . '</td>';
    }

    echo '</tr>';
}

// Cerrar la tabla HTML
echo '</tbody>';
echo '</table>';


sqlsrv_close($conn);


?>