<?php
// Replace these variables with your own database credentials
$servername = "localhost";
$usernamedb = "root";
$passworddb = "";
$dbname = "user-info";

// Get data from form submission
$name = $_POST["name"];
$username = $_POST["username"];
$email = $_POST["email"];
$password = $_POST["password"];

// Create connection
$conn = new mysqli($servername, $usernamedb, $passworddb, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user already exists
$check_stmt = $conn->prepare("SELECT username FROM userdata WHERE username = ?");
$check_stmt->bind_param("s", $username);

$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
    // User already exists, display error message or redirect to an error page
    header("Location: ../signup.html?error=Username is already exist");
} else {
    // User does not exist, insert data into the database
    $stmt = $conn->prepare("INSERT INTO userdata (name, username, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $username, $email, $password);

    if ($stmt->execute()) {
        // Send confirmation email and redirect to homepage
            

        header("Location: ../homepage.html");
    }
    
    $stmt->close();
}

// Close check statement and database connection
$check_stmt->close();
$conn->close();
?>