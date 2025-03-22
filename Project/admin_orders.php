<?php
session_start();
@include 'config.php';
$sql = "SELECT * FROM orders JOIN order_items ON orders.id = order_items.order_id ORDER BY orders.id DESC";
$result = $conn->query($sql);

$orders = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $order_id = $row['order_id'];

        if (!isset($orders[$order_id])) {
            $orders[$order_id] = [
                'username' => $row['username'],
                'phone' => $row['phone'],
                'address' => $row['address'],
                'city' => $row['city'],
                'totalquantity' => 0, // Initialize to 0
                'totalprice' => 0,    // Initialize to 0
                'DATE' => $row['DATE'],
                'message' => $row['message'],
                'items' => []
            ];
        }

        $orders[$order_id]['totalquantity'] += $row['quantity'];
        $orders[$order_id]['totalprice'] += $row['price'] * $row['quantity'];

        $orders[$order_id]['items'][] = [
            'product_id' => $row['product_id'],
            'product_name' => $row['product_name'],
            'quantity' => $row['quantity'],
            'price' => $row['price'],
            'image' => $row['image']
        ];
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Rose - Shop</title>
        <link rel="stylesheet" href="styles.css">
        <link rel="stylesheet" href="shop.css">
        <link rel="stylesheet" href="admin.css">

        <script src="https://unpkg.com/scrollreveal"></script>
        <link rel="icon" href="/images/lelas-logo.png" type="image/png">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Acme&family=Rowdies:wght@300;400;700&display=swap" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script defer src="script.js"></script>
        <script defer src="check.js"></script>
        <style>

 button {
    background-color: #ff4d4d;
    color: white;
    border: none; 
    border-radius: 10px; 
    padding: 10px 20px; 
    font-size: 16px; 
    cursor: pointer;
    transition: background-color 0.3s ease; 
    margin-top: 10px; 
    font-family: "Montserrat", sans-serif;
}

button:hover {
    background-color: #e60000; 
}

button:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(255, 77, 77, 0.5); 
}

        </style>
    </head>
<body>
    <header id="header">
        <div class="logo"> <a href="index.php"><img src="/images/lelas2.png" alt="" ></a>
        </div>
        <nav>
        <ul>
        <li><a href="logout.php" ><i ></i> Log out </a></li>
        </ul>
        </nav>
    </header>
<body>
<div class="admin-orders">
    <?php foreach ($orders as $id => $order): ?>
        <div class="order" id="order-<?php echo htmlspecialchars($id); ?>">
            <h2>Order #<?php echo htmlspecialchars($id); ?></h2>
            <p>Name: <?php echo htmlspecialchars($order['username']); ?></p>
            <p>Phone: <?php echo htmlspecialchars($order['phone']); ?></p>
            <p>Address: <?php echo htmlspecialchars($order['address']); ?></p>
            <p>City: <?php echo htmlspecialchars($order['city']); ?></p>
            <p>Total Quantity: <?php echo htmlspecialchars($order['totalquantity']); ?></p>
            <p>Total Price: <?php echo htmlspecialchars($order['totalprice']); ?>₪</p>
            <p>Order Date: <?php echo htmlspecialchars($order['DATE']); ?></p>
            <p>Message: <?php echo htmlspecialchars($order['message']); ?></p>

            <form action="delete_order.php" method="post" onsubmit="removeOrderFromPage('<?php echo htmlspecialchars($id); ?>'); return confirm('Are you sure you want to delete this order?');">
                <input type="hidden" name="orderId" value="<?php echo htmlspecialchars($id); ?>">
                <button type="submit">Remove Order</button>
            </form>
            
            <div class="order-items">
                <?php foreach ($order['items'] as $item): ?>
                    <div class="order-item">
                        <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>">
                        <div class="item-info">
                            <p>Name: <?php echo htmlspecialchars($item['product_name']); ?></p>
                            <p>Quantity: <?php echo htmlspecialchars($item['quantity']); ?></p>
                            <p>Price: <?php echo htmlspecialchars($item['price']); ?>₪</p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script>
function removeOrderFromPage(orderId) {
    var orderElement = document.getElementById('order-' + orderId);
    if (orderElement) {
        orderElement.style.display = 'none'; 
    }
}
</script>


</body>
</html>
