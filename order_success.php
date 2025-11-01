
<?php
require_once 'includes/db_connect.php';

if (!isset($_GET['order_id'])) {
    header("Location: index.php");
    exit();
}

$order_id = $_GET['order_id'];

try {
    // Get order details
    $stmt = $pdo->prepare("
        SELECT o.*, c.name, c.email, c.phone, c.address 
        FROM orders o 
        JOIN customers c ON o.customer_id = c.id 
        WHERE o.id = ?
    ");
    $stmt->execute([$order_id]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$order) {
        throw new Exception("Order not found");
    }
    
    // Get order items
    $stmt = $pdo->prepare("SELECT * FROM order_items WHERE order_id = ?");
    $stmt->execute([$order_id]);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (Exception $e) {
    die("Error retrieving order: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - HalalBites</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Order Confirmation <span class="halal-badge">Halal</span></h1>
            <p class="tagline">Thank you for your order!</p>
        </header>
        
        <div class="order-summary">
            <h2>Order #<?= $order['id'] ?></h2>
            <p>Status: <?= ucfirst($order['status']) ?></p>
            <p>Order Date: <?= date('F j, Y g:i a', strtotime($order['created_at'])) ?></p>
            
            <h3>Customer Information</h3>
            <p><strong>Name:</strong> <?= htmlspecialchars($order['name']) ?></p>
            <p><strong>Phone:</strong> <?= htmlspecialchars($order['phone']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($order['email']) ?></p>
            <p><strong>Address:</strong> <?= nl2br(htmlspecialchars($order['address'])) ?></p>
            
            <h3>Order Items</h3>
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['item_name']) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td>Rs. <?= number_format($item['price'], 2) ?></td>
                        <td>Rs. <?= number_format($item['quantity'] * $item['price'], 2) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">Total:</th>
                        <th>Rs. <?= number_format($order['total_amount'], 2) ?></th>
                    </tr>
                </tfoot>
            </table>
            
            <p>We'll contact you shortly to confirm your order. For any questions, please call us at 0327-7379290 or msidiki075@gmail.com.</p>
        </div>
    </div>
</body>
</html>