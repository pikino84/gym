<?php
$serverName = "sqlexterno.database.windows.net"; // Nombre del servidor
$connectionOptions = array(
    "Database" => "COMERCIALDB", // Nombre de la base de datos
    "Uid" => "israel", // Nombre de usuario de SQL Server
    "PWD" => "Learsi01@" // Contraseña de SQL Server
);

// Establecer la conexión
$conn = sqlsrv_connect($serverName, $connectionOptions);

// Verificar la conexión
if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Consulta SQL
$sql = "SELECT CCODIGOCLIENTE, CRAZONSOCIAL, CRFC, CCURP, CESTATUS FROM [COMERCIALDB].[dbo].[admClientes] WHERE CESTATUS = 1 AND CTIPOCLIENTE = 3";

// Ejecutar la consulta
$result = sqlsrv_query($conn, $sql);

// Verificar si la consulta fue exitosa
if ($result === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Obtener los resultados de la consulta
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    // Aquí puedes acceder a los datos de cada fila
    echo "ID: " . $row["CCODIGOCLIENTE"] . ", Nombre: " . $row["CRAZONSOCIAL"] . "<br>";
}

// Cerrar la conexión
sqlsrv_close($conn);
?>
