<?php
    session_start();
    if (!isset($_SESSION['admin_login'])) {
        header("location: ../index.php");
    }

    require_once '../connection.php';

    $sql_order = "SELECT * FROM sp_transaction";
    $result = $conn->query($sql_order);
    $all_orders = $result->num_rows; #จำนวน order

    $sql_customer = "SELECT * FROM masterlogin WHERE role = 'user'";
    $result2 = $conn->query($sql_customer);
    $all_customer = $result2->num_rows; #จำนวน user

    $sql_product = "SELECT * FROM sp_product";
    $result3 = $conn->query($sql_product);
    $all_product = $result3->num_rows; #จำนวน product

    $sql_netamount = "SELECT SUM(netamount) as total FROM sp_transaction WHERE operation='จัดส่งสําเร็จ';";
    $result4 = $conn->query($sql_netamount);
    while($row = $result4->fetch_assoc()) {
        $total=$row["total"];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN PAGE</title>
    
    <link rel="stylesheet" href="css/admin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    
    <div class="text-center mt-5">
        <div class="container background-container-header">

            <?php if(isset($_SESSION['success'])) : ?>
                <div class="alert alert-success">
                    <h3>
                        <?php
                            echo $_SESSION['success'];
                            unset($_SESSION['success']);
                        ?>
                    </h3>
                </div>
            <?php endif ?>

            <h1>Admin Page</h1>
            <hr>

            <h3>
                <?php if(isset($_SESSION['admin_login'])) { ?>
                Welcome, <?php echo $_SESSION['admin_login']; }?>
                <a href="../logout.php" class="btn btn-danger">Logout</a>
            </h3>

        </div>
    </div>
    <div class="container background-container-menu">
        <div class="container2">
            <div class="sidebar">

                <a href="admin_home.php" class="sidebar-menu">
                    หน้าแรก
                </a>

                <a href="admin_administrator.php" class="sidebar-menu">
                    ผู้ดูแลระบบ
                </a>

                <a href="customer_list.php" class="sidebar-menu">
                    รายชื่อลูกค้า
                </a>

                <a href="product_list.php" class="sidebar-menu">
                    รายการสินค้า
                </a>

                <a href="order_history.php" class="sidebar-menu">
                    ประวัติรายการสั่งซื้อ
                </a>

            </div>
            <div class="filter">
                <div class="container background-container">
    
                    <div class="box1">
                        <div class="product-item">
                            <p style="font-size: 1.2vw; margin-left: 10px; margin-top: 10px; padding: 10px;">ยอดขายทั้งหมด <?php echo $all_orders; ?> รายการ</p>
                            <i style="font-size: 100px;" class="product-img fa-brands fa-shopify"></i>
                        </div>
                        <div class="product-item">
                            <p style="font-size: 1.2vw;  margin-left: 10px; margin-top: 10px; padding: 10px;">รายการสินค้าทั้งหมด <?php echo $all_product; ?> รายการ</p>
                            <i style="font-size: 100px;" class="product-img fa-solid fa-chart-simple"></i>
                        </div>
                    </div>

                    <div class="box1">
                        <div class="product-item">
                            <p style="font-size: 1.2vw; margin-left: 10px; margin-top: 10px; padding: 10px;">จำนวนสมาชิกทั้งหมด <?php echo $all_customer; ?> คน</p>
                            <i style="font-size: 100px;" class="product-img fa-solid fa-users"></i>
                        </div>
                        <div class="product-item">
                            <p style="font-size: 1.2vw; margin-left: 10px; margin-top: 10px; padding: 10px;">ยอดเงินรวมทั้งหมด <?php echo $total; ?> บาท</p>
                            <i style="font-size: 100px;" class="product-img fa-solid fa-wallet"></i>
                        </div>
                    </div>
                    
                    <div class="box2">
                        <div class="product-item">
                            <img class="product-img" src="" alt="">
                            <center><p style="font-size: 1.2vw;">xxxxx</p></center>
                        </div>
                    </div>
    
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>