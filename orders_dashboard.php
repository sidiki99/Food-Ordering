
<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit;
}

// 1. Database Connection
require_once 'includes/db_connect.php';

// Handle Delete Action
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    
    try {
        $pdo->beginTransaction();
        
        // First delete order items
        $stmt = $pdo->prepare("DELETE FROM order_items WHERE order_id = ?");
        $stmt->execute([$order_id]);
        
        // Then delete the order
        $stmt = $pdo->prepare("DELETE FROM orders WHERE id = ?");
        $stmt->execute([$order_id]);
        
        $pdo->commit();
        
        // Redirect to avoid resubmission
        header('Location: orders_dashboard.php?deleted=1');
        exit;
        
    } catch (PDOException $e) {
        $pdo->rollBack();
        die("Error deleting order: " . $e->getMessage());
    }
}

// 2. Fetch Orders Data
try {
    $stmt = $pdo->query("
        SELECT 
            o.id AS order_id,
            c.name AS customer_name,
            c.phone,
            o.total_amount,
            o.created_at,
            o.status,
            COUNT(oi.id) AS item_count
        FROM orders o
        JOIN customers c ON o.customer_id = c.id
        LEFT JOIN order_items oi ON o.id = oi.order_id
        GROUP BY o.id
        ORDER BY o.created_at DESC
    ");
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching orders: " . $e->getMessage());
}

// 3. Fetch Order Items when specific order is selected
$order_items = [];
if (isset($_GET['order_id']) && !isset($_GET['action'])) {
    try {
        $stmt = $pdo->prepare("
            SELECT item_name, quantity, price 
            FROM order_items 
            WHERE order_id = ?
        ");
        $stmt->execute([$_GET['order_id']]);
        $order_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error fetching order items: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HalalBites - Orders Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2ecc71;
            text-align: center;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #3498db;
            color: white;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .status-pending {
            color: #e67e22;
            font-weight: bold;
        }
        .status-processing {
            color: #3498db;
            font-weight: bold;
        }
        .status-completed {
            color: #2ecc71;
            font-weight: bold;
        }
        .status-cancelled {
            color: #e74c3c;
            font-weight: bold;
        }
        .order-details {
            margin-top: 30px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .action-btns {
            display: flex;
            gap: 5px;
        }
        .view-btn {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }
        .delete-btn {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }
        .view-btn:hover {
            background-color: #2980b9;
        }
        .delete-btn:hover {
            background-color: #c0392b;
        }
        .alert {
            padding: 10px 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            color: white;
        }
        .alert-success {
            background-color: #2ecc71;
        }
    </style>
    <script>
        function confirmDelete(orderId) {
            if (confirm('Are you sure you want to delete this order? This action cannot be undone.')) {
                window.location.href = 'orders_dashboard.php?action=delete&order_id=' + orderId;
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>HalalBites Orders Dashboard</h1>
        
        <?php if (isset($_GET['deleted'])): ?>
            <div class="alert alert-success">
                Order has been deleted successfully!
            </div>
        <?php endif; ?>
        
        <!-- Orders Table -->
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Phone</th>
                    <th>Total</th>
                    <th>Items</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td>#<?= htmlspecialchars($order['order_id']) ?></td>
                    <td><?= htmlspecialchars($order['customer_name']) ?></td>
                    <td><?= htmlspecialchars($order['phone']) ?></td>
                    <td>Rs. <?= number_format($order['total_amount'], 2) ?></td>
                    <td><?= $order['item_count'] ?></td>
                    <td><?= date('M j, Y g:i A', strtotime($order['created_at'])) ?></td>
                    <td class="status-<?= strtolower($order['status']) ?>">
                        <?= ucfirst($order['status']) ?>
                    </td>
                    <td>
                        <div class="action-btns">
                            <a href="orders_dashboard.php?order_id=<?= $order['order_id'] ?>" class="view-btn">
                                View
                            </a>
                            <a href="#" onclick="confirmDelete(<?= $order['order_id'] ?>)" class="delete-btn">
                                Delete
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Order Details Section -->
        <?php if (isset($_GET['order_id']) && !empty($order_items)): ?>
        <div class="order-details">
            <h2>Order #<?= htmlspecialchars($_GET['order_id']) ?> Details</h2>
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
                    <?php foreach ($order_items as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['item_name']) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td>Rs. <?= number_format($item['price'], 2) ?></td>
                        <td>Rs. <?= number_format($item['quantity'] * $item['price'], 2) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>