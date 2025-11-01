
<?php
require_once 'includes/db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HalalBites - Online Food Ordering</title>
    <link rel="stylesheet" href="includes/assets/css/style.css">
</head>
<body>
    <div class="container">
        
        <header>
    <h1>HalalBites <span class="halal-badge">Halal</span></h1>
    <p class="tagline">Delicious meals delivered to your doorstep</p>
    <nav>
        <!-- <a href="orders_dashboard.php" class="dashboard-link">Dashboard</a> -->
        <a href="admin_login.php" class="dashboard-link">Dashboard</a>
    </nav>
</header>

        <form id="foodOrderForm" action="process_order.php" method="POST">
            <!-- Customer Information Section -->
            <div class="form-section">
                <h2>Your Information</h2>
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" required placeholder="Muhammad Ahmed">
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" required placeholder="0300 1234567">
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="muhammad@example.com">
                </div>
                <div class="form-group">
                    <label for="address">Delivery Address</label>
                    <textarea id="address" name="address" rows="3" required placeholder="House #123, Street 5, Model Town, Lahore"></textarea>
                </div>
                <div class="form-group">
                    <label for="instructions">Delivery Instructions</label>
                    <textarea id="instructions" name="instructions" rows="2" placeholder="Gate code, floor, etc."></textarea>
                </div>
            </div>

            <!-- Restaurant Branch Section -->
            <div class="form-section">
                <h2>Select Restaurant Branch</h2>
                <div class="form-group">
                    <label for="branch">Choose a branch:</label>
                    <select id="branch" name="branch" required>
                        <option value="">-- Select a branch --</option>
                        <option value="downtown">Downtown - Model Town, Lahore</option>
                        <option value="uptown">Uptown - Bahadurabad, Karachi</option>
                        <option value="riverside">Riverside - Islamabad</option>
                    </select>
                </div>
            </div>

            <!-- Menu Items Section -->
            <div class="form-section">
                <h2>Menu Items</h2>
                <div class="form-group">
                    <label>Select your items:</label>
                    
                    <!-- Food Items List -->
                    <?php
                   
                        $menu_items = [
    ['id' => 1, 'name' => 'Chicken Biryani', 'price' => 250, 'description' => 'With spiced chicken'],
    ['id' => 2, 'name' => 'Beef Karahi', 'price' => 350, 'description' => 'Spice level: Mild, Medium, Hot'],
    ['id' => 3, 'name' => 'Lassi', 'price' => 50, 'description' => 'Sweet, Salty, or Mango flavor'],
    ['id' => 4, 'name' => 'Chicken Tikka', 'price' => 300, 'description' => 'Served with naan and mint chutney'],
    ['id' => 5, 'name' => 'Haleem', 'price' => 200, 'description' => 'Slow-cooked wheat and meat porridge'],
    ['id' => 6, 'name' => 'Seekh Kabab', 'price' => 280, 'description' => 'Minced meat skewers (2 pieces)'],
    ['id' => 7, 'name' => 'Chana Chaat', 'price' => 120, 'description' => 'Spicy chickpea salad'],
    ['id' => 8, 'name' => 'Nihari', 'price' => 320, 'description' => 'Slow-cooked beef stew'],
    ['id' => 9, 'name' => 'Kheer', 'price' => 100, 'description' => 'Traditional rice pudding'],
    ['id' => 10, 'name' => 'Chicken Roll', 'price' => 150, 'description' => 'Paratha wrap with chicken and sauce']
];
                    
                    
                    foreach ($menu_items as $item) {
                        echo '
                        <div class="food-item" data-id="'.$item['id'].'" data-price="'.$item['price'].'">
                            <div>
                                <div class="food-name">'.$item['name'].' <span class="halal-badge">Halal</span></div>
                                <div class="food-price">'.$item['price'].'</div>
                                <div class="special-requests">'.$item['description'].'</div>
                            </div>
                            <div class="quantity-control">
                                <button type="button" class="quantity-btn minus">-</button>
                                <input type="number" class="quantity-input" name="item['.$item['id'].']" value="0" min="0">
                                <button type="button" class="quantity-btn plus">+</button>
                                <input type="hidden" name="price['.$item['id'].']" value="'.$item['price'].'">
                                <input type="hidden" name="item_name['.$item['id'].']" value="'.$item['name'].'">
                            </div>
                        </div>';
                    }
                    ?>
                </div>
            </div>

            <!-- Payment Section -->
            <div class="form-section">
                <h2>Payment & Final Details</h2>
                <div class="form-group">
                    <label for="payment">Payment Method</label>
                    <select id="payment" name="payment" required>
                        <option value="">-- Select payment method --</option>
                        <option value="cash">Cash on Delivery</option>
                        <option value="card">Credit/Debit Card</option>
                        <option value="jazzcash">JazzCash</option>
                        <option value="easypaisa">EasyPaisa</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="time">Preferred Delivery Time</label>
                    <input type="text" id="time" name="time" placeholder="ASAP or specific time">
                </div>
                <div class="form-group">
                    <label for="notes">Special Requests</label>
                    <textarea id="notes" name="notes" rows="3" placeholder="Allergies, utensils needed, etc."></textarea>
                </div>
            </div>

            <!-- Billing Section -->
            <div class="billing-inbox">
                <div class="billing-title">Your Bill</div>
                <div id="billItems"></div>
                <div class="bill-total">
                    Total Amount: <span id="billTotal">Rs. 0</span>
                </div>
            </div>

            <button type="submit" class="submit-btn" name="sb">Place Order</button>
        </form>
    </div>

    <script src="includes/assets/js/script.js"></script>
</body>
</html>