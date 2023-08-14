<!DOCTYPE html>
<html>
<head>
    <title>Shipping Addresses</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #663399; 
            color: #ffffff;
            padding: 20px;
        }
        .address-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: rgba(0, 0, 0, 0.342);
        }
        .address-group {
            margin-bottom: 15px;
        }
        .address-group strong {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="address-container">
        <h2>Shipping Address</h2>
        <div class="address-group">
            <strong>Office Address:</strong>
            <?php echo isset($_POST['office_address']) ? $_POST['office_address'] : ''; ?>
        </div>
        <div class="address-group">
            <strong>Home Address:</strong>
            <?php echo isset($_POST['home_address']) ? $_POST['home_address'] : ''; ?>
        </div>
    </div>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the office and home addresses from the form submission
    $officeAddress = $_POST['office_address'];
    $homeAddress = $_POST['home_address'];

    // Print the addresses for shipping
    echo "<!DOCTYPE html>";
    echo "<html>";
    echo "<head>";
    echo "<title>Shipping Address</title>";
    echo "</head>";
    echo "<body>";
    echo "<h2>Shipping Addresses:</h2>";
    echo "<strong>Office Address:</strong><br>";
    echo $officeAddress . "<br><br>";
    echo "<strong>Home Address:</strong><br>";
    echo $homeAddress . "<br><br>";
    echo "</body>";
    echo "</html>";
}
?>
