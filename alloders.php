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

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $usernameDB, $passwordDB);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $username = $_SESSION['username'];

    $stmt = $pdo->prepare("SELECT * FROM orderss WHERE username = ?");
    $stmt->execute([$username]);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Order History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0; /* Light gray body background */
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #008080; /* Teal color */
            border-radius: 5px;
            background-color: #fff; /* White background */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd; /* Light gray border */
        }

        th {
            background-color: #008080; /* Teal color */
            color: #fff;
        }

        tr:hover {
            background-color: #f5f5f5; /* Light gray background on hover */
        }

        button {
            background-color: #008080; /* Teal color */
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #006666; /* Darker Teal color on hover */
        }
    </style>
</head>


<body>

    <div class="container">
        <h2>Order History for <?php echo htmlspecialchars($username); ?></h2>

        <?php if (count($orders) > 0) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Order Details</th>
                        <th>Order Total</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order) : ?>
                        <tr>
                        
                            <td><?php echo $order['order_details']; ?></td>
                            <td><?php echo $order['order_total']; ?></td>
                            
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>No orders found.</p>
        <?php endif; ?>
    </div>
    <button onclick="redirectToLogin()">Go Back</button>

    <script>
        function redirectToLogin() {
            window.location.href = "catalog.php";
        }
    </script>
</body>
</html>
