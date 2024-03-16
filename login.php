<?php
include 'config.php';
session_start();

if (isset($_POST['submit'])) {
    // Check if the connection is established
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Escape user inputs for security
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));

    // Check if the username or email already exists
    $check_query = "SELECT * FROM `users` WHERE username = '$username' OR email = '$email'";
    $check_result = mysqli_query($conn, $check_query);
    if (mysqli_num_rows($check_result) > 0) {
        $message = "Username or email already exists!";
    } else {
        // Insert user data into the database
        $insert_query = "INSERT INTO `users` (username, email, password) VALUES ('$username', '$email', '$password')";
        if (mysqli_query($conn, $insert_query)) {
            $message = "User registered successfully!";
            header('Location: login.php'); // Redirect to login page after successful registration
            exit();
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
    input {
        text-align: center;
    }
    </style>
</head>

<body>
    <?php
    if (isset($message)) {
        echo '<div class="message" onclick="this.remove();">' . $message . '</div>';
    }
    ?>

    <div class="form-container">
        <form action="" method="post">
            <h3>تسجيل حساب جديد</h3>
            <input type="text" name="username" required placeholder="اسم المستخدم" class="box">
            <input type="email" name="email" required placeholder="البريد الالكتروني" class="box">
            <input type="password" name="password" required placeholder="كلمة المرور" class="box">
            <input type="submit" name="submit" class="btn" value="تسجيل">
            <p>هل لديك حساب بالفعل؟ <a href="login.php"> تسجيل الدخول</a></p>
        </form>
    </div>
    <p>Developed By Youssef</p>
</body>

</html>