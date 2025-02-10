<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['update_product'])){

   $pid = $_POST['pid'];
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $category = $_POST['category'];
   $category = filter_var($category, FILTER_SANITIZE_STRING);
   $details = $_POST['details'];
   $details = filter_var($details, FILTER_SANITIZE_STRING);

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;
   $old_image = $_POST['old_image'];

   $update_product = $conn->prepare("UPDATE `products` SET name = ?, category = ?, details = ?, price = ? WHERE id = ?");
   $update_product->execute([$name, $category, $details, $price, $pid]);

   $message[] = 'Cập nhật thành công!';

   if(!empty($image)){
      if($image_size > 2000000){
         $message[] = 'image size is too large!';
      }else{

         $update_image = $conn->prepare("UPDATE `products` SET image = ? WHERE id = ?");
         $update_image->execute([$image, $pid]);

         if($update_image){
            move_uploaded_file($image_tmp_name, $image_folder);
            unlink('uploaded_img/'.$old_image);
            $message[] = 'image updated successfully!';
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
   <title>update products</title>

   <!-- font awesome cdn link   link cho icon trên header-->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/admin_style.css">
   <style>
*{
   font-family: 'Rubik', sans-serif;
   margin:0; padding:0;
   box-sizing: border-box;
   outline: none; border:none;
   text-decoration: none;
   color:#333; /* Thay var(--black) bằng #333 */
}

*::selection{
   background-color: #f55c7a; /* Thay var(--green) bằng #f55c7a */
   color:#fff; /* Thay var(--white) bằng #fff */
}

*::-webkit-scrollbar{
   height: .5rem;
   width: 1rem;
}

*::-webkit-scrollbar-track{
   background-color: transparent;
}

*::-webkit-scrollbar-thumb{
   background-color: #f55c7a; /* Thay var(--green) bằng #f55c7a */
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

.btn,
.delete-btn,
.option-btn{
   display: block;
   width: 100%;
   margin-top: 1rem;
   border-radius: .5rem;
   color:#f2d479; /* Thay var(--light-btn) bằng #f2d479 */
   font-size: 2rem;
   padding:1.3rem 3rem;
   text-transform: capitalize;
   cursor: pointer;
   text-align: center;
}

.delete-btn{
   background-color: #c13346; /* Thay var(--red) bằng #c13346 */
}

.delete-btn:hover{
   background-color: #333; /* Thay var(--black) bằng #333 */
}

.title{
   text-align: center;
   margin-bottom: 2rem;
   text-transform: uppercase;
   color:#f55c7a; /* Thay var(--green) bằng #f55c7a */
   font-size: 3.5rem;
}

.update-product form{
   max-width: 50rem;
   padding:2rem;
   margin:0 auto;
   text-align: center;
   border:.2rem solid #333; /* Thay var(--border) bằng .2rem solid #333 */
   box-shadow: 0 .5rem 1rem rgba(0,0,0,.1); /* Thay var(--box-shadow) bằng giá trị này */
   background-color: #fff; /* Thay var(--white) bằng #fff */
   border-radius: .5rem;
}

.update-product form img{
   height: 25rem;
   object-fit: cover;
   margin-bottom: 1rem;
}

.update-product form .box{
   width: 100%;
   border:.2rem solid #333; /* Thay var(--border) bằng .2rem solid #333 */
   background-color: #f6f6f6; /* Thay var(--light-bg) bằng #f6f6f6 */
   border-radius: .5rem;
   padding:1.2rem 1.4rem;
   font-size: 1.8rem;
   color:#333; /* Thay var(--black) bằng #333 */
   margin:1rem 0;
}

@media (max-width:450px){
   .show-products .box-container{
      grid-template-columns: 1fr;
   }

   .update-product form img{
      height: auto;
      width: 100%;
   }

   .placed-orders .box-container,
   .user-accounts .box-container,
   .messages .box-container{
      grid-template-columns: 1fr;
   }
}
</style>


</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="update-product">

   <h1 class="title">Cập nhật sản phẩm</h1>   

   <?php
      $update_id = $_GET['update'];
      $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
      $select_products->execute([$update_id]);
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="old_image" value="<?= $fetch_products['image']; ?>">
      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
      <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
      <input type="text" name="name" placeholder="enter product name" required class="box" value="<?= $fetch_products['name']; ?>">
      <input type="number" name="price" min="0" placeholder="enter product price" required class="box" value="<?= $fetch_products['price']; ?>">
      <select name="category" class="box" required>
         <option selected><?= $fetch_products['category']; ?></option>
         <option value="vegitables">Rau</option>
         <option value="fruits">Hoa quả</option>
         <option value="meat">Thịt</option>
         <option value="fish">Cá</option>
      </select>
      <textarea name="details" required placeholder="Nhập chi tiết sản phẩm" class="box" cols="30" rows="10"><?= $fetch_products['details']; ?></textarea>
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
      <div class="flex-btn">
         <input type="submit" class="btn" value="Cập nhật" name="update_product">
         <a href="admin_products.php" class="option-btn">Trở lại</a>
      </div>
   </form>
   <?php
         }
      }else{
         echo '<p class="empty">Không tìm thấy sản phẩm!</p>';
      }
   ?>

</section>













<script src="js/script.js"></script>

</body>
</html>