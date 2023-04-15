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

// Prepare SQL statement
$stmt = $conn->prepare("INSERT INTO userdata (name, username, email, password) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $username, $email, $password);

// Execute query
if ($stmt->execute()) {
    function sendEmail($to, $from, $fromName, $subject, $message) {
        // Set additional headers
        $headers = "From: $fromName <$from>\r\n";
        $headers .= "Reply-To: $from\r\n";
        $headers .= "Content-type: text/html\r\n";
      
        // Send the email using the mail() function
        if (mail($to, $subject, $message, $headers)) {
            echo "Email sent successfully.";
        } else {
            echo "Email sending failed.";
        }
      }
    
    $to = $email;
$from = "certifyup.community@gmail.com";
$fromName = "CertifyUp";
$subject = "Account Creation Confirmation";
$message = "Dear $name,

We would like to take this opportunity to welcome you to [website name], the certificate generator website that offers a range of services to help you create and manage your certificates.

We are happy to inform you that your account has been successfully created. You can now log in to your account and access all the features available on our website.

If you have any questions, please do not hesitate to contact us. We are always here to help you and provide you with the best possible service.

Thank you for choosing [website name]. We hope you enjoy using our platform and look forward to seeing the certificates you create.

Best regards,
[Your Name]";      
sendEmail($to, $from, $fromName, $subject, $message);
header("Location: ../homepage.html");}
// Close statement and connection
$stmt->close();
$conn->close();


?>