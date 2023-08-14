<!DOCTYPE html>
<html>
<head>
    <title>My Cart</title>
    <style>
        body{
            height:100vh;
            color: whitesmoke;
            background-repeat:no-repeat;
            background-position: center;
            background-size: cover;
            background-image:linear-gradient(0deg, #8A2BE100, #8A2BE9), url("https://i.pinimg.com/originals/67/18/22/671822c2f63dd5f65d8fd15c9710420b.jpg");
        }
        table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 20px;
}

table, th, td {
  border: 1px solid #ccc;
}

th, td {
  padding: 10px;
}

th {
  background-color: #f2f2f2;
  color:black;
  text-align:left;
}

/* Button Styles */
button, a {
  padding: 8px 12px;
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  margin-right: 10px;
}
a{
    text-decoration:none;

}
a:hover{
    background-color: #0056b3;
}
button:hover {
  background-color: #0056b3;
}
    </style>
</head>
<body>
<?php
session_start();

// Check if the cart exists in the session
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo 'Your cart is empty.';
} else {
    // Retrieve the book IDs from the cart
    $bookIds = $_SESSION['cart'];

    // Retrieve the book details from the database based on the book IDs
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

    // Build the SQL query to retrieve the book details
    $sql = 'SELECT BookID, Title, Price FROM Books WHERE BookID IN (' . implode(',', $bookIds) . ')';
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<table>
                <tr>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr id="bookRow_' . $row['BookID'] . '">
                    <td>' . $row['Title'] . '</td>
                    <td>₹' . $row['Price'] . '</td>
                    <td><button onclick="deleteBook(' . $row['BookID'] . ')">Delete</button></td>
                  </tr>';
        }

        echo '</table>';
        
        // Add the "Total" button
        echo '<button onclick="calculateTotal()">Total</button>';
        
        // Add the "Buy" button
        echo '<a href="shipping.php">Buy</a>';
    } else {
        echo 'No books found in your cart.';
    }

    $conn->close();
}
?>

<script>
    function deleteBook(bookId) {
        if (confirm("Are you sure you want to delete this book?")) {
            // Delete the book details from the table displayed on the page
            var row = document.getElementById('bookRow_' + bookId);
            if (row) {
                row.parentNode.removeChild(row);
            }

            // Remove the book ID from the session cart array
            <?php
            if (!isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                // Retrieve the book ID to delete
                $bookIdToDelete = " + bookId + "; // Convert bookId to integer for PHP
            
                // Loop through the session cart array and remove the book ID
                foreach ($_SESSION['cart'] as $key => $cartBookId) {
                    if ($cartBookId == $bookIdToDelete) {
                        unset($_SESSION['cart'][$key]);
                        break;
                    }
                }

                // Optional: Reset the array keys to maintain consecutive numbering
                $_SESSION['cart'] = array_values($_SESSION['cart']);
            }
            ?>
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'delete_book.php');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    console.log(xhr.responseText);
                }
            };
            xhr.send('bookId=' + bookId);
        }
    }
    
    function calculateTotal() {
    // Send an AJAX request to retrieve the total price
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'calculate_total.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status === 200) {
            console.log(xhr.responseText);
            // Display the total price to the user
            alert('Total Price: ₹' + xhr.responseText);
        }
    };
    xhr.send('bookIds=' + JSON.stringify(<?php echo json_encode($_SESSION['cart']); ?>));
}

function buyBooks() {
    // Send an AJAX request to add the books in the cart to the Orders table
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'buy_books.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status === 200) {
            console.log(xhr.responseText);
            // Display a success message to the user
            alert('Books purchased successfully!');
            // Clear the cart in the session
            <?php unset($_SESSION['cart']); ?>
            // Reload the page to show an empty cart
            location.reload();
        }
    };
    xhr.send();
}
</script>
