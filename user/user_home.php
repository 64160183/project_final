<?php
    session_start();
    if (!isset($_SESSION['user_login'])) {
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
    <title>USER PAGE</title>

    <link rel="stylesheet" href="css/user.css">
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

            <h1>User Page</h1>
            <hr>

            <h3>
                <?php if(isset($_SESSION['user_login'])) { ?>
                Welcome, <?php echo $_SESSION['user_login']; }?>
                <a href="../logout.php" class="btn btn-danger">Logout</a>
            </h3>
        </div>
    </div>

    <div class="container background-container-menu">
        <div class="container1">
            <div class="sidebar">

                <a href="user_home.php" class="sidebar-menu">
                    สินค้า
                </a>

                <a href="#" class="sidebar-menu">
                    <img style="width: 35px;" src="https://cdn.pixabay.com/photo/2014/06/19/00/59/shopping-cart-371980_1280.png" alt="">
                </a>

                <hr>

                <?php
                    if (isset($_SESSION['user_login'])) {
                    $select_stmt = $db->prepare("SELECT * FROM masterlogin WHERE email = '".$_SESSION["user_login"]."'");
                    $select_stmt->execute();

                    while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>

                <a href="user_profile.php?update_id=<?php echo $row["id"]; ?>" class="sidebar-menu">
                    โปรไฟล์
                </a>    
                
                <?php } }?>

            </div>

            
            <div class="container">
            <div class="div1">
            <div class="filter">
                <a href="#" class="sidebar-menu-filter">
                    ทั้งหมด
                </a>
                <a href="#" class="sidebar-menu-filter">
                    sadsad
                </a>
                <div class="product">
                    <div class="product-item">
                        <a href="user_product.php">
                        <img class="product-img" src="" alt="">
                        <p style="font-size: 1.2vw;">Product name</p>
                        <p style="font-size: 0.9vw;">500THB</p></a>
                    </div>
                    <div class="product-item">
                        <img class="product-img" src="" alt="">
                        <p style="font-size: 1.2vw;">Product name</p>
                        <p style="font-size: 0.9vw;">500THB</p>
                    </div>
                    <div class="product-item">
                        <img class="product-img" src="" alt="">
                        <p style="font-size: 1.2vw;">Product name</p>
                        <p style="font-size: 0.9vw;">500THB</p>
                    </div>
                    <div class="product-item">
                        <img class="product-img" src="" alt="">
                        <p style="font-size: 1.2vw;">Product name</p>
                        <p style="font-size: 0.9vw;">500THB</p>
                    </div>
                    <div class="product-item">
                        <img class="product-img" src="" alt="">
                        <p style="font-size: 1.2vw;">Product name</p>
                        <p style="font-size: 0.9vw;">500THB</p>
                    </div>
                </div>
            </div>
            </div>


            
        </div>
    </div>


</body>
</html>