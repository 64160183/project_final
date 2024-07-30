<?php
    session_start();
    if (!isset($_SESSION['employee_login'])) {
        header("location: ../index.php");
    }

    require_once '../connection.php';

    if (isset($_REQUEST['delete_id'])) {
        $id = $_REQUEST['delete_id'];

        $select_stmt = $db->prepare("SELECT * FROM sp_transaction WHERE id = :id");
        $select_stmt->bindParam(':id', $id);
        $select_stmt->execute();
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

        #ลบข้อมูล user
        $delete_stmt = $db->prepare('DELETE FROM sp_transaction WHERE id = :id');
        $delete_stmt->bindParam(':id', $id);
        $delete_stmt->execute();

        header('Location:order_history.php');
    }
?>

<?php
    $select_stmt = $db->prepare("SELECT * FROM sp_transaction");
    $select_stmt->execute();

    $orders = array();
    while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
        $order = array(
            'id' => $row['id'],
            'orderid' => $row['transid'],
            'orderlist' => json_decode($row['orderlist'], true),
            'netamount' => $row['netamount'],
            'updated_at' => $row['updated_at'],
            'username' => $row['username'],
            'address' => $row['address'],
            'phone' => $row['phone'],
            'operation' => $row['operation']
        );
        array_push($orders, $order);
    }
?>
<script>
    var orders = <?php echo json_encode($orders); ?>;
</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMPLOYEE PAGE</title>

    <script src="../colorOperation.js"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <link rel="stylesheet" href="css/employee.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    
    <div class=" text-center mt-3">
        <div class="container1 background-container-header">

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
                <a href="../logout.php" class="btn btn-danger">ออกจากระบบ</a>
            </h3>

        </div>
    </div>
    
    <div class="container2 background-container-menu">
        <div class="container2">
            <div class="sidebar">

                <a href="employee_home.php" class="sidebar-menu">
                    หน้าแรก
                </a>

                <a href="customer_list.php#" class="sidebar-menu">
                    รายชื่อลูกค้า
                </a>

                <a href="product_list.php" class="sidebar-menu">
                    รายการสินค้า
                </a>

                <a href="order_history.php" class="sidebar-menu">
                    ประวัติรายการสั่งซื้อ
                </a>

                <a href="employee_product.php" class="sidebar-menu">
                    สินค้า
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

            <div class="filter2">
                <div class="display-5 text-center">ประวัติการสั่งซื้อ</div>

                <br>

                <input type="text" id="searchOrderInput" onkeyup="searchorder(this)" class="sidebar-search sidebar-menu-filter" placeholder="ค้นหาประวัติการสั่งซื้อ">

                <table class="table table-light table-bordered table-hover mt-3">
                    <thead class="table-primary">
                        <tr>
                            <th>Id</th>
                            <th>รหัสสินค้า</th>
                            <th>รายการสินค้า</th>
                            <th>ราคารวมสินค้า</th>
                            <th>เวลาที่สั่ง</th>
                            <th>ชื่อผู้สั่ง</th>
                            <th>ที่อยู่</th>
                            <th>เบอร์โทรศัพ์</th>
                            <th>สถานะสินค้า</th>
                        </tr>
                    </thead>
                    <tbody id="orderlist">
                        <?php
                            $select_stmt = $db->prepare("SELECT * FROM sp_transaction");
                            $select_stmt->execute();

                            while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                                $orderlist = json_decode($row["orderlist"], true);
                                $orderTable = '<table class="table table-light table-bordered table-hover"><tr><th>ชื่อ</th><th>จำนวน</th><th>ราคาต่อชิ้น</th></tr>';
                                foreach ($orderlist as $item) {
                                    $price = isset($item['price']) ? htmlspecialchars($item['price']) . ' บาท' : '';
                                    $orderTable .= '<tr><td>' . htmlspecialchars($item['name']) . '</td><td>' . htmlspecialchars($item['count']) . '</td><td>' . $price . '</td></tr>';
                                }
                                $orderTable .= '</table>';
                        ?>

                        <tr>
                            <td><?php echo $row["id"]; ?></td>
                            <td><?php echo $row["transid"]; ?></td>
                            <td><?php echo $orderTable; ?></td>
                            <td><?php echo $row["netamount"]; ?></td>
                            <td><?php echo $row["updated_at"]; ?></td>
                            <td><?php echo $row["username"]; ?></td>
                            <td><?php echo $row["address"]; ?></td>
                            <td><?php echo $row["phone"]; ?></td>
                            <td><?php echo $row["operation"]; ?></td>
                        </tr>
                            
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>