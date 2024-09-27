<?php
// Database connection settings
$servername = "localhost";  // Replace with your server details
$username = "root";         // Replace with your database username
$password = "vivek5814";             // Replace with your database password
$dbname = "project";   // Replace with your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $otp = $_POST['otp'];

    // Check if passwords match
    if ($password != $confirm_password) {
        echo "Passwords do not match!";
        exit();
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO users (fullname, email, phone, password, otp) VALUES (?, ?, ?, ?,?)");
    $stmt->bind_param("sssss", $fullname, $email, $phone, $hashed_password, $otp);

    // Execute the query
    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
