<?php
    session_start();
    if (!isset($_SESSION['admin_login'])) {
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

        header('Location:customer_list.php');
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
        <div class="container1">
            <div class="sidebar">
                <input type="text" class="sidebar-search" placeholder="Search">

                <a href="admin_home.php" class="sidebar-menu">
                    หน้าแรก
                </a>

                <a href="admin_administrator.php" class="sidebar-menu">
                    ผู้ดูแลระบบ
                </a>

                <a href="#" class="sidebar-menu">
                    รายชื่อลูกค้า
                </a>

                <a href="#" class="sidebar-menu">
                    รายการสินค้า
                </a>

                <a href="#" class="sidebar-menu">
                    ประวัติรายการสั่งซื้อ
                </a>

            </div>

            <div class="filter">
                <div class="display-5 text-center">Customer List</div>
                <a href="add_user.php" class="btn btn-primary mt-3">Add +</a>
                <table class="table table-striped table-bordered table-hover mt-3">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Role</th>
                            <th>Phone</th>
                            <th>Edit and Delete</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            $select_stmt = $db->prepare("SELECT * FROM masterlogin WHERE role = 'user'");
                            $select_stmt->execute();
                            while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                        ?>

                            <tr>
                                <td><?php echo $row["id"]; ?></td>
                                <td><?php echo $row["firstname"]; ?></td>
                                <td><?php echo $row["lastname"]; ?></td>
                                <td><?php echo $row["username"]; ?></td>
                                <td><?php echo $row["email"]; ?></td>
                                <td><?php echo $row["password"]; ?></td>
                                <td><?php echo $row["role"]; ?></td>
                                <td><?php echo $row["phone"]; ?></td>
                                <td class="mt-5">
                                    <a href="edit_user.php?update_id=<?php echo $row["id"]; ?>" class="btn btn-success">Edit</a>
                                    <a href="?delete_id=<?php echo $row["id"]; ?>" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>

                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>