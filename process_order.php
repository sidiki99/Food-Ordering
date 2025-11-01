<?php
require_once 'includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Begin transaction
        $pdo->beginTransaction();
        
        // Insert customer
        $stmt = $pdo->prepare("INSERT INTO customers (name, email, phone, address, delivery_instructions, branch, payment_method, delivery_time, special_requests) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['name'],
            $_POST['email'],
            $_POST['phone'],
            $_POST['address'],
            $_POST['instructions'],
            $_POST['branch'],
            $_POST['payment'],
            $_POST['time'],
            $_POST['notes']
        ]);
        $customer_id = $pdo->lastInsertId();
        
        // Calculate total and insert order
        $total = 0;
        foreach ($_POST['item'] as $item_id => $quantity) {
            if ($quantity > 0) {
                $price = $_POST['price'][$item_id];
                $total += $quantity * $price;
            }
        }
        
        $stmt = $pdo->prepare("INSERT INTO orders (customer_id, total_amount) VALUES (?, ?)");
        $stmt->execute([$customer_id, $total]);
        $order_id = $pdo->lastInsertId();
        
        // Insert order items
        $stmt = $pdo->prepare("INSERT INTO order_items (order_id, item_name, quantity, price) VALUES (?, ?, ?, ?)");
        foreach ($_POST['item'] as $item_id => $quantity) {
            if ($quantity > 0) {
                $item_name = $_POST['item_name'][$item_id];
                $price = $_POST['price'][$item_id];
                $stmt->execute([$order_id, $item_name, $quantity, $price]);
            }
        }
        
        // Commit transaction
        $pdo->commit();
        
        // Redirect to success page
        header("Location: order_success.php?order_id=$order_id");
        exit();
        
    } catch (Exception $e) {
        $pdo->rollBack();
        die("Error processing order: " . $e->getMessage());
    }
} else {
    header("Location: index.php");
    exit();
}
?>