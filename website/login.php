<?php
// Include the database connection
include('includes/db.php');

// Start the session
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect user inputs and sanitize them
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $remember_me = isset($_POST['remember_me']) ? true : false;

    // Basic input validation
    if (empty($email) || empty($password)) {
        echo "Please enter both email and password.";
    } else {
        // Check if user exists
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];  // Add email to session
                $_SESSION['join_date'] = $user['join_date']; // Store join date if needed

                // Handle Remember Me functionality
                if ($remember_me) {
                    // Generate a random token
                    $token = bin2hex(random_bytes(16));
                    $update_token_sql = "UPDATE users SET remember_token='$token' WHERE user_id=" . $user['user_id'];
                    $conn->query($update_token_sql);

                    // Set cookies for Remember Me (expires in 30 days)
                    setcookie('user_email', $email, time() + (30 * 24 * 60 * 60), "/"); // Cookie for 30 days
                    setcookie('user_token', $token, time() + (30 * 24 * 60 * 60), "/"); // Cookie for 30 days
                }

                // Redirect to the dashboard
                header('Location: dashboard.php');
                exit();
            } else {
                echo "Incorrect password!";
            }
        } else {
            echo "No user found with that email!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Milk Tea Store</title>
    <link rel="stylesheet" href="css/login-register.css">
</head>
<body>

<form method="POST" action="login.php">
<h2>Login to Your Account</h2>
    <label for="email">Email:</label>
    <input type="email" name="email" required>
    
    <label for="password">Password:</label>
    <input type="password" name="password" required>

    <label for="remember_me">
        <input type="checkbox" name="remember_me" /> Remember Me
    </label>

    <button type="submit">Login</button>
    <p>Don't have an account? <a href="register.php">Register here</a></p>
</form>

</body>
</html>
