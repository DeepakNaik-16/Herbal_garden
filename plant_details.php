<?php
header('Content-Type: application/json');
$servername = "localhost:3305";
$username = "root";
$password = "Kartik@123";
$dbname = "herbal_garden";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = intval($_GET['id']);
$sql = "SELECT name, image, properties FROM plants WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $plant = $result->fetch_assoc();
    echo json_encode($plant);
} else {
    echo json_encode(["error" => "Plant not found"]);
}

$stmt->close();
$conn->close();
?>
