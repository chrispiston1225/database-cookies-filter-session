<?php
session_start();

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Example of user data (you can fetch this from a database)
$userData = [
    'username' => $_SESSION['username'],
    'email' => isset($_SESSION['email']) ? $_SESSION['email'] : 'Not available',  // Check if email exists
    'join_date' => isset($_SESSION['join_date']) ? $_SESSION['join_date'] : 'Not available'
];

// Updated menu items with prices starting at 100 pesos
$menuItems = [
    ['id' => 1, 'name' => 'Classic Milk Tea', 'price' => 100],
    ['id' => 2, 'name' => 'Brown Sugar Boba', 'price' => 110],
    ['id' => 3, 'name' => 'Matcha Latte', 'price' => 120],
    ['id' => 4, 'name' => 'Taro Milk Tea', 'price' => 105]
];

// Example order history (this would also come from the database in a real application)
$orderHistory = [
    ['order_id' => 101, 'date' => '2024-10-01', 'total' => 200],
    ['order_id' => 102, 'date' => '2024-10-05', 'total' => 150],
    ['order_id' => 103, 'date' => '2024-10-10', 'total' => 240],
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Milk Tea Store</title>
    <link rel="stylesheet" href="css/styles1.css">
</head>
<body>

    <header>
        <h1>Welcome to the Milk Tea Store, <?php echo htmlspecialchars($userData['username']); ?>!</h1>
        <nav>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="menu.php">Menu</a></li>
                <li><a href="orders.php">Order History</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <!-- User Profile Section -->
        <section class="profile">
            <h2>Your Profile</h2>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($userData['email']); ?></p>
            <p><strong>Joined on:</strong> <?php echo htmlspecialchars($userData['join_date']); ?></p>
        </section>

        <!-- Menu Section -->
        <section class="menu">
            <h2>Our Menu</h2>
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Price (₱)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($menuItems as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td>₱<?php echo number_format($item['price'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <!-- Order History Section -->
        <section class="orders">
            <h2>Your Order History</h2>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Total (₱)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orderHistory as $order): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                            <td><?php echo htmlspecialchars($order['date']); ?></td>
                            <td>₱<?php echo number_format($order['total'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

    </main>

    <!-- Footer Section -->
    <footer>
        <div class="footer-content">
            <p>&copy; <?php echo date('Y'); ?> Milk Tea Store. All Rights Reserved.</p>
            <p>Follow us on <a href="#">Facebook</a> | <a href="#">Instagram</a> | <a href="#">Twitter</a></p>
            <p><a href="contact.php">Contact Us</a></p>
        </div>
    </footer>

</body>
</html>
