<?php
    session_start();
    if (!isset($_SESSION['employee_login'])) {
        header("location: ../index.php");
    }

    require_once 'connection.php';

    if (isset($_REQUEST['delete_id'])) {
        $id = $_REQUEST['delete_id'];

        $select_stmt = $db->prepare("SELECT * FROM masterlogin WHERE id = :id");
        $select_stmt->bindParam(':id', $id);
        $select_stmt->execute();
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

        #ลบข้อมูล user
        $delete_stmt = $db->prepare('DELETE FROM masterlogin WHERE id = :id');
        $delete_stmt->bindParam(':id', $id);
        $delete_stmt->execute();

        header('Location:user_home.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMPLOYEE PAGE</title>
    
    <link rel="stylesheet" href="css/employee.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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

            <h1>Employee Page</h1>
            <hr>

            <h3>
                <?php if(isset($_SESSION['employee_login'])) { ?>
                Welcome, <?php echo $_SESSION['employee_login']; }?>
                <a href="../logout.php" class="btn btn-danger">Logout</a>
            </h3>

        </div>
    </div>
    <div class="container background-container-menu">
        <div class="container1">
            <div class="sidebar">

                <a href="employee_home.php" class="sidebar-menu">
                    หน้าแรก
                </a>

                <a href="customer_list.php" class="sidebar-menu">
                    รายชื่อลูกค้า
                </a>

                <a href="#" class="sidebar-menu">
                    รายการสินค้า
                </a>

                <a href="#" class="sidebar-menu">
                    ประวัติรายการสั่งซื้อ
                </a>

                <hr>

               
                <?php
                    if (isset($_SESSION['employee_login'])) {
                    $select_stmt = $db->prepare("SELECT * FROM masterlogin WHERE email = '".$_SESSION["employee_login"]."'");
                    $select_stmt->execute();

                    while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>

                <a href="employee_profile.php?update_id=<?php echo $row["id"]; ?>" class="sidebar-menu">
                    โปรไฟล์
                </a>    
                
                <?php } }?>
            </div>

            <div class="filter">
                <div class="container background-container">
    
                    <div class="box1">
                        <div class="product-item">
                            <img class="product-img" src="" alt="">
                            <center><p style="font-size: 1.2vw;">ยอดขายประจำวัน</p></center>
                        </div>
                        <div class="product-item">
                            <img class="product-img" src="" alt="">
                            <center><p style="font-size: 1.2vw;">ยอดขายประจำเดือน</p></center>
                        </div>
                        <div class="product-item">
                            <img class="product-img" src="" alt="">
                            <center><p style="font-size: 1.2vw;">จำนวนสมาชิกประจำเดือน</p></center>
                        </div>
                    </div>

                    <div class="box1">
                        <div class="product-item">
                            <img class="product-img" src="" alt="">
                            <center><p style="font-size: 1.2vw;">xxxxx</p></center>
                        </div>
                        <div class="product-item">
                            <img class="product-img" src="" alt="">
                            <center><p style="font-size: 1.2vw;">xxxxx</p></center>
                        </div>
                        <div class="product-item">
                            <img class="product-img" src="" alt="">
                            <center><p style="font-size: 1.2vw;">xxxxx</p></center>
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