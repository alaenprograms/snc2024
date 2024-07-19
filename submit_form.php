<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "snc_nutrition";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$program = $_POST['program'];

$sql = "INSERT INTO participants (name, phone, address, program) VALUES ('$name', '$phone', '$address', '$program')";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Your form has been submitted successfully!'); window.location.href='index.html';</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
