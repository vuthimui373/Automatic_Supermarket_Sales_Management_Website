<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['send'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $msg = $_POST['msg'];
   $msg = filter_var($msg, FILTER_SANITIZE_STRING);

   $select_message = $conn->prepare("SELECT * FROM `message` WHERE name = ? AND email = ? AND number = ? AND message = ?");
   $select_message->execute([$name, $email, $number, $msg]);

   if($select_message->rowCount() > 0){
      $message[] = 'already sent message!';
   }else{

      $insert_message = $conn->prepare("INSERT INTO `message`(user_id, name, email, number, message) VALUES(?,?,?,?,?)");
      $insert_message->execute([$user_id, $name, $email, $number, $msg]);

      $message[] = 'sent message successfully!';

   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contact</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

  
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

<section class="contact">

   <h1 class="title">Thông tin liên hệ</h1>

   <form action="" method="POST">
      <input type="text" name="name" class="box" required placeholder="Nhập tên của bạn">
      <input type="email" name="email" class="box" required placeholder="Nhập email">
      <input type="number" name="number" min="0" class="box" required placeholder="Nhập SĐT">
      <textarea name="msg" class="box" required placeholder="Nhập lời nhắn" cols="30" rows="10"></textarea>
      <input type="submit" value="Gửi lời nhắn" class="btn" name="send">
   </form>

</section>








<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>