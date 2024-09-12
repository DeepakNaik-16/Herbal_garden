<?php
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

$name = $_POST['name'];
$properties = $_POST['properties'];

if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $tmp_name = $_FILES['image']['tmp_name'];
    $image_name = basename($_FILES['image']['name']);
    $upload_dir = 'uploads/';
    $upload_file = $upload_dir . $image_name;

    if (move_uploaded_file($tmp_name, $upload_file)) {
        $sql = "INSERT INTO plants (name, image, properties) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $upload_file, $properties);
        
        if ($stmt->execute()) {
            echo "New plant added successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        echo "Error uploading file.";
    }
} else {
    echo "No file uploaded or upload error.";
}

$conn->close();
?>
