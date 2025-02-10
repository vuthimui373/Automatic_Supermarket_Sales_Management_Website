<?php
include 'config.php';

if(isset($_POST['submit'])){
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = md5($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = md5($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $select = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select->execute([$email]);

   if($select->rowCount() > 0){
      $message[] = 'User email already exist!';
   }else{
      if($pass != $cpass){
         $message[] = 'Confirm password not matched!';
      }else{
         $insert = $conn->prepare("INSERT INTO `users`(name, email, password, image) VALUES(?,?,?,?)");
         $insert->execute([$name, $email, $pass, $image]);

         if($insert){
            if($image_size > 2000000){
               $message[] = 'Image size is too large!';
            }else{
               move_uploaded_file($image_tmp_name, $image_folder);
               $message[] = 'Registered successfully!';
               header('location:login.php');
            }
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
   <title>Register</title>

   <!-- Font Awesome CDN -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS -->
   <style>
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
         max-width: 400px;
         text-align: center;
      }

      /* Form heading */
      .form-container h3 {
         font-size: 2rem;
         margin-bottom: 1.5rem;
         font-weight: 600;
         color: #333;
      }

      /* Input box styling */
      .form-container .box {
         width: 80%;
         padding: 1rem 2rem; /* Thêm padding cho các ô nhập liệu */
         margin: 1rem 0;
         border: none;
         border-radius: 8px;
         background: #ffe6f2; /* Soft pink background for inputs */
         color: #333;
         font-size: 1.1rem;
         text-align: center;
      }

      /* Input placeholder styling */
      .form-container .box::placeholder {
         color: #aaa; /* Lighter placeholder color */
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
      }

      .form-container .btn:hover {
         background: linear-gradient(to right, #ff3385, #ff66b2);
         transform: scale(1.05);
      }

      /* Link styling */
      .form-container p {
         margin-top: 1rem;
         font-size: 1rem;
         color: #333;
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
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<section class="form-container">
   <form action="" enctype="multipart/form-data" method="POST">
      <h3>Register Now</h3>
      <input type="text" name="name" class="box" placeholder="Enter your name" required>
      <input type="email" name="email" class="box" placeholder="Enter your email" required>
      <input type="password" name="pass" class="box" placeholder="Enter your password" required>
      <input type="password" name="cpass" class="box" placeholder="Confirm your password" required>
      <input type="file" name="image" class="box" required accept="image/jpg, image/jpeg, image/png">
      <input type="submit" value="Register Now" class="btn" name="submit">
      <p>Already have an account? <a href="login.php">Login Now</a></p>
   </form>
</section>

</body>
</html>
