<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['update_profile'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);

   $update_profile = $conn->prepare("UPDATE `users` SET name = ?, email = ? WHERE id = ?");
   $update_profile->execute([$name, $email, $admin_id]);

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;
   $old_image = $_POST['old_image'];

   if(!empty($image)){
      if($image_size > 2000000){
         $message[] = 'image size is too large!';
      }else{
         $update_image = $conn->prepare("UPDATE `users` SET image = ? WHERE id = ?");
         $update_image->execute([$image, $admin_id]);
         if($update_image){
            move_uploaded_file($image_tmp_name, $image_folder);
            unlink('uploaded_img/'.$old_image);
            $message[] = 'image updated successfully!';
         };
      };
   };

   $old_pass = $_POST['old_pass'];
   $update_pass = md5($_POST['update_pass']);
   $update_pass = filter_var($update_pass, FILTER_SANITIZE_STRING);
   $new_pass = md5($_POST['new_pass']);
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $confirm_pass = md5($_POST['confirm_pass']);
   $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

   if(!empty($update_pass) AND !empty($new_pass) AND !empty($confirm_pass)){
      if($update_pass != $old_pass){
         $message[] = 'old password not matched!';
      }elseif($new_pass != $confirm_pass){
         $message[] = 'confirm password not matched!';
      }else{
         $update_pass_query = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
         $update_pass_query->execute([$confirm_pass, $admin_id]);
         $message[] = 'password updated successfully!';
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
   <title>update admin profile</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/admin_style.css">
   <!-- custom css file link  -->
   <!-- <link rel="stylesheet" href="css/components.css"> -->
   <style>
     

* {
   font-family: 'Rubik', sans-serif;
   margin: 0; padding: 0;
   box-sizing: border-box;
   outline: none; border: none;
   text-decoration: none;
   color: #333;
}

*::selection {
   background-color: #f55c7a;
   color: #fff;
}

body {
   background-color: #FAF0F6; /* Đã thay đổi nền sang màu mới */
}

html {
   font-size: 62.5%;
   overflow-x: hidden;
   scroll-behavior: smooth;
}

section {
   padding: 3rem 2rem;
   max-width: 1200px;
   margin: 0 auto;
}

.title {
   text-align: center;
   margin-bottom: 2rem;
   text-transform: uppercase;
   color: #f55c7a;
   font-size: 3.5rem;
}

.update-profile form {
   max-width: 70rem;
   margin: 0 auto;
   background-color: #fff;
   box-shadow: 0 .5rem 1rem rgba(0,0,0,.1);
   border: .2rem solid #333;
   border-radius: .5rem;
   padding: 2rem;
   text-align: center;
}

.update-profile form .flex {
   display: flex;
   gap: 1.5rem;
   justify-content: space-between;
}

.update-profile form img {
   height: 20rem;
   width: 20rem;
   margin-bottom: 1rem;
   border-radius: 50%;
   object-fit: cover;
}

.update-profile form .inputBox {
   text-align: left;
   width: 49%;
}

.update-profile form .inputBox span {
   display: block;
   padding-top: 1rem;
   font-size: 1.8rem;
   color: #808080;
}

.update-profile form .inputBox .box {
   width: 100%;
   padding: 1.2rem 1.4rem;
   font-size: 1.8rem;
   color: #333;
   border: .2rem solid #333;
   border-radius: .5rem;
   margin: 1rem 0;
   background-color: #f6f6f6;
}

.flex-btn {
   display: flex;
   gap: 1rem;
}

.flex-btn > * {
   flex: 1;
}

@media (max-width: 768px) {
   .update-profile form .flex {
      flex-wrap: wrap;
      gap: 0;
   }

   .update-profile form .flex .inputBox {
      width: 100%;
   }
}

@media (max-width: 450px) {
   html {
      font-size: 50%;
   }

   .flex-btn {
      flex-flow: column;
      gap: 0;
   }

   .title {
      font-size: 3rem;
   }
}

   </style>

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="update-profile">

   <h1 class="title">Cập nhật hồ sơ</h1>

   <form action="" method="POST" enctype="multipart/form-data">
      <img src="uploaded_img/<?= $fetch_profile['image']; ?>" alt="">
      <div class="flex">
         <div class="inputBox">
            <span>Tên người dùng :</span>
            <input type="text" name="name" value="<?= $fetch_profile['name']; ?>" placeholder="cập nhật tên người dùng" required class="box">
            <span>Email :</span>
            <input type="email" name="email" value="<?= $fetch_profile['email']; ?>" placeholder="update email" required class="box">
            <span>Chọn hình :</span>
            <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box">
            <input type="hidden" name="old_image" value="<?= $fetch_profile['image']; ?>">
         </div>
         <div class="inputBox">
            <input type="hidden" name="old_pass" value="<?= $fetch_profile['password']; ?>">
            <span>Mật khẩu cũ :</span>
            <input type="password" name="update_pass" placeholder="enter previous password" class="box">
            <span>Mật khẩu mới :</span>
            <input type="password" name="new_pass" placeholder="enter new password" class="box">
            <span>Xác nhận mật khẩu :</span>
            <input type="password" name="confirm_pass" placeholder="confirm new password" class="box">
         </div>
      </div>
      <div class="flex-btn">
         <input type="submit" class="btn" value="Cập nhật" name="update_profile">
         <a href="admin_page.php" class="option-btn">Trở lạik</a>
      </div>
   </form>

</section>













<script src="js/script.js"></script>

</body>
</html>