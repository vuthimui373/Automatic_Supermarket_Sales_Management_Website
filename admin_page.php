<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <!-- custom css file link  -->
   <!-- <link rel="stylesheet" href="css/components.css"> -->
   <link rel="stylesheet" href="css/admin_style.css">
   <style>
     

body {
    background: linear-gradient(to bottom, #ffe4f3, #fffafc); /* Hồng sáng nhạt dần xuống */
    font-family: 'Rubik', sans-serif;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html {
    font-size: 62.5%;
    scroll-behavior: smooth;
    scroll-padding-top: 6.5rem;
}

section {
    padding: 3rem 2rem;
    max-width: 1200px;
    margin: 0 auto;
}

.btn {
    display: block;
    width: 100%;
    margin-top: 1rem;
    margin-bottom: 1rem;
    border-radius: .5rem;
    color: white; /* Light button text color */
    font-size: 2rem;
    padding: 1.3rem 3rem;
    text-transform: capitalize;
    cursor: pointer;
    text-align: center;
    background-color: #f55c7a; /* Green from :root */
}

.btn:hover {
    background-color: #333; /* Black from :root */
}

.title {
    text-align: center;
    margin-bottom: 2rem;
    text-transform: uppercase;
    color: #f55c7a; /* Green from :root */
    font-size: 3.5rem;
}

.message {
    position: sticky;
    top: 0;
    max-width: 1200px;
    margin: 0 auto;
    background-color: #f6f6f6; /* Light background from :root */
    padding: 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.5rem;
    z-index: 10000;
}

.message span {
    font-size: 2rem;
    color: #333; /* Black from :root */
}

.footer {
    background-color: #fff; /* White from :root */
}

.footer .credit {
    margin-top: 2rem;
    padding: 2rem 1.5rem;
    text-align: center;
    font-size: 2rem;
    color: #333; /* Black from :root */
}

.footer .credit span {
    color: #f55c7a; /* Green from :root */
}
.dashboard .box-container .box p {
    font-size: 2rem;
    color: #333; /* Màu chữ */
    margin: 2rem 0; /* Căn lề trên và dưới */
    padding: 0; /* Bỏ khoảng cách bên trong */
    background: none; /* Không có nền */
    border: none; /* Không có viền */
    border-radius: 0; /* Không bo góc */
}

.dashboard .box-container  {
    
    margin: 2rem 0; /* Căn lề trên và dưới */
    
}


@media (max-width: 991px) {
    html {
        font-size: 55%;
    }
}

@media (max-width: 768px) {
    .header .navbar {
        display: none;
    }
}


   </style>

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="dashboard">

   <h1 class="title">Bảng điều khiển</h1>

   <div class="box-container">

      <div class="box">
      <?php
         $total_pendings = 0;
         $select_pendings = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
         $select_pendings->execute(['pending']);
         while($fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC)){
            //$total_pendings += $fetch_pendings['total_price'];
            $total_pendings+=1;
         };
      ?>
      <h3><?= $total_pendings; ?></h3>
      <p>Tổng đơn chưa thanh toán</p>
      <a href="admin_orders.php" class="btn">Xem đơn hàng</a>
      </div>

      <div class="box">
      <?php
         $total_completed = 0;
         $select_completed = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
         $select_completed->execute(['completed']);
         while($fetch_completed = $select_completed->fetch(PDO::FETCH_ASSOC)){
            //$total_completed += $fetch_completed['total_price'];
            $total_completed+=1;
         };
      ?>
      <h3><?= $total_completed; ?></h3>
      <p>Đơn đã hoàn tất</p>
      <a href="admin_orders.php" class="btn">Xem đơn hàng</a>
      </div>

      <div class="box">
      <?php
         $select_orders = $conn->prepare("SELECT * FROM `orders`");
         $select_orders->execute();
         $number_of_orders = $select_orders->rowCount();
      ?>
      <h3><?= $number_of_orders; ?></h3>
      <p>Đơn đã đặt</p>
      <a href="admin_orders.php" class="btn">Xem đơn hàng</a>
      </div>

      <div class="box">
      <?php
         $select_products = $conn->prepare("SELECT * FROM `products`");
         $select_products->execute();
         $number_of_products = $select_products->rowCount();
      ?>
      <h3><?= $number_of_products; ?></h3>
      <p>Sản phẩm đã thêm</p>
      <a href="admin_products.php" class="btn">Xem sản phẩm</a>
      </div>

      <div class="box">
      <?php
         $select_users = $conn->prepare("SELECT * FROM `users` WHERE user_type = ?");
         $select_users->execute(['user']);
         $number_of_users = $select_users->rowCount();
      ?>
      <h3><?= $number_of_users; ?></h3>
      <p>Số lượng người dùng</p>
      <a href="admin_users.php" class="btn">Xem tài khoản</a>
      </div>

      <div class="box">
      <?php
         $select_admins = $conn->prepare("SELECT * FROM `users` WHERE user_type = ?");
         $select_admins->execute(['admin']);
         $number_of_admins = $select_admins->rowCount();
      ?>
      <h3><?= $number_of_admins; ?></h3>
      <p>Số lượng quản lý</p>
      <a href="admin_admins.php" class="btn">Xem tài khoản</a>
      </div>

      <div class="box">
      <?php
         $select_accounts = $conn->prepare("SELECT * FROM `users`");
         $select_accounts->execute();
         $number_of_accounts = $select_accounts->rowCount();
      ?>
      <h3><?= $number_of_accounts; ?></h3>
      <p>Số lượng tài khoản</p>
      <a href="admin_total_accounts.php" class="btn">Xem tài khoản</a>
      <!-- <a href="admin_total_accounts.php" class="btn">Xem tài khoản</a> -->
      </div>

      <div class="box">
      <?php
         $select_messages = $conn->prepare("SELECT * FROM `message`");
         $select_messages->execute();
         $number_of_messages = $select_messages->rowCount();
      ?>
      <h3><?= $number_of_messages; ?></h3>
      <p>Tổng số tin nhắn</p>
      <a href="admin_contacts.php" class="btn">Xem tin nhắn</a>
      </div>

   </div>

</section>













<script src="js/script.js"></script>

</body>
</html>