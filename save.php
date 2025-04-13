<?php
error_reporting(E_ALL);  // Show all errors
ini_set('display_errors', 1);

// Get the data from the form
$firstname = $_POST['FirstName'];  // Removed space
$lastname = $_POST['LastName'];    // Removed space
$Email = $_POST['Email'];          // Removed space
$mobilenumber = $_POST['Mobilenumber']; // Removed space
$Branch = $_POST['Branch'];       // Removed space
$Section = $_POST['Section'];     // Removed space

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'gdg'); // Replace with your DB credentials

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL
$stmt = $conn->prepare("INSERT INTO sign_ups (firstname, lastname, Email, mobilenumber, Branch, Section) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $firstname, $lastname, $Email, $mobilenumber, $Branch, $Section);

// Execute and check
if ($stmt->execute()) {
    session_start();
    $_SESSION['registered'] = true;
    echo "<script>alert('Registration successful!');
    window.location.href =  'home.php' </script>";
}

else if (empty($Email) || empty($firstname) || empty($lastname)) {
    die("❌ Error: Fields cannot be empty.");
}

else {
    echo "❌ Error: " . $stmt->error;
}

// Close connections
$stmt->close();
$conn->close();
?>
