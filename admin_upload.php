<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: admin_login.php");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "snc_nutrition";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$uploadDir = 'uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['media'])) {
    $uploadFile = $uploadDir . basename($_FILES['media']['name']);
    $fileType = pathinfo($uploadFile, PATHINFO_EXTENSION);
    $mediaType = in_array($fileType, ['jpg', 'jpeg', 'png', 'gif']) ? 'photo' : (in_array($fileType, ['mp4', 'avi', 'mov']) ? 'video' : '');

    if ($mediaType && move_uploaded_file($_FILES['media']['tmp_name'], $uploadFile)) {
        $stmt = $conn->prepare("INSERT INTO photos (filename, media_type) VALUES (?, ?)");
        $stmt->bind_param("ss", $uploadFile, $mediaType);
        $stmt->execute();
        echo "<script>alert('Media uploaded successfully!'); window.location.href='admin_upload.php';</script>";
    } else {
        echo "Error uploading file.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Upload | SNC Nutrition Centre</title>
    <link rel="stylesheet" href="styles1.css">
</head>
<body>
    <div class="upload-container">
        <h2>Upload Media</h2>
         <form action="admin_upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="media" accept="image/*,video/*" required>
            <input type="submit" value="Upload">
        </form>
        <a href="index.html" class="back-button">Back to Index</a>
    </div>
</body>
</html>
