<?php

@include "config.php";
$message = [];

if (isset($_POST['btn'])) {
    $name = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $pass = $_POST['pass'];
    $cpass = $_POST['cpass'];

    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('Query failed');

    if (mysqli_num_rows($select_users) > 0) {
        $message[] = 'User already exists!';
    } else {
        if ($pass !== $cpass) {
            $message[] = 'Passwords do not match!';
        } else {
            $insert_user = mysqli_query($conn, "INSERT INTO `users` (username, email, passowrd, userlevel) VALUES ('$name', '$email', '$pass', 0)");

            if ($insert_user) {
                $message[] = 'Registered successfully!';
            } else {
                $message[] = 'Registration failed. Please try again.';
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
        <title>Rose - Shop</title>
        <link rel="stylesheet" href="styles.css">
        <link rel="stylesheet" href="shop.css">
        <link rel="stylesheet" href="sign.css">
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
<?php
   if (isset($message) && is_array($message)) {
    foreach ($message as $msg) {
        echo '<div class="message">' . htmlspecialchars($msg) . '</div>';
    }
}
?>
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

    <form action="signup.php" method="post" class="form">
        <h2>SIGN UP</h2>
    <div class="input">
        <div class="username">
            <input type="text" name="username" required>
            <label for ="username">User name </label>
               </div>
        <div class="email">
      <input type="text" name="email" required>
     <label for ="email">Email</label>
        </div>

        <div class="password">
     <input type="password" name="pass" required>
     <label for="password">Password</label>
    </div>
    <div class="password">
        <input type="password" name="cpass" required>
        <label for ="password">Confirm password</label>
           </div>
           <div>
            <a href="log.php">Already Have Account!</a>
           </div>
    </div>
     <button type="submit" name="btn">Sign up</button>
     
     <br>
     
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