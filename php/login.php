<?php
// Replace these variables with your own database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user-info";

// Get username and password from form submission
$user = $_POST["username"];
$pass = $_POST["password"];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL statement
$stmt = $conn->prepare("SELECT * FROM userdata WHERE username = ?");
$stmt->bind_param("s", $user);

// Execute query
$stmt->execute();

// Get result
$result = $stmt->get_result();

// Check if user exists
if ($result->num_rows == 0) {
    
    
        header("Location: ../loginform.html?error=user name is not found");
        
    exit();
} else {
    // User exists, check password
    $row = $result->fetch_assoc();
    if ($row["password"] != $pass) {
        // Password is wrong
        $new_value = "wrong";
        
        header("Location: ../loginform.html?error=Password is wrong");
       
    } else {
        // Username and password are correct
        
        header("Location: ../homepage.html");
    }
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
