<?php
// Include the database connection
include('includes/db.php');

// Start the session
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize user inputs
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password for security

    // Basic validation
    if (empty($username) || empty($email) || empty($password)) {
        echo "All fields are required!";
    } else {
        // Check if the username or email already exists
        $check_user = "SELECT * FROM users WHERE username='$username' OR email='$email'";
        $result = $conn->query($check_user);

        if ($result->num_rows > 0) {
            echo "Username or email already exists!";
        } else {
            // Insert new user into the database
            $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
            
            if ($conn->query($sql) === TRUE) {
                // Fetch the newly registered user's data
                $user_id = $conn->insert_id;
                
                // Set session variables after registration
                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;

                // Optionally, set other session data, like join_date
                $join_date = date('Y-m-d H:i:s');
                $_SESSION['join_date'] = $join_date;

                // Redirect to the dashboard after registration
                header('Location: login.php');
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Milk Tea Store</title>
    <link rel="stylesheet" href="css/login-register.css">
</head>
<body>

<form method="POST" action="register.php">
<h2>Register an Account</h2>
    <label for="username">Username:</label>
    <input type="text" name="username" required>
    
    <label for="email">Email:</label>
    <input type="email" name="email" required>
    
    <label for="password">Password:</label>
    <input type="password" name="password" required>

    <button type="submit">Register</button>
    <p>Already have an account? <a href="login.php">Login here</a></p>
</form>

</body>
</html>
