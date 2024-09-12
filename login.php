<?php
session_start();
$host = "localhost:3305"; // Update with your database host
$username = "root"; // Update with your database username
$password = "Kartik@123"; // Update with your database password
$dbname = "login_system"; // Update with your database name

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if email and password are correct
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Login success
        $_SESSION['email'] = $email;
        header("Location: admin.html");
    } else {
        // Login failed
        echo "<script>
                document.getElementById('error-msg').textContent = 'Invalid email or password';
              </script>";
    }
}

$conn->close();
?>
