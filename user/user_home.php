<?php
    session_start();
    if (!isset($_SESSION['user_login'])) {
        header("location: ../index.php");
    }

    require_once 'connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USER PAGE</title>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                    <div class="itemcart ">
                            <a class="sidebar-menu-cart" onclick="openCart()">
                                <img style="width: 35px;" src="https://cdn.pixabay.com/photo/2014/06/19/00/59/shopping-cart-371980_1280.png" alt="">
                            </a>
                    </div>

                    <div class="filter">
                        <input onkeyup="searchsome(this)" id="txt_search" type="text" class="sidebar-search sidebar-menu-filter" placeholder="Search">

                        <br>

                        <a onclick="searchproduct('all')" class="sidebar-menu-filter" style="cursor: pointer;">
                            ทั้งหมด
                        </a>

                        <a id="menufilterlist"></a>
                

                        <div id="productlist" class="product"></div>
                        </div>
                    </div>
                </div>
            </div>

            
        </div>
    </div>

    <div id="modalDesc" class="modal" style="display: none;">
        <div class="modal-bg"></div>
        <div class="modal-page">
                <h2>Detail</h2>
                <div class="modaldesc-content">
                    <img id="mdd-img" class="modaldese-image" src="https://images.unsplash.com/photo-1531390979850-32568e0159ce?q=80&w=1031&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="">

                    <div class="modaldesc-detail">
                            <p id="productname" style="font-size: 1.5vw">Product Name</p>
                            <p id="price" style="font-size: 1.2vw">500 THB</p>
                            <br>
                            <p id="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolor, suscipit.</p>
                            <br>
                            <div class="btn-control">
                                <button onclick="cancelModal()" class="btn btn-danger">Cancel</button>
                                <button onclick="addtocart()" class="btn btn-success btn-add-to-card">Add to Cart</button>
                            </div>
                    </div>
                </div>
        </div>
    </div>

    <div id="modalCart" class="modal" style="display: none;">
        <div class="modal-bg"></div>
        <div class="modal-page">
                <h2>My Cart</h2>
                <div class="cartlist">
                    <div class="cartlist-item">

                        <div class="cartlist-left">
                            <img src="https://images.unsplash.com/photo-1531390979850-32568e0159ce?q=80&w=1031&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="">
                            <div class="cartlist-detail">
                                <p style="font-size: 1.5vw">Product name</p>
                                <p style="font-size: 1.2vw">500 THB</p>
                            </div>
                        </div>

                        <div class="cartlist-right">
                            <p class="btn-con" style="font-size: 1.5vw">-</p>
                            <p class="btn-text" style="font-size: 1.5vw">1</p>
                            <p class="btn-con" style="font-size: 1.5vw">+</p>
                        </div>
                    </div>
                </div>
                <div class="btn-control">
                    <button onclick="cancelModal()" class="btn btn-danger">Cancel</button>
                    <button class="btn btn-success btn-add-to-card">Buy</button>
                </div>
        </div>
    </div>

</body>
</html>