<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

<<<<<<< HEAD
$servername = "sqlexterno.database.windows.net";
$username = "israel";
$password = "Learsi01@";
$dbname = "COMERCIALDB";
=======
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "splendor";
>>>>>>> 8840d5626644abd190104368f2bc28cec15e0c6f

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}else{
    $conn->set_charset("utf8");
}

$sql = "SELECT id, razonsocial  FROM users WHERE razonsocial IS NOT NULL";
$result = $conn->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    $data[] = null;
}
$conn->close();

echo json_encode($data);
?>