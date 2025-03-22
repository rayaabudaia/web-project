<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'leelas_store') or die('connection failed');

if (!isset($_SESSION['user_email'])) {
    header('Location: log.php');
    exit();
}

$email = $_SESSION['user_email'];

if (isset($_POST['update'])) {
    $new_username = mysqli_real_escape_string($conn, $_POST['username']);
    $new_email = mysqli_real_escape_string($conn, $_POST['email']);
    $new_password = mysqli_real_escape_string($conn, sha1($_POST['new_password']));
    $confirm_password = mysqli_real_escape_string($conn, sha1($_POST['confirm_password']));


    if ($new_password != $confirm_password) {
        $message = "Passwords do not match!";
    } else {
 
        $update_query = "UPDATE users SET username='$new_username', email='$new_email', passowrd='$new_password' WHERE email='$email'";
        if (mysqli_query($conn, $update_query)) {
            $message = "Profile updated successfully!";
            $_SESSION['user_name'] = $new_username;
            $_SESSION['user_email'] = $new_email;
            $email = $new_email;
        } else {
            $message = "Error updating profile: " . mysqli_error($conn);
        }  
    }
 
}
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: log.php');
    exit();
}

$user_query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'") or die('Query failed');
$user_data = mysqli_fetch_assoc($user_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="loginstyle.css">
    <link rel="icon" href="/images/lelas-logo.png" type="">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="profileStyle.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>
</head>
<body>
    <header id="header">
        <input type="checkbox" id="check">
        <label for="check"><i class="fa-solid fa-bars"></i></label>
        <div class="logo"><a href="#index.php"><img src="/images/lelas2.png" alt=""></a></div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="signup.php">Sign up</a></li>
                <li><a href="log.php">Log in</a></li>
            </ul>
        </nav>
        <div class="icons">
            <a href="profile.php"><i class="fa-regular fa-user"></i></a>
            <div class="qcart">
                <div class="cquantity">0</div>
                <a href="#"><i class="fa-solid fa-cart-shopping"></i></a> 
            </div>
        </div>
    </header>

    <?php
    if (isset($message)) {
        echo '<div class="message">' . $message . '</div>';
    }
    ?>

    <div class="profile-container">
        <h2>User Profile</h2>
        <?php if (isset($message)) { echo "<p class='message'>$message</p>"; } ?>
        <form action="profile.php" method="post">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" name="username" value="<?php echo $user_data['username']; ?>" required>
            </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" name="email" value="<?php echo $user_data['email']; ?>" required>
            </div>
            <div class="input-group">
                <label for="new_password">New Password</label>
                <input type="password" name="new_password" placeholder="Enter new password">
            </div>
            <div class="input-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" name="confirm_password" placeholder="Confirm new password">
            </div>
            <div class="buttons">
                <button type="submit" name="update">Update Profile</button>
                <button type="submit" name="logout">Logout</button>
            </div>
        </form>
    </div>

    <div class="social">
        <p class="contact">Contact us:</p>
        <div class="info">
            <p><i class="fa-regular fa-envelope"></i> raya662003@gmail</p>
            <p><i class="fa-brands fa-square-whatsapp"></i> +972 597502688</p>
            <a href="https://www.instagram.com/raya.abudaia" class="a1" target="_blank"><i class="fa-brands fa-instagram"></i></a>
            <a href="https://www.facebook.com/raya.abudaia.5/" id="a2" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="#" target="_blank" class="a3"><i class="fa-brands fa-twitter"></i></a>
        </div>
        <div class="copy">
            <img src="/images/lelas-logo.png" alt="">
            <p>&copy; 2024 LEELAS. All rights reserved.</p>
        </div>
    </div>

</body>
</html>
