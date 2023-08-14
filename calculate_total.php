<?php 
session_start();
$bookIds = json_decode($_POST['bookIds'], true);

// Retrieve the book prices from the database based on the book IDs
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'bookhive';

    // Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

    // Build the SQL query to retrieve the book prices
$sql = 'SELECT Price FROM Books WHERE BookID IN (' . implode(',', $bookIds) . ')';
$result = $conn->query($sql);

$totalPrice = 0;

if ($result->num_rows > 0) {
        // Calculate the total price
    while ($row = $result->fetch_assoc()) {
        $totalPrice += $row['Price'];
    }
}

$conn->close();
echo $totalPrice;
?>