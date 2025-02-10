<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['update_order'])){
   $order_id = $_POST['order_id'];
   $update_payment = $_POST['update_payment'];

   if ($update_payment == 'completed') {
      $update_payment = filter_var($update_payment, FILTER_SANITIZE_STRING);
      $update_orders = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
      $update_orders->execute([$update_payment, $order_id]);
      $message[] = 'payment has been updated!';

      $total_products = $_POST['total_products'];
      $arr1 = explode(",", $total_products);
      $allSubelements = array();
      foreach ($arr1 as $element) {
         $element = trim($element);
         $arr2 = explode("kg ", $element);
         $currentSubelements = array();
         foreach ($arr2 as $subelement) {
            $currentSubelements[] = $subelement;
         }
         $allSubelements[] = $currentSubelements;
      }
      for ($i = 0; $i < count($allSubelements); $i++) {
         $stmt = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
         $stmt->execute([$allSubelements[$i][1]]);
         if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $invent = $row['inventories'];
            $sold = $row['sold'];
            $update_inventories = $conn->prepare("UPDATE `products` SET inventories = ? WHERE name = ?");
            $newInventories = $invent-$allSubelements[$i][0];
            $update_inventories->execute([$newInventories,$allSubelements[$i][1]]);
            
            $update_sold = $conn->prepare("UPDATE `products` SET sold = ? WHERE name = ?");
            $newSold = $sold+$allSubelements[$i][0];
            $update_sold->execute([$newSold,$allSubelements[$i][1]]);
         }   
      }
   }

};

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_orders = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
   $delete_orders->execute([$delete_id]);
   header('location:admin_orders.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>orders</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/admin_style.css">

   <style>
      
      *{
         font-family: 'Rubik', sans-serif;
         margin:0; padding:0;
         box-sizing: border-box;
         outline: none; border:none;
         text-decoration: none;
         color:#333;
      }

      *::selection{
         background-color: #f55c7a;
         color:#fff;
      }

      body{
         background-color: #FAF0F6;
      }

      section{
         padding:3rem 2rem;
         max-width: 1200px;
         margin:0 auto;
      }

      .btn,
      .delete-btn,
      .option-btn {
      display: block;
      width: 100%;
      margin-top: 1rem;
      border-radius: .5rem;
      color: #fff;
      font-size: 2rem;
      padding: 1.3rem 3rem;
      text-transform: capitalize;
      cursor: pointer;
      text-align: center;
      background-color: #C0C0C0; /* Mã màu mới */
      }

.option-btn:hover {
    background-color: #0056b3; /* Màu khi hover (đậm hơn) */
}


      .delete-btn{
         background-color: #c13346;
      }

      .delete-btn:hover,
      .option-btn:hover{
         background-color: #333;
      }

      .flex-btn{
         display: flex;
         flex-wrap: wrap;
         gap:1rem;
      }

      .title{
         text-align: center;
         margin-bottom: 2rem;
         text-transform: uppercase;
         color:#f55c7a;
         font-size: 3.5rem;
      }

      .empty{
         padding:1.5rem;
         background: #fff;
         color:#c13346;
         border-radius: .5rem;
         border:.2rem solid #333;
         font-size: 2rem;
         text-align: center;
         box-shadow: 0 .5rem 1rem rgba(0,0,0,.1);
         text-transform: capitalize;
      }

      .form-container{
         min-height: 100vh;
         display: flex;
         align-items: center;
         justify-content: center;
      }

      .form-container form{
         width: 50rem;
         background-color: #fff;
         border-radius: .5rem;
         box-shadow: 0 .5rem 1rem rgba(0,0,0,.1);
         border:.2rem solid #333;
         text-align: center;
         padding:2rem;
      }

      .header{
         background: #fff;
         position: sticky;
         top:0; left:0; right:0;
         z-index: 1000;
         box-shadow: 0 .5rem 1rem rgba(0,0,0,.1);
      }

      .header .flex{
         display: flex;
         align-items: center;
         justify-content: space-between;
         padding:2rem;
         margin: 0 auto;
         max-width: 1200px;
      }

      .header .flex .navbar a{
         margin:0 1rem;
         font-size: 2rem;
         color:#333;
      }

      .header .flex .navbar a:hover{
         color:#f55c7a;
      }

      .footer{
         background-color: #fff;
         padding: 2rem 1.5rem;
         text-align: center;
         font-size: 2rem;
         color:#333;
      }

      .footer .credit span{
         color:#f55c7a;
      }

      @media (max-width:768px){
         .header .flex .navbar a{
            display: block;
            margin:2rem;   
         }
      }

      .placed-orders .box-container{
         display: grid;
         grid-template-columns: repeat(auto-fit, 33rem);
         gap:1.5rem;
         align-items: flex-start;
         justify-content:center;
      }

      .placed-orders .box-container .box{
         border:.2rem solid #333;
         box-shadow: 0 .5rem 1rem rgba(0,0,0,.1);
         background-color: #fff;
         border-radius: .5rem;
         padding:2rem;
      }

      .placed-orders .box-container .box p{
         margin-bottom: 1rem;
         line-height: 1.5;
         font-size: 2rem;
         color:black;
      }

      .placed-orders .box-container .box p span{
         color:#f55c7a;
      }

      .placed-orders .box-container .box .drop-down{
         width: 100%;
         padding:1.2rem 1.4rem;
         font-size: 1.8rem;
         border:.2rem solid #333;
         border-radius: .5rem;
         background-color: #f6f6f6;
         margin-bottom: .5rem;
      }

      @media (max-width:450px){
         .placed-orders .box-container{
            grid-template-columns: 1fr;
         }
      }



      /* Tùy chỉnh chung cho form tìm kiếm */
.search-form {
   display: flex;
   justify-content: center;
   align-items: center;
   gap: 1rem;
   margin: 2rem auto;
   padding: 1.5rem;
   border: var(--border);
   border-radius: .5rem;
   background-color: var(--white);
   box-shadow: var(--box-shadow);
   max-width: 600px;
}

/* Tùy chỉnh các input */
.search-input {
   flex: 1;
   padding: .8rem 1rem;
   border: var(--border);
   border-radius: .5rem;
   font-size: 1.6rem;
   color: var(--black);
   outline: none;
}

.search-input:focus {
   border-color: var(--green);
   box-shadow: 0 0 5px var(--green);
}

/* Tùy chỉnh button tìm kiếm */
.search-btn {
   padding: .8rem 1.5rem;
   font-size: 1.6rem;
   color: var(--white);
   background-color: var(--red);
   border: none;
   border-radius: .5rem;
   cursor: pointer;
   text-transform: uppercase;
   transition: background-color .3s ease;
}

.search-btn:hover {
   background-color: var(--green);
   box-shadow: 0 0 5px var(--green);
}

/* Tạo responsive cho form */
@media (max-width: 768px) {
   .search-form {
      flex-direction: column;
      gap: .8rem;
   }
   .search-input,
   .search-btn {
      width: 100%;
   }
}
   </style>
</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="placed-orders">
   <h1 class="title">ĐƠN ĐẶT HÀNG</h1>
   <form method="post" class="search-form">
   <input type="text" name="tk_id" class="search-input" placeholder="Nhập mã đơn hàng">
   <input type="date" name="tk_date" class="search-input">
   <button type="submit" name="submit" value="submit" class="search-btn">Tìm kiếm</button>
</form>
   <div class="box-container">

      <?php
      if(isset($_POST['submit'])){
         if ((isset($_POST['tk_id']) && !empty($_POST['tk_id'])) ||
            (isset($_POST['tk_date']) && !empty($_POST['tk_date']))) {
            $tk_id = $_POST['tk_id'];
            $tk_date=$_POST['tk_date'];
            $sql="SELECT * FROM orders WHERE id='$tk_id' OR placed_on='$tk_date'";
            
        } else {
         $sql="SELECT * FROM orders";
            
        }
        }
        else{
         $sql="SELECT * FROM orders";
        }
      
      
         $select_orders = $conn->prepare($sql);
         $select_orders->execute();
         if($select_orders->rowCount() > 0){
            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
      ?>
      <div class="box">
         <p> Mã đơn hàng : <span><?= $fetch_orders['id']; ?></span> </p>
         <p> ID user: <span><?= $fetch_orders['user_id']; ?></span> </p>
         <p> Đặt vào ngày : <span><?= $fetch_orders['placed_on']; ?></span> </p>
         <p> Tên người đặt : <span><?= $fetch_orders['name']; ?></span> </p>
         <p> Email : <span><?= $fetch_orders['email']; ?></span> </p>
         <p> Số điện thoại : <span><?= $fetch_orders['number']; ?></span> </p>
         <p> Địa chỉ : <span><?= $fetch_orders['address']; ?></span> </p>
         <p> Tổng sản phẩm : <span><?= $fetch_orders['total_products']; ?></span> </p>
         <p> Tổng giá : <span><?= $fetch_orders['total_price']; ?>VND</span> </p>
         <p> Hình thức trả : <span><?= $fetch_orders['method']; ?></span> </p>
         <form action="" method="POST">
            <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
            <input type="hidden" name="total_products" value="<?= $fetch_orders['total_products']; ?>">
            <select name="update_payment" class="drop-down">
               <option value="" selected disabled><?= $fetch_orders['payment_status']; ?></option>
               <option value="pending">pending</option>
               <option value="completed">completed</option>
            </select>
            <div class="flex-btn">
               <?php
                  if ($fetch_orders['payment_status'] == 'completed') {
                     $disabled = 'disabled';
                  } else {
                     $disabled = '';
                  }
               ?>
               <input type="submit" name="update_order" class="option-btn" value="update" <?php echo $disabled; ?>>
               <a href="admin_orders.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('Xóa đơn này?');">xóa</a>
            </div>
         </form>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">Chưa có đơn hàng nào!</p>';
      }
      ?>

   </div>

</section>

<script src="js/script.js"></script>

</body>
</html>