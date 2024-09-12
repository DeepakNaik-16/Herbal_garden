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

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Prepare SQL query
$sql = "SELECT id, name, image, LEFT(properties, 100) AS short_properties FROM plants WHERE name LIKE ? OR properties LIKE ?";
$stmt = $conn->prepare($sql);

// Escape special characters in search term and add wildcards for LIKE search
$searchTerm = "%{$searchTerm}%";
$stmt->bind_param("ss", $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

// Fetch results
$plants = [];
while ($row = $result->fetch_assoc()) {
    $plants[] = $row;
}

// Return JSON response
echo json_encode($plants);

$stmt->close();
$conn->close();
?>