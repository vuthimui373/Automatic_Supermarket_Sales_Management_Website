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
   <title>about</title>

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
   </style>
</head>
<body>
   
<?php include 'header.php'; ?>

<section class="about">

   <div class="row">
      <div class="box">
         <span style="font-size: 50px;">OnlineMarket được thành lập năm 2003.</span><br><br>
         <span style="font-size: 30px;">Trang mua sắm trực tuyến cung cấp các dòng sản phẩm thực phẩm được lấy từ các trang trại tiêu chuẩn ở Việt Nam cũng như trên khắp thế giới.
            <br> Sản phẩm của chúng tôi rất đa dạng, bao gồm rau củ, trái cây, thịt, trứng, hải sản,....</span><br><br>
         <a href="contact.php" class="btn">Liên hệ ngay</a>
         <a href="shop.php" class="btn">Mua ngay</a>
      </div>   
   </div>

</section>

<section class="reviews">

   <h1 class="title">Đánh giá khách hàng</h1>

   <div class="box-container">

      <div class="box">
         <img src="./images/anh2.jpg" alt="">
         <p style="color: black;">Sản phẩm chất lượng, tuyệt vời. Nhất định sẽ quay lại.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
         </div>
         <h3>Hải Thanh</h3>
      </div>

      <div class="box">
         <img src="./images/anh3.jpg" alt="">
         <p  style="color: black;">Chất lượng sản phẩm tốt, không thể chê vào đâu được.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Tuệ Sang</h3>
      </div>

      <div class="box">
         <img src="./images/anh4.jpg" alt="">
         <p  style="color: black;">Good, tôi sẽ ủng hộ và giới thiệu tới gia đình và bạn bè.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Đào Ngọc</h3>
      </div>

      <div class="box">
         <img src="./images/anh5.jpg" alt="">
         <p  style="color: black;">Trải nghiệm mua hàng quá tốt, tôi sẽ tiếp tục tin tưởng Dat fresh food trong tương lai</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Muinee</h3>
      </div>

      <div class="box">
         <img src="./images/anh6.jpg" alt="">
         <p  style="color: black;">ờ mây zing, gút chóp. Tôi đã ăn hết cả 1 thùng cà chua vì quá ngon.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Bông</h3>
      </div>

      <div class="box">
         <img src="./images/duybeo.jpg" alt="">
         <p  style="color: black;">Rau củ quả siêu sạch mà ăn ngon tươi đảm bảo</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Duy</h3>
      </div>

   </div>

</section>









<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>