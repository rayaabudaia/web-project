<?php
@include 'config.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $user_name = $conn->real_escape_string($_POST['username']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    $city = $conn->real_escape_string($_POST['city']);
    $totalquantity = isset($_POST['totalquantity']) ? (int)$_POST['totalquantity'] : 0; 
    $totalprice = isset($_POST['totalprice']) ? (float)$_POST['totalprice'] : 0.0;
    $message = $conn->real_escape_string($_POST['message']);
  
    if(empty($user_name) || empty($phone) || empty($address) || empty($city)) {
        die("One or more fields are empty. Please go back and fill in all required fields.");
    }

    $sql = "INSERT INTO orders (username, phone, address, city, quantity, price, message) 
            VALUES ('$user_name', '$phone', '$address', '$city', $totalquantity, $totalprice, '$message')";

    if ($conn->query($sql) === TRUE) {
        $order_id = $conn->insert_id; 

        if(isset($_COOKIE['listCart'])) {
            $listCart = json_decode($_COOKIE['listCart'], true);

            if ($listCart !== null && is_array($listCart)) {
                foreach ($listCart as $item) {
                    if (isset($item['id'], $item['name'], $item['price'], $item['image'], $item['quantity'])) {
                        $product_id = (int)$item['id']; 
                        $product_name = $conn->real_escape_string($item['name']);
                        $product_price = (float)$item['price'];
                        $product_image = $conn->real_escape_string($item['image']);
                        $product_quantity = (int)$item['quantity']; 

                        $sql_item = "INSERT INTO order_items (order_id, product_id, product_name, quantity, price, image) VALUES ($order_id, $product_id, '$product_name', $product_quantity, $product_price, '$product_image')";
                        if (!$conn->query($sql_item)) {
                            echo "Error inserting item: " . $conn->error; 
                        }
                    } 
                }

                // Clear the cart cookie
                setcookie("listCart", "", time() - 3600, "/");
            } 
            else 
            {
                echo "Error decoding cart JSON or cart is not an array.";
            }
        }
        
        // Display success message
        echo 'Order placed successfully! الدفع عند الاستلام';
        
    } else {
        echo 'Error submitting the order!';
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Rose - Shop</title>
        <link rel="stylesheet" href="styles.css">
        <script src="https://unpkg.com/scrollreveal"></script>
        <link rel="stylesheet" href="shop.css">
        <link rel="icon" href="/images/lelas-logo.png" type="image/png">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Acme&family=Rowdies:wght@300;400;700&display=swap" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script defer src="script.js"></script>
        <script defer src="check.js"></script>
    </head>
<body>
    <header id="header">
        <input type="checkbox"id="check">
        <label for="check" <i class="fa-solid fa-bars"></i></label>
        <div class="logo"> <a href="index.php"><img src="/images/lelas2.png" alt="" ></a>
        </div>
        <nav>
        <ul>
        <li><a href="index.php"><i ></i>Home</a></li>
        <li><a href="about.html">About</a></li>
        <li><a href="signup.php"><i ></i> Sign up</a></li>
        <li><a href="log.php" ><i ></i> Log in </a></li>
        </ul>
        </nav>
        <div class="icons"> 
        <a href="profile.php"><i class="fa-regular fa-user"></i></a>
        <div class="qcart">
        <div class="cquantity">0</div>
        <a href="#" class="iconCart"><i class="fa-solid fa-cart-shopping"></i></a> 
        </div>
    </div>
    </header>
    <div class="line"></div> 
    
<div id="messageBox" class="message-box" style="display: none;"></div>
    <div class="container">
        <div class="checkoutLayout">
            <div class="returnCart">
                <a href="shop.html">Keep Shopping</a>
                <p>List product in Cart</p>
                <pre>_________________________________</pre>
                <div class="list">
                    <img src="${product.image}" alt="">
                    <div class="info">
                        <div class="name">${product.name}</div>
                        <div class="price">${product.price}₪ / ${product.quantity} product(s)</div>
                    </div>
                    <div class="quantity">${product.quantity}</div>
                    <div class="returnPrice">${product.price * product.quantity}₪</div>
                </div>
            </div>
            <div class="right">
                <p>CHECKOUT</p>
                <div class="form">
                <form method="POST" action="checkout.php">
                    <div class="group">
                        <label for="">Full Name</label>
                        <input type="text" name="username" id="" required>
                    </div>
                    <div class="group">
                        <label for="">Phone Number</label>
                        <input type="text" name="phone" id="" required>
                    </div>
                    <div class="group">
                        <label for="">Address</label>
                        <input type="text" name="address" id="" required>
                    </div>
                    <div class="group">
                        <label for="">City</label>
                        <select name="city" id="" required>
                            <option value="Qalqilia">Qalqilia</option>
                            <option value="Nablus">Nablus</option>
                            <option value="Ramallah">Ramallah</option>
                            <option value="Tulkarem">Tulkarem</option>
                            <option value="Jenin">Jenin</option>
                            <option value="Hebron">Hebron</option>
                            <option value="Jereco">Jereco</option>
                            <option value="Salfeet">Salfeet</option>
                        </select>
                    </div> 
                    <div class="letter">
                    <label for="message">Add a letter/Message</label>
                    <textarea name="message" ></textarea>
                    </div>
                    <div class="row">
                    <label for="totalquantity">total Quantity</label>
                    <input type="text" class="totalQuantity" name="totalquantity" value="0" readonly>
                    </div>
                    <div class="row">
                    <label for="totalprice">total Price</label>
                    <input type="text" class="totalPrice" name="totalprice" value="0₪" readonly>
                     </div>
                    <button type="submit" class="buttonCheckout" name="submit_order">Checkout</button>
                </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function submitForm() {
            const listCart = JSON.parse(decodeURIComponent(document.cookie.split('; ').find(row => row.startsWith('listCart=')).split('=')[1]));

            let totalQuantity = 0;
            let totalPrice = 0;

            listCart.forEach(item => {
                totalQuantity += item.quantity;
                totalPrice += item.price * item.quantity;
            });

            document.getElementById('totalquantity').value = totalQuantity;
            document.getElementById('totalprice').value = totalPrice;

            return true;
        }
    </script>

    <div class="cart">
        <h2>Cart</h2>
        <div class="listCart">
        </div>
    
        <div class="buttons">
            <div class="close">Close</div>
            <div class="checkout">
                <a href="checkout.php">Checkout</a>
            </div>
        </div>
    </div>

    
    <div class ="social" >
        <p class="contact"> contact us:</p>
        <div class="info">
        <p><i class="fa-regular fa-envelope"></i> raya662003@gmail</p>
        <p><i class="fa-brands fa-square-whatsapp"></i> +972 597502688</p>
    
    <a href="https://www.instagram.com/raya.abudaia" class="a1" target="_blank"><i class="fa-brands fa-instagram"></i></a>
    <a href="https://www.facebook.com/raya.abudaia.5/" id="a2" target="_blank""<i class="fa-brands fa-facebook-f"></i></a>
    <a href="#" target="_blank" class="a3"><i class="fa-brands fa-twitter"></i></a>
        </div>
        <div class="copy">
        <img src="/images/lelas-logo.png" alt="">
        <p>&copy; 2024 LEELAS. All rights reserved.</p>
        </div>
        <script>
            ScrollReveal({
             reset: false,
             distance: '100px',
             duration: 2500,
             delay: 100
            });
            ScrollReveal().reveal('.right', { delay: 50 });
            ScrollReveal().reveal('.container', { delay: 50 ,origin:'left'});
        
           
            </script>
    </body>
    </html>