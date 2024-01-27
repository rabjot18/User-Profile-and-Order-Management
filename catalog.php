<?php
session_start();

$email = $_SESSION['email'];
$username = $_SESSION['username'];

$host = 'db.cs.dal.ca';
$usernameDB = 'rabjot';
$passwordDB = 'Y3iB7aEcUSiAh4nLtxALGfSLX';
$database = 'rabjot';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $usernameDB, $passwordDB);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $username = $_SESSION['username'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>User Profile</title>
    <style>
        /* Add your CSS styles here */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f0f8ff; /* Light teal background */
            color: #333; /* Default text color */
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff; /* White container background */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        }

        h2 {
            color: #008080; /* Teal heading color */
        }

        button {
            padding: 8px 16px;
            background-color: #008080; /* Teal button color */
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background-color: #006666; /* Darker teal color on hover */
        }

        a {
            text-decoration: none;
            color: #008080; /* Teal link color */
            margin-right: 20px;
        }

        form {
            display: inline-block;
        }

        input[type="submit"] {
            background-color: #008080; /* Teal submit button color */
            color: #fff;
            padding: 8px 16px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        input[type="submit"]:hover {
            background-color: #006666; /* Darker teal color on hover */
        }
    </style>
</head>

<body>
    <div class="container">
        <nav>
            <a href="index.php">Home</a>
            <a href="login.php">Login</a>
        </nav>

        <h2>Welcome back, <?php echo htmlspecialchars($username); ?>!</h2>

        <button onclick="showViewProfile()">Profile Info</button>
        <div id="Viewprofile" style="display: none;">
            <h3>View Profile</h3>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        </div>

        <button onclick="showUpdateProfile()">Profile Updation</button>
        <div id="Updateprofile" style="display: none;">
            <h3>Update Profile</h3>
            <form method="post" action="">
                <label for="newUsername">New Username:</label>
                <input type="text" name="newUsername" value="<?php echo htmlspecialchars($user['username']); ?>"><br><br>

                <label for="newEmail">New Email:</label>
                <input type="email" name="newEmail" value="<?php echo htmlspecialchars($user['email']); ?>"><br><br>

                <label for="newPassword">New Password:</label>
                <input type="password" name="newPassword"><br><br>

                <input type="submit" value="Update Profile">
            </form>
        </div>
    </div>
    <form method="post" action="">
        <input type="submit" name="deleteProfile" value="Delete Profile">
    </form>

    <button onclick="redirectToLogin()">Place ORDER</button>

    <script>
        function redirectToLogin() {
            window.location.href = "orders.php";
        }
    </script>

    <script>
        function showViewProfile() {
            var viewProfileDiv = document.getElementById("Viewprofile");
            var updateProfileDiv = document.getElementById("Updateprofile");

            viewProfileDiv.style.display = "block";
            updateProfileDiv.style.display = "none";
        }

        function showUpdateProfile() {
            var viewProfileDiv = document.getElementById("Viewprofile");
            var updateProfileDiv = document.getElementById("Updateprofile");

            viewProfileDiv.style.display = "none";
            updateProfileDiv.style.display = "block";
        }
    </script>
</body>

</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$database", $usernameDB, $passwordDB);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $username = $_SESSION['username'];
        $newUsername = htmlspecialchars($_POST['newUsername']);
        $newEmail = htmlspecialchars($_POST['newEmail']);
        $newPassword = $_POST['newPassword'];

        if (!empty($newPassword)) {
            $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ?, password = ? WHERE username = ?");
            $stmt->execute([$newUsername, $newEmail, $hashed_password, $username]);
        } else {
            $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ? WHERE username = ?");
            $stmt->execute([$newUsername, $newEmail, $username]);
        }

        header("Location: done.php");
        exit();
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['deleteProfile'])) {
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$database", $usernameDB, $passwordDB);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $username = $_SESSION['username'];

            $stmtOrders = $pdo->prepare("DELETE FROM orderss WHERE username = ?");
            $stmtOrders->execute([$username]);

            $stmtUser = $pdo->prepare("DELETE FROM users WHERE username = ?");
            $stmtUser->execute([$username]);

            header("Location: done.php");
            exit();
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}
?>
