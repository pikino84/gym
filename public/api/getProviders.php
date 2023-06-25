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

$sql = "SELECT CCODIGOCLIENTE, CRAZONSOCIAL, CRFC, CCURP, CESTATUS FROM admClientes WHERE CESTATUS = 1 AND CTIPOCLIENTE = 3";
$result = sqlsrv_query($conn, $sql);

while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $data[] = $row;
}

sqlsrv_close($conn);

echo json_encode($data);
?>