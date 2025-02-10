<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['update_profile'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);

   $update_profile = $conn->prepare("UPDATE `users` SET name = ?, email = ? WHERE id = ?");
   $update_profile->execute([$name, $email, $user_id]);

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
         $update_image->execute([$image, $user_id]);
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
         $update_pass_query->execute([$confirm_pass, $user_id]);
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
   <title>Chỉnh sửa trang cá nhân</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/components.css">
   <style>
   :root{
   --green:#27ae60;
   --red:#e74c3c;
   --black:hsl(306, 48%, 68%);;
   --light-color:#f4dddd;
   --white:#fff;
   --border:.2rem solid var(--black);
   --box-shadow:0 .5rem 1rem rgba(0,0,0,.1);
}

*{
   font-family: 'Rubik', sans-serif;
   margin:0; padding:0;
   box-sizing: border-box;
   outline: none; border:none;
   text-decoration: none;
   color:var(--black);
}

*::selection{
   background-color: var(--green);
   color:var(--white);
}

*::-webkit-scrollbar{
   height: .5rem;
   width: 1rem;
}

*::-webkit-scrollbar-track{
   background-color: transparent;
}

*::-webkit-scrollbar-thumb{
   background-color: var(--green);
}

body{
   background-color: var(--light-color) ;
   /* padding-bottom: 6.5rem; */
}


.btn,
.option-btn{
   display: block;
   width: 100%;
   margin-top: 1rem;
   border-radius: .5rem;
   color:var(--white);
   font-size: 2rem;
   padding:1.3rem 3rem;
   text-transform: capitalize;
   cursor: pointer;
   text-align: center;
}

.btn{
         background-color: var(--red);
      }
      .btn:hover,
      .option-btn:hover{
         background-color: var(--green);
      }

      .flex-btn{
         display: flex;
         flex-wrap: wrap;
         gap:1rem;
      }

      .flex-btn > *{
         flex:1;
      }
      *::-webkit-scrollbar{
         height: .5rem;
         width: 1rem;
      }
      .title{
         text-align: center;
         margin-bottom: 2rem;
         text-transform: uppercase;
         color:var(--red);
         font-size: 3.5rem;
      }
      *::-webkit-scrollbar-track{
         background-color: transparent;
      }

      *::-webkit-scrollbar-thumb{
         background-color: var(--red);
      }

      body{
         background-color: var(--light-color) ;
      }
</style>
</head>
<body>
   
<?php include 'header.php'; ?>

<section class="update-profile">

   <h1 class="title">Chỉnh sửa thông tin</h1>

   <form action="" method="POST" enctype="multipart/form-data">
      <img src="uploaded_img/<?= $fetch_profile['image']; ?>" alt="">
      <div class="flex">
         <div class="inputBox">
            <span style="color:red">Tên :</span>
            <input type="text" name="name" value="<?= $fetch_profile['name']; ?>" placeholder="Chỉnh sửa tên " required class="box">
            <span style="color:red">Email :</span>
            <input type="email" name="email" value="<?= $fetch_profile['email']; ?>" placeholder="Chỉnh sửa email" required class="box">
            <span style="color:red">Thay đổi ảnh :</span>
            <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box">
            <input type="hidden" name="old_image" value="<?= $fetch_profile['image']; ?>">
         </div>
         <div class="inputBox">
            <input type="hidden" name="old_pass" value="<?= $fetch_profile['password']; ?>">
            <span style="color:red">Mật khẩu cũ :</span>
            <input type="password" name="update_pass" placeholder="Nhập mật khẩu cũ" class="box">
            <span style="color:red">Mật khẩu mới:</span>
            <input type="password" name="new_pass" placeholder="Nhập mật khẩu mới" class="box">
            <span style="color:red">Xác nhận mật khẩu mới :</span>
            <input type="password" name="confirm_pass" placeholder="Xác nhận mật khẩu mới" class="box">
         </div>
      </div>
      <div class="flex-btn">
         <input type="submit" class="btn" value="Chỉnh sửa" name="update_profile">
         <a href="home.php" class="option-btn">Quay lại</a>
      </div>
   </form>

</section>










<?php include 'footer.php'; ?>


<script src="js/script.js"></script>

</body>
</html>