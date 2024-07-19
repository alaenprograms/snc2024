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

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $sql = "DELETE FROM participants WHERE id = $delete_id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Record deleted successfully!'); window.location.href='admin.php';</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$sql = "SELECT id, name, phone, address, program, reg_date FROM participants";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page | SNC Nutrition Centre</title>
    <link rel="stylesheet" href="adstyles.css">
</head>
<body>
    <div class="container">
        <h1>Participants List</h1>
        <button class="upload-button" onclick="window.location.href='admin_upload.php'">Upload Photo</button>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Program</th>
                <th>Registration Date</th>
                <th>Actions</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row["id"]. "</td>
                            <td>" . $row["name"]. "</td>
                            <td>" . $row["phone"]. "</td>
                            <td>" . $row["address"]. "</td>
                            <td>" . $row["program"]. "</td>
                            <td>" . $row["reg_date"]. "</td>
                            <td>
                                <form action='admin.php' method='post' style='display:inline;'>
                                    <input type='hidden' name='delete_id' value='" . $row["id"] . "'>
                                    <input type='submit' value='Clear' class='clear-button'>
                                </form>
                            </td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>0 results</td></tr>";
            }
            $conn->close();
            ?>
        </table>
    </div>
</body>
</html>
