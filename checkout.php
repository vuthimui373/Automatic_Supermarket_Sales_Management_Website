<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['order'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $address = $_POST['address'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   date_default_timezone_set('Asia/Ho_Chi_Minh');
   // $placed_on = date('d/m/Y');
   $placed_on = date("Y-m-d");
   $cart_total = 0;
   $cart_products = '';

   $cart_query = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $cart_query->execute([$user_id]);
   if($cart_query->rowCount() > 0){
      while($cart_item = $cart_query->fetch(PDO::FETCH_ASSOC)){
         $cart_products .= $cart_item['quantity']."kg ".$cart_item['name'].", ";
         $sub_total = ($cart_item['price'] * $cart_item['quantity']);
         $cart_total += $sub_total;
      };
   };

   $cart_products[strlen($cart_products) - 2] = " ";
   $total_products = $cart_products;

   $order_query = $conn->prepare("SELECT * FROM `orders` WHERE name = ? AND number = ? AND email = ? AND method = ? AND address = ? AND total_products = ? AND total_price = ?");
   $order_query->execute([$name, $number, $email, $method, $address, $total_products, $cart_total]);

   if($cart_total == 0){
      $message[] = 'your cart is empty';
   }elseif($order_query->rowCount() > 0){
      $message[] = 'order placed already!';
   }else{
      $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES(?,?,?,?,?,?,?,?,?)");
      $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $cart_total, $placed_on]);
      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);
      $message[] = 'order placed successfully!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
      <style>
         :root{
         --green:#27ae60;
       
         --red:#e74c3c;
       
         --black:hsl(300, 5%, 8%);
         --light-color:#f4dddd;
         --white:#fff;

         --border:.2rem solid var(--black);
         --box-shadow:0 .5rem 1rem rgba(0,0,0,.1);
         
         }
         *::selection{
      background-color: var(--green);
      color:var(--white);
         }

   .btn{
      background-color: var(--red);
   }

   .delete-btn{
      background-color: var(--red);
   }



   .btn:hover{
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
   
</head>
<body>
   
<?php include 'header.php'; ?>

<section class="display-orders">

   <?php
      $cart_grand_total = 0;
      $select_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
      $select_cart_items->execute([$user_id]);
      if($select_cart_items->rowCount() > 0){
         while($fetch_cart_items = $select_cart_items->fetch(PDO::FETCH_ASSOC)){
            $cart_total_price = ($fetch_cart_items['price'] * $fetch_cart_items['quantity']);
            $cart_grand_total += $cart_total_price;
   ?>
  <p>Sản phẩm: <?= $fetch_cart_items['name']; ?> <span>(<?= $fetch_cart_items['price'] . ' VND x ' . $fetch_cart_items['quantity']; ?>)</span> </p>

   <?php
    }
   }else{
      echo '<p class="empty">Giỏ hàng trống</p>';
   }
   ?>
   <div class="grand-total"  style="color:red">Tổng thanh toán : <span><?= $cart_grand_total; ?> VND</span></div>
</section>

<section class="checkout-orders">

   <form action="" method="POST">

      <h3>Đặt hàng</h3>

      <div class="flex">
         <div class="inputBox">
            <span>Tên của bạn :</span>
            <input type="text" name="name" placeholder="Nhập tên của bạn" class="box" required>
         </div>
         <div class="inputBox">
            <span>SĐT:</span>
            <input type="number" name="number" placeholder="Nhập số điện thoại" class="box" required>
         </div>
         <div class="inputBox">
            <span>Email :</span>
            <input type="email" name="email" placeholder="Nhập email" class="box" required>
         </div>
         <div class="inputBox">
            <span>Phương thức thanh toán :</span>
            <select name="method" class="box" required>
               <option value="cash on delivery">Tiền mặt (khi nhận hàng)</option>
               <option value="credit card">Thẻ tín dụng</option>
            </select>
         </div>
         <div class="inputBox">
            <span>Địa chỉ nhận hàng :</span>
            <input type="text" name="address" placeholder="enter your full address" class="box" required>
         </div>
         <div class="inputBox">
            <span>Mã Pin :</span>
            <input type="number" min="0" name="pin_code" placeholder="e.g. 123456" class="box" required>
         </div>
      </div>

      <input type="submit" name="order" class="btn <?= ($cart_grand_total > 0)?'':'disabled'; ?>" value="Đặt hàng ngay">

   </form>

</section>

<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>