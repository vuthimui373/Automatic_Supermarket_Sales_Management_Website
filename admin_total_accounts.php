<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_users = $conn->prepare("DELETE FROM `users` WHERE id = ?");
   $delete_users->execute([$delete_id]);
   header('location:admin_users.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>users</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/admin_style.css">
   <style>
      
* {
    font-family: 'Rubik', sans-serif;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    outline: none;
    border: none;
    text-decoration: none;
    color: #333; /* thay cho --black */
}

*::selection {
    background-color: #f55c7a; /* thay cho --green */
    color: #fff; /* thay cho --white */
}

body {
   background-color: #FAF0F6;
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
    color: #f55c7a; /* thay cho --green */
    font-size: 3.5rem;
}

.user-accounts .box-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, 33rem);
    gap: 1.5rem;
    align-items: flex-start;
    justify-content: center;
}

.user-accounts .box-container .box {
    border: .2rem solid #333; /* thay cho --border */
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.1); /* thay cho --box-shadow */
    background-color: #fff; /* thay cho --white */
    border-radius: .5rem;
    padding: 2rem;
    text-align: center;
}

.user-accounts .box-container .box img {
    height: 15rem;
    width: 15rem;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 1rem;
}

.user-accounts .box-container .box p {
    line-height: 1.5;
    padding: .5rem 0;
    font-size: 2rem;
    color: #333; /* thay cho --black */
}

.user-accounts .box-container .box p span {
   color: #f55c7a; /* thay cho --green */
}
.delete-btn {
    display: block;
    width: 100%;
    margin-top: 1rem;
    border-radius: .5rem;
    background-color: #c13346; /* thay cho --red */
    color: #fff; /* thay cho --white */
    font-size: 2rem;
    padding: 1.3rem 3rem;
    text-transform: capitalize;
    cursor: pointer;
    text-align: center;
}

.delete-btn:hover {
    background-color: #333; /* thay cho --black */
}

@media (max-width: 450px) {
    .user-accounts .box-container {
        grid-template-columns: 1fr;
    }
}

   </style>

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="user-accounts">

   <h1 class="title">QUẢN LÝ TÀI KHOẢN </h1>

   <div class="box-container">

      <?php
         $select_users = $conn->prepare("SELECT * FROM `users`");
         $select_users->execute();
         while($fetch_users = $select_users->fetch(PDO::FETCH_ASSOC)){
      ?>
      <div class="box">
         <img src="uploaded_img/<?= $fetch_users['image']; ?>" alt="">
         <p> ID : <span><?= $fetch_users['id']; ?></span></p>
         <p> Tên người dùng : <span><?= $fetch_users['name']; ?></span></p>
         <p> Email : <span><?= $fetch_users['email']; ?></span></p>
         <p> Loại tài khoản : <span style=" color:<?php if($fetch_users['user_type'] == 'admin'){ echo 'orange'; }; ?>"><?= $fetch_users['user_type']; ?></span></p>
         <a href="admin_users.php?delete=<?= $fetch_users['id']; ?>" onclick="return confirm('delete this user?');" class="delete-btn">delete</a>
      </div>
      <?php
      }
      ?>
   </div>

</section>


<script src="js/script.js"></script>

</body>
</html>