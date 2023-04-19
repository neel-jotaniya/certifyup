<?php
// Replace these variables with your own database credentials
$servername = "localhost";
$usernamedb = "root";
$passworddb = "";
$dbname = "user-info";

// Get data from form submission
$name = $_POST["name"];
$email = $_POST["email"];
$suggestion = $_POST["suggestion"];
$rating =  $_POST["rating"];
// Create connection
$conn = new mysqli($servername, $usernamedb, $passworddb, $dbname); 

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL statement
$stmt = $conn->prepare("INSERT INTO feedbackform (name, email, suggestion, rating) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email,$suggestion, $rating);

// Execute query
if ($stmt->execute()) {
    header("Location: ../homepage.html");
    
    }




?>