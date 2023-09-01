<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

$serverName = "splendor.fortiddns.com";
$connectionOptions = array(
    "Database" => 'ad2019_SPLENDOR_PRODUC',
    "Uid" => 'sa',
    "PWD" => 'RSInfo1807',
    "CharacterSet" => "UTF-8"
);

$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    echo "Error de conexión a SQL Server.";
    die(print_r(sqlsrv_errors(), true));
} else {
    //echo "Conexión exitosa a SQL Server.";
}

if ( isset($_REQUEST['rfc']) ) {
    $rfc = htmlspecialchars($_REQUEST['rfc'], ENT_QUOTES, 'UTF-8');
}else{
    echo "RFC invalido";
    exit;
}

$sql = "SELECT 
	CIDDOCUMENTO,
	CIDCONCEPTODOCUMENTO,
	CSERIEDOCUMENTO,
	CRFC,
	CRAZONSOCIAL,
	CFECHA AS fecha,
	CSERIEDOCUMENTO AS serie, 
	CFOLIO AS folio,
	CPENDIENTE AS prestamos, 
	CIMPORTEEXTRA2 AS descuentos,
	(CPENDIENTE + CIMPORTEEXTRA2 ) AS deudaTotal
FROM ad2019_SPLENDOR_PRODUC.dbo.admDocumentos
WHERE CIMPORTEEXTRA2 = 1 OR CIMPORTEEXTRA2 > 1  AND CRFC = '$rfc'";

$result = sqlsrv_query($conn, $sql);
$data = array();
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $data[] = $row;
}

sqlsrv_close($conn);

echo json_encode($data);
?>