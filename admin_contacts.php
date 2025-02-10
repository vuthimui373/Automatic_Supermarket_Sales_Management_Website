<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_message = $conn->prepare("DELETE FROM `message` WHERE id = ?");
   $delete_message->execute([$delete_id]);
   header('location:admin_contacts.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>messages</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/admin_style.css">
   <style>
      * {
         font-family: 'Rubik', sans-serif;
         margin: 0; padding: 0;
         box-sizing: border-box;
         outline: none; border: none;
         text-decoration: none;
         color: #333;
      }

      body {
         background-color: #FAF0F6;
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

      .box-container {
         display: grid;
         grid-template-columns: repeat(auto-fit, 33rem);
         gap: 1.5rem;
         justify-content: center;
      }

      .box {
         border: 0.2rem solid #333;
         box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
         background-color: #fff;
         border-radius: 0.5rem;
         padding: 2rem;
      }

      .box p {
         line-height: 1.5;
         padding: 0.5rem 0;
         font-size: 2rem;
         color: #333;
      }

      .box p span {
         color: #f55c7a;
      }

      .delete-btn {
         display: block;
         width: 100%;
         margin-top: 1rem;
         border-radius: 0.5rem;
         background-color: #c13346;
         color: #fff;
         font-size: 2rem;
         padding: 1.3rem 3rem;
         text-transform: capitalize;
         text-align: center;
         cursor: pointer;
      }

      .delete-btn:hover {
         background-color: #333;
      }

      .empty {
         padding: 1.5rem;
         background: #fff;
         color: #c13346;
         border-radius: 0.5rem;
         border: 0.2rem solid #333;
         font-size: 2rem;
         text-align: center;
         box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
         text-transform: capitalize;
      }
   </style>

</head>
<body>

<?php include 'admin_header.php'; ?>

<section class="messages">

   <h1 class="title">Thông báo</h1>

   <div class="box-container">

   <?php
      $select_message = $conn->prepare("SELECT * FROM `message`");
      $select_message->execute();
      if($select_message->rowCount() > 0){
         while($fetch_message = $select_message->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p> ID người dùng : <span><?= $fetch_message['user_id']; ?></span> </p>
      <p> Tên người dùng : <span><?= $fetch_message['name']; ?></span> </p>
      <p> Số điện thoại : <span><?= $fetch_message['number']; ?></span> </p>
      <p> Tài khoản : <span><?= $fetch_message['email']; ?></span> </p>
      <p> Thông báo : <span><?= $fetch_message['message']; ?></span> </p>
      <a href="admin_contacts.php?delete=<?= $fetch_message['id']; ?>" onclick="return confirm('delete this message?');" class="delete-btn">delete</a>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">Bạn chưa có thông báo nào!</p>';
      }
   ?>

   </div>

</section>

<script src="js/script.js"></script>

</body>
</html>