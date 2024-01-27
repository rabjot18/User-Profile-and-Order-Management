<!DOCTYPE html>
<html>
<head>
    <title>Orders</title>
    <style>
   
   .container {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #008080; /* Teal color */
    border-radius: 5px;
    background-color: #f5f5f5; /* Light gray background */
}

input[type="text"],
input[type="number"],
input[type="submit"] {
    width: 100%;
    margin-bottom: 10px;
    padding: 8px;
    border-radius: 5px;
    border: 1px solid #008080; /* Teal color */
}

input[type="submit"] {
    background-color: #008080; /* Teal color */
    color: #fff;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #006666; /* Darker Teal color on hover */
}

body {
    background-color: #f0f0f0; /* Light gray body background */
}

    </style>
</head>
<body>
    <div class="container">
        <h2>Place Order</h2>
        <form method="post" action="">
            <label for="order_details">Order Details(TEXT):</label>
            <input type="text" name="order_details" placeholder="Enter order details"><br>

            <label for="order_total">Order Total(INT):</label>
            <input type="number" name="order_total" placeholder="Enter order total"><br>

            <input type="submit" value="Place Order">
        </form>
    </div>
    <button onclick="redirectToLogin()">Order History</button>

    <script>
        function redirectToLogin() {
            window.location.href = "alloders.php";
        }
    </script>

    <?php
    session_start();

    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit();
    }

    $host = 'db.cs.dal.ca';
$usernameDB = 'rabjot';
$passwordDB = 'Y3iB7aEcUSiAh4nLtxALGfSLX';
$database = 'rabjot';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$database", $usernameDB, $passwordDB);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $username = $_SESSION['username'];
            $orderDetails = htmlspecialchars($_POST['order_details']);
            $orderTotal = $_POST['order_total'];

            // Insert the order into the database
            $stmt = $pdo->prepare("INSERT INTO orderss (order_details, order_total, username) VALUES (?, ?, ?)");
            $stmt->execute([$orderDetails, $orderTotal, $username]);

            echo "<p>Order placed successfully!</p>";

        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
    ?>
</body>
</html>
