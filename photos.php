<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "snc_nutrition";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT filename, media_type FROM photos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Media Gallery | SNC Nutrition Centre</title>
    <link rel="stylesheet" href="styles1.css">
</head>
<body>
    <div class="gallery-container">
        <h1>Media Gallery</h1>
        <a href="index.html" class="back-button">Back to Index</a>
        <div class="gallery">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    if ($row["media_type"] == "photo") {
                        echo "<div class='media'>
                                <img src='" . $row["filename"] . "' alt='Photo'>
                              </div>";
                    } elseif ($row["media_type"] == "video") {
                        echo "<div class='media'>
                                <video controls>
                                    <source src='" . $row["filename"] . "' type='video/mp4'>
                                    Your browser does not support the video tag.
                                </video>
                              </div>";
                    }
                }
            } else {
                echo "<p>No media available</p>";
            }
            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
