<?php
@include 'config.php';

session_start();

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = md5($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    $sql = "SELECT * FROM `users` WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email, $pass]);
    $rowCount = $stmt->rowCount();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($rowCount > 0) {
        if ($row['user_type'] == 'admin') {
            $_SESSION['admin_id'] = $row['id'];
            header('location:admin_page.php');
        } elseif ($row['user_type'] == 'user') {
            $_SESSION['user_id'] = $row['id'];
            header('location:home.php');
        } else {
            $message[] = 'No user found!';
        }
    } else {
        $message[] = 'Incorrect email or password!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- Custom CSS -->
    <style>
        /* General reset */
        body, html {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
            background: url('images/login.jpg') no-repeat center center/cover;

            background-size: 100%; /* Đảm bảo phủ kín toàn bộ vùng */
            color: #333;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Notification styles */
        .message {
            position: fixed;
            top: 20px;
            right: 20px;
            background: rgba(255, 69, 58, 0.9);
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 10px;
            animation: fadeIn 0.5s ease-out, fadeOut 0.5s ease-in 4.5s;
        }

        .message i {
            font-size: 1.5rem;
            cursor: pointer;
        }

        .message span {
            font-size: 1rem;
            flex: 1;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: translateY(0);
            }
            to {
                opacity: 0;
                transform: translateY(-20px);
            }
        }

        /* Form styles */
        .form-container {
            background: rgba(255, 255, 255, 0.9); /* Nền trắng trong suốt */
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .form-container h3 {
            margin-bottom: 1.5rem;
            font-size: 1.8rem;
            color: #333;
        }

        .form-container .box, .form-container .btn {
            width: 100%;
            padding: 15px;
            margin-bottom: 1rem;
            border-radius: 5px;
            font-size: 1rem;
            border: 1px solid #ddd;
            color: #555;
            box-sizing: border-box;
        }

        .form-container .box:focus {
            border-color: #ff66b2; /* Màu hồng khi focus */
            outline: none;
        }

        .form-container .btn {
            background: #DDA0DD; /* Màu hồng cho nút */
            color: #fff;
            border: none;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        .form-container .btn:hover {
            background: #ff3385; /* Màu hồng đậm khi hover */
        }

        .form-container p {
            margin: 0.5rem 0;
            font-size: 0.9rem;
            color: #555;
        }

        .form-container a {
            color: #DDA0DD;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .form-container a:hover {
            color: #ff3385; /* Màu hồng đậm khi hover */
        }
    </style>
</head>
<body>

<?php
if (isset($message)) {
    foreach ($message as $message) {
        echo '
        <div class="message">
            <i class="fas fa-exclamation-circle"></i>
            <span>' . $message . '</span>
            <i class="fas fa-times" onclick="this.parentElement.style.display=`none`;"></i>
        </div>
        ';
    }
}
?>
   
<section class="form-container">
    <form action="" method="POST">
        <h3>Login Now</h3>
        <input type="email" name="email" class="box" placeholder="Enter your email" required>
        <input type="password" name="pass" class="box" placeholder="Enter your password" required>
        <input type="submit" value="Login Now" class="btn" name="submit">
        <p><a href="forgot_password.php">Forgot Password?</a></p>
        <p>Don't have an account? <a href="register.php">Register Now</a></p>
    </form>
</section>

</body>
</html>
