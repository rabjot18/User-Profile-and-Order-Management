<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $host = 'db.cs.dal.ca';
$usernameDB = 'rabjot';
$passwordDB = 'Y3iB7aEcUSiAh4nLtxALGfSLX';
$database = 'rabjot';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$database", $usernameDB, $passwordDB);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
 
            $_SESSION['username'] = $username;
            header("Location: catalog.php");
            exit();
        } else {
            $loginError = "Invalid username or password";
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e0e0e0;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        form {
            max-width: 400px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333333;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555555;
        }
        input[type="text"],
        input[type="password"],
        input[type="submit"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border-radius: 3px;
            border: 1px solid #cccccc;
        }
        input[type="submit"] {
            background-color: #4285f4;
            color: #ffffff;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #357ae8;
        }
        p.error {
            color: #ff0000;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h2>Login</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <input type="submit" value="Login">
    </form>

    <?php if (isset($loginError)) { ?>
        <p class="error"><?php echo $loginError; ?></p>
    <?php } ?>
</body>
</html>
