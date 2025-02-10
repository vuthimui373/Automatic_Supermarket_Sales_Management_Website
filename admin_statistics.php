<?php
@include 'config.php';
session_start();
$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
    header('location:login.php');
};
if (isset($_POST['update_order'])) {
    $order_id = $_POST['order_id'];
    $update_payment = $_POST['update_payment'];
    $update_payment = filter_var($update_payment, FILTER_SANITIZE_STRING);
    $update_orders = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
    $update_orders->execute([$update_payment, $order_id]);
    $message[] = 'payment has been updated!';
};

if (isset($_GET['delete'])) {
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
    <title>statistics</title>
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="css/admin_style.css">
   <style>
      /* Các style CSS của bạn vẫn giữ nguyên */
      @import url('https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap');
      * {
         font-family: 'Rubik', sans-serif;
         margin: 0;
         padding: 0;
         box-sizing: border-box;
         color: #333; /* Màu đen mặc định */
      }

      body {
         background-color: #FAF0F6;
      }

      section {
         padding: 3rem 2rem;
         max-width: 1200px;
         margin: 0 auto;
      }

      .btn,
      .delete-btn {
         display: block;
         width: 100%;
         margin-top: 1rem;
         border-radius: 0.5rem;
         font-size: 2rem;
         padding: 1.3rem 3rem;
         text-align: center;
         cursor: pointer;
      }

      .delete-btn {
         background-color: #c13346; /* Màu đỏ */
         color: #fff; /* Màu trắng */
      }

      .delete-btn:hover {
         background-color: #333; /* Màu đen */
      }

      .title {
         text-align: center;
         margin-bottom: 2rem;
         color: #f55c7a; /* Màu hồng đậm */
         font-size: 3.5rem;
      }

      .box {
         background-color: #fff; /* Màu trắng */
         border: 0.2rem solid #333; /* Viền đen */
         border-radius: 0.5rem;
         box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
         padding: 2rem;
      }

      .table {
         width: 100%;
         border-collapse: collapse;
         font-size: 16px;
      }

      .table th,
      .table td {
         padding: 8px;
         text-align: left;
         border: 1px solid #ddd; /* Màu viền nhạt */
      }

      .table th {
         background-color: #f2f2f2; /* Màu xám nhạt */
      }

      .message {
         position: sticky;
         top: 0;
         background-color: #f6f6f6; /* Màu nền nhạt */
         padding: 1rem;
         display: flex;
         justify-content: space-between;
         box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
      }

      .message span {
         font-size: 1.8rem;
      }

      .message i {
         font-size: 2rem;
         color: #c13346; /* Màu đỏ */
         cursor: pointer;
      }

      .message i:hover {
         color: #333; /* Màu đen */
      }

      @media (max-width: 768px) {
         .title {
            font-size: 3rem;
         }

         .table {
            font-size: 14px;
         }
      }

      /* Định dạng div tổng doanh thu */
      .total-revenue-container {
         margin-top: 20px;
         margin-bottom: 20px;
         text-align: center;
         font-size: 30px;
         font-weight: bold;
         background-color: #fff;
         padding: 10px;
         border-radius: 10px;
         box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
         width: 100%;
      }
   </style>
</head>
<body>

    <?php include 'admin_header.php'; ?>

    <section class="placed-orders">
        <h1 class="title">Thống kê về số lượng xuất/nhập kho</h1>

        <div class="box">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tên sản phẩm</th>
                        <th scope="col">Giá/kg</th>
                        <th scope="col">Số lượng bán</th>
                        <th scope="col">Hàng tồn kho</th>
                        <th scope="col">Doanh thu</th>
                    </tr>
                </thead>
                <?php
                $stmt = $conn->prepare("SELECT * FROM `products`");
                $query = $stmt->execute();
                if ($query) {
                    $count = 0;
                    $total_revenue = 0;
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                        <tbody>
                            <tr>
                                <th scope="row"><?php echo ++$count ?></th>
                                <td><?php echo $row['name'] ?></td>
                                <td><?php echo $row['price'] ?></td>
                                <td><?php echo $row['sold'] ?></td>
                                <td><?php echo $row['inventories'] ?></td>
                                <?php
                                $revenue = $row['sold'] * $row['price'];
                                $total_revenue += $revenue;
                                ?>
                                <td style="background-color:yellow;"><?php echo $revenue . " VND" ?></td>
                            </tr>
                        </tbody>
                <?php
                    }
                }
                ?>
            </table>
        </div>

        <!-- Đặt tổng doanh thu trong div riêng biệt -->
        <div class="total-revenue-container">
            Tổng doanh thu: <?php echo $total_revenue; ?> VND
        </div>

        <div class="box" style="width:500px;">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Ngày/tháng/năm</th>
                        <th scope="col">Doanh thu</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Phần xử lý tìm kiếm doanh thu theo ngày
                    $date = '';
                    if (isset($_POST['search'])) {
                        $date = $_POST['date'];
                    }

                    if ($date != '') {
                        // Dùng prepared statement để tránh SQL Injection
                        $sql = "SELECT SUM(total_price) AS total_revenue FROM `orders` WHERE placed_on = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute([$date]);
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                        $revenue = $row['total_revenue'];
                    }
                    ?>
                    <tr>
                        <td style="width:20%;">
                            <form method="POST">
                                <input type="date" name="date" required>
                        </td>
                        <td style="background-color:yellow;width:20%;"><?php echo isset($revenue) ? $revenue . ' VND' : ''; ?></td>
                        <td style="width:10%;">
                            <input class="delete-btn" type="submit" name="search" value="Search"></input>
                        </td>
                        </form>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <script src="js/script.js"></script>

</body>

</html>