<?php
@include "config.php";
session_start();
$error_message = '';

if (isset($_POST["email"]) && isset($_POST["pass"])) {
    $l = trim($_POST["email"]);
    $p = trim($_POST["pass"]);

    if (!empty($l) && !empty($p)) {
        if (filter_var($l, FILTER_VALIDATE_EMAIL)) {
            try {
                $con = new mysqli('localhost', 'root', '', 'leelas_store');

                if ($con->connect_error) {
                    die("Connection failed: " . $con->connect_error);
                }

                $stmt = $con->prepare("SELECT * FROM users WHERE email = ?");
                $stmt->bind_param('s', $l);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    
                    if ($p==$row['passowrd']) {
                        $_SESSION['user_name'] = $row['username'];
                        $_SESSION['useremail'] = $row['email'];
                        $_SESSION['user_level'] = $row['userlevel']; 

                        if ($row['userlevel'] == 0) {
                            header('location:shop.html');
                        } elseif ($row['userlevel'] == 1) {
                            header('location:admin_orders.php');
                        }
                        exit();
                    } else {
                        $error_message = 'Email and/or password not correct! Try again.';
                    }
                } else {
                    $error_message = 'Email and/or password not correct! Try again.';
                }

                $stmt->close();
                $con->close();
            } catch (Exception $ex) {
                $error_message = 'An error occurred: ' . $ex->getMessage();
            }
        } else {
            $error_message = 'Invalid email format! Please enter a valid email address.';
        }
    } else {
        $error_message = 'Email and password cannot be empty!';
    }
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Rose - Shop</title>
        <link rel="stylesheet" href="styles.css">
        <link rel="stylesheet" href="shop.css">
        <link rel="stylesheet" href="loginstyle.css">
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

    <form action="log.php" method="POST" class="form">
        <h2>LOGIN</h2>
    <div class="input">
        <div class="email">
     <input type="text" id="useremail" name="email" required>
     <label for ="useremail">Email</label>
        </div>
        <div class="password">
     <input type="password" id="passowrd" name="pass" required>
     <label for="passowrd">Password</label>
    </div>
    </div> 

         <?php if (!empty($error_message)): ?>
            <h2 style="color:red; font-size: 0.8em; position:relative; top:20px;" ><?= $error_message; ?></h2>
        <?php endif; ?>
        
     <input type="submit" name="submit" value="LOGIN">
     <br>
     <a href="signup.php">Don't have account?</a>
    </form>

    <div class="cart">
        <h2>Cart</h2>
        <div class="listCart">
        </div>
    
        <div class="buttons">
            <div class="close">Close</div>
            <div class="checkout">
                <a href="checkout.html">Checkout</a>
            </div>
        </div>
    </div>

    <div class ="social" >
        <p class="contact"> contact us:</p>
        <div class="info">
        <p><i class="fa-regular fa-envelope"></i>raya662003@gmail</p>
        <p><i class="fa-brands fa-square-whatsapp"></i> +972 597502688</p>
    
    <a href="https://www.instagram.com/raya.abudaia" class="a1" target="_blank"><i class="fa-brands fa-instagram"></i></a>
    <a href="https://www.facebook.com/raya.abudaia.5/" id="a2" target="_blank""<i class="fa-brands fa-facebook-f"></i></a>
    <a href="#" target="_blank" class="a3"><i class="fa-brands fa-twitter"></i></a>
        </div>
        <div class="copy">
            <img src="/images/lelas-logo.png" alt="">
            <p>&copy; 2024 LEELAS. All rights reserved.</p>
            </div>

    
</body>
</html>