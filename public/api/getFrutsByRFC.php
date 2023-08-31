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
    main.CIDDOCUMENTO,
    main.serie,
    main.folio,
    main.CIDDOCUMENTOORIGEN,
    main.CIDPRODUCTO,
    SUM(main.unidades) AS totalUnidadesPorDocumento, -- Suma total de unidades por documento
    main.nombreFruta,
    main.talla
    FROM (
    SELECT
        d.CIDDOCUMENTO,
        d.CSERIEDOCUMENTO AS serie,
        d.CFOLIO AS folio,
        CIDDOCUMENTOORIGEN,
        m.CIDPRODUCTO,
        m.CUNIDADES AS unidades,
        p.CNOMBREPRODUCTO AS nombreFruta,
        c.CVALORCLASIFICACION AS talla
    FROM [ad2019_SPLENDOR_PRODUC].[dbo].[admDocumentos] d
    JOIN [ad2019_SPLENDOR_PRODUC].[dbo].[admMovimientos] m ON m.CIDDOCUMENTO = d.CIDDOCUMENTO
    JOIN [ad2019_SPLENDOR_PRODUC].[dbo].[admProductos] p ON p.CIDPRODUCTO = m.CIDPRODUCTO
    JOIN [ad2019_SPLENDOR_PRODUC].[dbo].[admClasificacionesValores] c ON c.CIDVALORCLASIFICACION =  p.CIDVALORCLASIFICACION3
    WHERE CRFC = $rfc 
    AND CSERIEDOCUMENTO = 'FRT-REY'
    ) AS main
    GROUP BY
    main.CIDDOCUMENTO,
    main.serie,
    main.folio,
    main.CIDDOCUMENTOORIGEN,
    main.CIDPRODUCTO,
    main.nombreFruta,
    main.talla";

$result = sqlsrv_query($conn, $sql);

while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $data[] = $row;
}

sqlsrv_close($conn);

echo json_encode($data);
?>