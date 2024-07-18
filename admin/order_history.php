<?php
    session_start();
    if (!isset($_SESSION['admin_login'])) {
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN PAGE</title>
    
    <link rel="stylesheet" href="css/admin.css">
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

            <h1>Admin Page</h1>
            <hr>

            <h3>
                <?php if(isset($_SESSION['admin_login'])) { ?>
                Welcome, <?php echo $_SESSION['admin_login']; }?>
                <a href="../logout.php" class="btn btn-danger">Logout</a>
            </h3>

        </div>
    </div>
    
    <div class="container2 background-container-menu">
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
                <div class="display-5 text-center">Order History</div>
                <table class="table table-light table-bordered table-hover mt-3">
                    <thead class="table-primary">
                        <tr>
                            <th>Id</th>
                            <th>รหัสสินค้า</th>
                            <th>รายการสินค้า</th>
                            <th>ราคารวมสินค้า</th>
                            <th>เวลาที่สั่ง</th>
                            <th>ชื่อผู้สั่ง</th>
                            <th>ที่อยู่	</th>
                            <th>เบอร์โทรศัพ์</th>
                            <th>สถานะสินค้า</th>
                            <th>Delete</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            $select_stmt = $db->prepare("SELECT * FROM sp_transaction");
                            $select_stmt->execute();

                            while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                        ?>

                            <tr>
                                <td><?php echo $row["id"]; ?></td>
                                <td><?php echo $row["transid"]; ?></td>
                                <td><?php echo $row["orderlist"]; ?></td>
                                <td><?php echo $row["netamount"]; ?></td>
                                <td><?php echo $row["updated_at"]; ?></td>
                                <td><?php echo $row["username"]; ?></td>
                                <td><?php echo $row["address"]; ?></td>
                                <td><?php echo $row["phone"]; ?></td>
                                <td><?php echo $row["operation"]; ?></td>
                                <td class="mt-5">
                                    <center>
                                        <a href="edit_operation.php?update_id=<?php echo $row["id"]; ?>" class="btn btn-success">Edit</a>
                                        <a href="?delete_id=<?php echo $row["id"]; ?>" class="btn btn-danger mt-3">Delete</a>
                                    </center>
                                </td>
                            </tr>

                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
    <script>
        // ฟังก์ชันเพื่อเปลี่ยนสีของเซลล์ที่มีข้อความเป็น "สำเร็จ"
        function changeCellColor() {
            // เลือกทุกเซลล์ในตาราง
            const cells = document.querySelectorAll('table td');

            // ตรวจสอบแต่ละเซลล์
            cells.forEach(cell => {
                if (cell.textContent.trim() === 'จัดส่งสําเร็จ') {
                    cell.style.backgroundColor = 'green';
                } else if (cell.textContent.trim() === 'รอดำเนินการ' || cell.textContent.trim() === 'กำลังจัดส่ง') {
                    cell.style.backgroundColor = 'orange';
                }
            });
        }

        // เรียกใช้ฟังก์ชันเมื่อโหลดหน้าเสร็จแล้ว
        window.onload = changeCellColor;
    </script>
</html>