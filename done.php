<!DOCTYPE html>
<html>
<head>
    <title>Profile Updated</title>
    <style>
    
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        h2 {
            color: #333;
        }
        button {
            padding: 8px 16px;
            background-color: #3498db;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <h2>You have updated your profile</h2>
    <p>Please Login again to continue.</p>
    <button onclick="redirectToLogin()">Login</button>

    <script>
        function redirectToLogin() {
            window.location.href = "login.php";
        }
    </script>
</body>
</html>
