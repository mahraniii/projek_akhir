<?php
session_start();
include('../config.php'); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = MD5($_POST['password']); // Encrypt password

    if ($username == 'admin' && $password == MD5('admin123')) {
        $_SESSION['admin'] = true;
        header("Location: dashboard_admin.php");
    } else {
        echo "Invalid admin credentials";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1e1e2f;
            color: #ffffff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #232946;
            border-radius: 10px;
            padding: 20px;
            width: 100%;
            max-width: 300px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }
        .container h2 {
            text-align: center;
            color: #eebbc3;
            margin-bottom: 15px;
            font-size: 1.2rem;
        }
        .error-message {
            color: #ff6b6b;
            text-align: center;
            margin-bottom: 10px;
            font-size: 0.9rem;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: none;
            border-radius: 5px;
            background: #eebbc3;
            color: #232946;
            font-size: 1rem;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #eebbc3;
            border: none;
            border-radius: 5px;
            color: #232946;
            font-weight: bold;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #6e7dff;
        }
        p {
            text-align: center;
            color: #b0b0b0;
            font-size: 0.9rem;
        }
        a {
            color: #fff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-admin">
            <h2>Login Admin</h2>
            <form action="login_admin.php" method="post">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</body>
</html>

