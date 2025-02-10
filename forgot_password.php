<?php
    include 'config.php';
    if (isset($_POST['submit'])) {
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);
        $pass = md5($_POST['pass']);
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);
        $cpass = md5($_POST['cpass']);
        $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
        $select = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
        $select->execute([$email]);
        if (!($select->rowCount() > 0)) {
            $message[] = 'Email does not exist!';
        } else {
            if ($pass != $cpass) {
                $message[] = 'Passwords do not match!';
            } else {
                $update = $conn->prepare("UPDATE `users` SET password = ? WHERE email = ?");
                $update->execute([$pass, $email]);
                if ($update) {
                    $message[] = 'Password updated successfully!';
                    header('location: login.php');
                }
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
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        /* General body styling */
        /* General body styling */
body {
    margin: 0;
    padding: 0;
    font-family: 'Poppins', sans-serif;
    background-color: #FAF0F6; /* Light pink background */
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
}

/* Main form container */
.form-container {
    background: rgba(255, 255, 255, 0.8); /* White background with transparency */
    backdrop-filter: blur(15px);
    border-radius: 12px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
    padding: 2rem; /* Increase padding for better appearance */
    width: 100%;
    max-width: 380px;
    text-align: center;
}

/* Form heading */
.form-container h3 {
    font-size: 2rem;
    margin-bottom: 1.5rem;
    font-weight: 600;
    color: #DDA0DD; /* Màu tím sáng cho tiêu đề */
}

/* Input box styling */
.form-container .box {
    width: 80%;
    padding: 1rem;
    margin: 1rem ;
    border: none;
    border-radius: 8px;
    background: #ffe6f2; /* Soft pink background for inputs */
    color: #DDA0DD; /* Màu văn bản trong ô nhập liệu */
    font-size: 1.1rem;
    text-align: center;
}

/* Placeholder text color */
.form-container .box::placeholder {
    color: #DDA0DD; /* Màu tím sáng cho placeholder */
}

/* Submit button styling */
.form-container .btn {
    background: linear-gradient(to right, #ff66b2, #ff3385); /* Pink gradient */
    color: #fff;
    border: none;
    padding: 1rem 2rem;
    margin-top: 1.5rem;
    border-radius: 8px;
    font-size: 1.2rem;
    font-weight: 500;
    cursor: pointer;
    transition: transform 0.3s ease, background 0.3s ease;
    background: linear-gradient(to right, #ff66b2, #ff3385); /* Pink gradient */
         
}

/* Hover effect for submit button */
.form-container .btn:hover {
    background: linear-gradient(to right, #ff3385, #ff66b2);
    transform: scale(1.05);
}

/* Link styling */
.form-container p {
    margin-top: 1rem;
    font-size: 1rem;
    color: #DDA0DD; /* Màu tím sáng cho liên kết */
}

.form-container p a {
    color: #DDA0DD;
    text-decoration: none;
    font-weight: 600;
}

.form-container p a:hover {
    
    color: #ff3385; /* Màu hồng đậm khi hover */
}

/* Notification messages */
.message {
    position: fixed;
    top: 10px;
    right: 10px;
    background: #ff4d4d;
    color: #fff;
    padding: 1rem;
    border-radius: 6px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    animation: fadeIn 0.5s ease-out;
}

.message span {
    font-size: 0.9rem;
}

.message i {
    cursor: pointer;
    margin-left: 10px;
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

    </style>
</head>
<body>
    <?php
        if (isset($message)) {
            foreach ($message as $message) {
                echo '
                <div class="message">
                    <span>' . $message . '</span>
                    <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                </div>
                ';
            }
        }
    ?>
    <section class="form-container">
        <form action="" method="POST">
            <h3>Forgot Password</h3>
            <input type="email" name="email" class="box" placeholder="Enter your email" required>
            <input type="password" name="pass" class="box" placeholder="Enter new password" required>
            <input type="password" name="cpass" class="box" placeholder="Confirm new password" required>
            <input type="submit" value="Reset Password" class="btn" name="submit">
            <p><a href="login.php">Back to Login</a></p>
        </form>
    </section>
</body>
</html>
