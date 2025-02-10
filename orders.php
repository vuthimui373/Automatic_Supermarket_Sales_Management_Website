<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
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

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <style>
      :root{
      --green:#27ae60;
      --orange:#f39c12;
      --red:#e74c3c;
      --pink:#e4b3da;
      --black:hsl(300, 5%, 8%);
      --light-color:#f4dddd;
      --white:#fff;
      --light-bg:#f6f6f6;
      --border:.2rem solid var(--black);
      --box-shadow:0 .5rem 1rem rgba(0,0,0,.1);
      --purple:#800080;
      }
      *::selection{
   background-color: var(--green);
   color:var(--white);
}
.btn,
.delete-btn,
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

.delete-btn{
   background-color: var(--red);
}



.btn:hover,
.delete-btn:hover,
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
.checkout-orders form .flex .inputBox span{
   font-size: 1.8rem;
   color:var(--light-color);
}

.placed-orders .box-container{
   display: flex;
   flex-wrap: wrap;
   gap:1.5rem;
   align-items: flex-start;
}

.placed-orders .box-container .box{
   padding:1rem 2rem;
   flex:1 1 40rem;
   border:var(--border);
   background-color: var(--white);
   box-shadow: var(--box-shadow);
   border-radius: .5rem;
}

.placed-orders .box-container .box p{
   margin:.5rem 0;
   line-height: 1.8;
   font-size: 2rem;
   color:var(--green);
}

.placed-orders .box-container .box p span{
   color:var(--black);

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
   
<?php include 'header.php'; ?>

<section class="placed-orders">

   <h1 class="title">placed orders</h1>
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
            $sql="SELECT * FROM `orders` WHERE user_id = '$user_id' AND(id='$tk_id' OR placed_on='$tk_date')";
            
        } else {
         $sql="SELECT * FROM `orders` WHERE user_id = '$user_id'";
            
        }
        }
        else{
         $sql="SELECT * FROM `orders` WHERE user_id = '$user_id'";
        }
      
      
      $select_orders = $conn->prepare($sql);
      $select_orders->execute();
      if($select_orders->rowCount() > 0){
         while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <div class="box">
      <p> Mã đơn hàng : <span><?= $fetch_orders['id']; ?></span> </p>
      <p> Thời gian đặt hàng : <span><?= $fetch_orders['placed_on']; ?></span> </p>
      <p> Tên khách hàng : <span><?= $fetch_orders['name']; ?></span> </p>
      <p> Số điện thoại : <span><?= $fetch_orders['number']; ?></span> </p>
      <p> Email : <span><?= $fetch_orders['email']; ?></span> </p>
      <p> Địa chỉ : <span><?= $fetch_orders['address']; ?></span> </p>
      <p> Phương thức thanh toán : <span><?= $fetch_orders['method']; ?></span> </p>
      <p> Sản phẩm mua : <span><?= $fetch_orders['total_products']; ?></span> </p>
      <p> Tổng giá : <span><?= $fetch_orders['total_price']; ?>VND</span> </p>
      <p> Trạng thái thanh toán : <span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; }; ?>"><?= $fetch_orders['payment_status']; ?></span> </p>
   </div>
   <?php
      }
   }else{
      echo '<p class="empty">no orders placed yet!</p>';
   }
   ?>
   </div>

</section>









<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>