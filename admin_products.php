<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['add_product'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $category = $_POST['category'];
   $category = filter_var($category, FILTER_SANITIZE_STRING);
   $details = $_POST['details'];
   $details = filter_var($details, FILTER_SANITIZE_STRING);
   $inventories = $_POST['inventories'];
   $inventories = filter_var($inventories, FILTER_SANITIZE_STRING);

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
   $select_products->execute([$name]);

   if($select_products->rowCount() > 0){
      $message[] = 'product name already exist!';
   }else{

      $insert_products = $conn->prepare("INSERT INTO `products`(name, category, details, price, image, inventories) VALUES(?,?,?,?,?,?)");
      $insert_products->execute([$name, $category, $details, $price, $image, $inventories]);

      if($insert_products){
         if($image_size > 2000000){
            $message[] = 'image size is too large!';
         }else{
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'new product added!';
         }

      }

   }

};

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $select_delete_image = $conn->prepare("SELECT image FROM `products` WHERE id = ?");
   $select_delete_image->execute([$delete_id]);
   $fetch_delete_image = $select_delete_image->fetch(PDO::FETCH_ASSOC);
   unlink('uploaded_img/'.$fetch_delete_image['image']);
   $delete_products = $conn->prepare("DELETE FROM `products` WHERE id = ?");
   $delete_products->execute([$delete_id]);
   $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE pid = ?");
   $delete_wishlist->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
   $delete_cart->execute([$delete_id]);
   header('location:admin_products.php');


}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
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

   *::-webkit-scrollbar{
      height: .5rem;
      width: 1rem;
   }

   *::-webkit-scrollbar-track{
      background-color: transparent;
   }

   *::-webkit-scrollbar-thumb{
      background-color: #f55c7a;
   }

   body{
      background-color: #FAF0F6;
   }

   html{
      font-size: 62.5%;
      overflow-x: hidden;
      scroll-behavior: smooth;
      scroll-padding-top: 6.5rem;
   }

   section{
      padding:3rem 2rem;
      max-width: 1200px;
      margin:0 auto;
   }

   .disabled{
      user-select: none;
      pointer-events: none;
      opacity: .5;
   }

   .btn,
   .delete-btn,
   .option-btn{
      display: block;
      width: 100%;
      margin-top: 1rem;
      border-radius: .5rem;
      color:#f2d479;
      font-size: 2rem;
      padding:1.3rem 3rem;
      text-transform: capitalize;
      cursor: pointer;
      text-align: center;
   }

   .delete-btn{
      background-color: #c13346;
   }

   .btn:hover,
   .delete-btn:hover,
   .option-btn:hover{
      background-color: #333;
   }

   .flex-btn{
      display: flex;
      flex-wrap: wrap;
      gap:1rem;
   }

   .flex-btn > *{
      flex:1;
   }

   .title{
      text-align: center;
      margin-bottom: 2rem;
      text-transform: uppercase;
      color:#f55c7a;
      font-size: 3.5rem;
   }

   .message{
      position: sticky;
      top:0;
      max-width: 1200px;
      margin:0 auto;
      background-color: #f6f6f6;
      padding:2rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap:1.5rem;
      z-index: 10000;
   }

   .message span{
      font-size: 2rem;
      color:#333;
   }

   .message i{
      font-size: 2.5rem;
      cursor: pointer;
      color:#c13346;
   }

   .message i:hover{
      color:#333;
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

   @keyframes fadeIn {
      0%{
         transform: translateY(1rem);
      }
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

   .form-container form h3{
      font-size: 3rem;
      color:#333;
      margin-bottom: 1rem;
      text-transform: uppercase;
   }

   .form-container form .box{
      width: 100%;
      margin:1rem 0;
      border-radius: .5rem;
      border:.2rem solid #333;
      padding:1.2rem 1.4rem;
      font-size: 1.8rem;
      color:#333;
      background-color: #f6f6f6;
   }

   .form-container form p{
      margin-top: 2rem;
      font-size: 2.2rem;
      color:#808080;
   }

   .form-container form p a{
      color:#f55c7a;
   }

   .form-container form p a:hover{
      text-decoration: underline;
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
      position: relative;
   }

   .header .flex .logo{
      font-size: 2.5rem;
      color:#333;
   }

   .header .flex .logo span{
      color:#f55c7a;
   }

   .header .flex .navbar a{
      margin:0 1rem;
      font-size: 2rem;
      color:#808080;
   }

   .header .flex .navbar a:hover{
      text-decoration: underline;
      color:#f55c7a;
   }

   .header .flex .icons > *{
      font-size: 2.5rem;
      color:#808080;
      cursor: pointer;
      margin-left: 1.5rem;
   }

   .header .flex .icons > *:hover{
      color:#f55c7a;
   }

   .header .flex .icons a span,
   .header .flex .icons a i{
      color:#808080;
   }

   .header .flex .icons a:hover span,
   .header .flex .icons a:hover i{
      color:#f55c7a;
   }

   .header .flex .icons a span{
      font-size: 2rem;
   }

   #menu-btn{
      display: none;
   }

   .header .flex .profile{
      position: absolute;
      top:120%; right:2rem;
      box-shadow: 0 .5rem 1rem rgba(0,0,0,.1);
      border:.2rem solid #333;
      border-radius: .5rem;
      padding:2rem;
      text-align: center;
      background-color: #fff;
      width: 33rem;
      display: none;
      animation: fadeIn .2s linear;
   }

   .header .flex .profile.active{
      display: inline-block;
   }

   .header .flex .profile img{
      height: 15rem;
      width: 15rem;
      margin-bottom: 1rem;
      border-radius: 50%;
      object-fit: cover;
   }

   .header .flex .profile p{
      padding:.5rem 0;
      font-size: 2rem;
      color:#808080;
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

<section class="add-products">

   <h1 class="title">Thêm sản phẩm</h1>

   <form action="" method="POST" enctype="multipart/form-data">
      <div class="inputBox">
         <input type="text" name="name" class="box" required placeholder="Nhập tên sản phẩm">
      </div>
      <div class="flex">
         <div class="inputBox">
            <input type="number" min="0" name="price" class="box" required placeholder="Nhập giá sản phẩm">
            <input type="file" name="image" required class="box" accept="image/jpg, image/jpeg, image/png">
         </div>
         <div class="inputBox">
            <select name="category" class="box" required>
               <option value="" selected disabled>Chọn mặt hàng</option>
                  <option value="vegetables">Rau</option>
                  <option value="fruits">Hoa quả</option>
                  <option value="meat">Thịt</option>
                  <option value="fish">Cá</option>
            </select>
            <input type="number" min="0" name="inventories" class="box" required placeholder="Nhập số hàng trong kho">
         </div>
      </div>
      <textarea name="details" class="box" required placeholder="Nhập chi tiết sản phẩm" cols="30" rows="10"></textarea>
      <input type="submit" class="btn" value="Thêm sản phẩm" name="add_product">
   </form>

</section>

<!-- <section class="search-form">
<form method="post" >
   <input type="text" name="tk_id" class="search-input" placeholder="Nhập mã đơn hàng">
   <input type="date" name="tk_date" class="search-input">
   <button type="submit" name="submit" value="submit" class="search-btn">Tìm kiếm</button>
</form>
</section> -->

<section class="show-products">

   <h1 class="title">Sản phẩm đã thêm</h1>

   <form method="post" class="search-form">
   <input type="text" name="tk" class="search-input" placeholder="Nhập mã sản phẩm hoặc tên">
   <button type="submit" name="submit" value="submit" class="search-btn">Tìm kiếm</button>
   </form>

   <div class="box-container">

   <?php
   if(isset($_POST['submit'])){
      if(isset($_POST['tk']) && !empty($_POST['tk']))
      {
         $tk = $_POST['tk'];
         $sql="SELECT * FROM `products` WHERE id='$tk' OR name LIKE '%$tk%'";
         
     } else {
      $sql="SELECT * FROM `products`";
         
     }
     }
     else{
      $sql="SELECT * FROM `products`";
     }

      $show_products = $conn->prepare($sql);
      $show_products->execute();
      if($show_products->rowCount() > 0){
         while($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)){  
   ?>
   <div class="box">
      <div class="price"><?= $fetch_products['price']; ?> VND</div>
      <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
      <div class="name"><?= $fetch_products['name']; ?>(<?= $fetch_products['id']; ?>)</div>
      <div class="cat"><?= $fetch_products['category']; ?></div>
      <div class="details"><?= $fetch_products['details']; ?></div>
      <div class="flex-btn">
         <a href="admin_update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn">update</a>
         <a href="admin_products.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">xóa</a>
      </div>
   </div>
   <?php
      }
   }else{
      echo '<p class="empty">now products added yet!</p>';
   }
   ?>

   </div>

</section>











<script src="js/script.js"></script>

</body>
</html>