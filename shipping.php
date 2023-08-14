<!DOCTYPE html>
<html>
<head>
    <title>Address Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .box{
        height: 100vh;
        color: #ffffff;
        background-size: cover;
        background-repeat: no-repeat;
        background-image:
    url("images/login_bg.jpeg");
        }
        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color:rgba(0, 0, 0, 0.342);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-group input[type="text"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;

            border-radius: 5px;
        }
        .bookhive{
            height:50px;
            background-color: #663399;
            display:flex;
            text-align:center;
            align-items:center;
            justify-content:center;
            font-size:40px;
        }
        .form-group button {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="box">
        <div class="bookhive">BookHive</div>
        <div class="container">
            <h2>Enter Shipping Address</h2>
            <form method="post" action="saddress.php">
                <div class="form-group">
                    <label for="office_address">Office Address:</label>
                    <input type="text" name="office_address" id="office_address" required>
                </div>
                <div class="form-group">
                    <label for="home_address">Home Address:</label>
                    <input type="text" name="home_address" id="home_address" required>
                </div>
                <div class="form-group">
                    <button type="submit" name="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

<?php
if (isset($_POST['submit'])) {
    // Retrieve the office and home addresses from the form submission
    $officeAddress = $_POST['office_address'];
    $homeAddress = $_POST['home_address'];

    // Print the addresses for shipping
    echo "<h2>Shipping Addresses:</h2>";
    echo "<strong>Office Address:</strong><br>";
    echo $officeAddress . "<br><br>";
    echo "<strong>Home Address:</strong><br>";
    echo $homeAddress . "<br><br>";
}
?>