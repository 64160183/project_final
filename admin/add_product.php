<?php
    require_once '../connection.php';

    if (isset($_REQUEST['btn_insert'])) {
        $id_up = $_REQUEST['txt_id'];

        $name_up = $_REQUEST['txt_name'];

        $image_up = $_REQUEST['txt_image'];
    
        $price_up = $_REQUEST['txt_price'];
        $type_up = $_REQUEST['txt_type'];
        $description_up = $_REQUEST['txt_description'];


        if (empty($id_up)) {
            $errorMsg = 'Please enter Id';
        } else if (empty($image_up)) {
            $errorMsg = 'Please Secect Image';
        } else if (empty($name_up)) {
            $errorMsg = 'Please enter Name';
        } else if (empty($price_up)) {
            $errorMsg = 'Please enter Price';
        } else if (empty($type_up)) {
            $errorMsg[] = "Please enter Type";
        } else if (empty($description_up)) {
            $errorMsg = 'Please enter Description';
        } else {
            try {
                if (!isset($errorMsg)) {
                    $insert_stmt = $db->prepare("INSERT INTO sp_product(id, image, name, price, type, description) VALUES (:id, :image, :name, :price, :type, :description)");
                    $insert_stmt->bindParam(':id', $id_up);
                    $insert_stmt->bindParam(':image', $image_up);
                    $insert_stmt->bindParam(':name', $name_up);
                    $insert_stmt->bindParam(':price', $price_up);
                    $insert_stmt->bindParam(':type', $type_up);
                    $insert_stmt->bindParam(':description', $description_up);

                    if ($insert_stmt->execute()) {
                        $insertMsg = "Insert Successfully...";
                        header("refresh:1;product_list.php");
                    }
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>

    <link rel="stylesheet" href="css/admin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

    <div class="container">
    <div class="div1">
        <h2 class="div-login-register"><img src="img/add-user.png" width="70px" class="img">Add Product</h2>
        <hr>

    <?php
        if(isset($errorMsg)) {
    ?>
        <div class="alert alert-danger">
            <strong>Wrong! <?php echo $errorMsg; ?></strong>
        </div>
    <?php } ?>

    <?php
        if(isset($insertMsg)) {
    ?>
        <div class="alert alert-success">
            <strong>Success! <?php echo $insertMsg; ?></strong>
        </div>
    <?php } ?>

    <form method="post" class="form-horizontal">
        <div class="form-group">
            <label for="id" class="col-sm-3 control-label">Id</label>
            <div>
                <input type="text" name="txt_id" class="form-control" placeholder="Enter Id">
            </div>
        </div>

        <div class="form-group">
            <label for="image" class="col-sm-3 control-label">Image</label>
            <div>
                <input type="file" name="txt_image" class="form-control" placeholder="Select Image">
            </div>
        </div>

        <div class="form-group">
            <label for="name" class="col-sm-3 control-label">Name</label>
            <div>
                <input type="text" name="txt_name" class="form-control" placeholder="Enter Name">
            </div>
        </div>

        <div class="form-group">
            <label for="price" class="col-sm-3 control-label">Price</label>
            <div>
                <input type="text" name="txt_price" class="form-control" placeholder="Enter Price">
            </div>
        </div>

        <div class="form-group">
            <label for="type" class="col-sm-3 control-label">Type</label>
            <div>
                <input type="text" name="txt_type" class="form-control" placeholder="Enter Type">
            </div>
        </div>

        <div class="form-group">
            <label for="description" class="col-sm-3 control-label">Description</label>
            <div>
                <input type="text" name="txt_description" class="form-control" placeholder="Enter Description">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9 mt-4">
                <input type="submit" name="btn_insert" class="btn btn-success" value="Insert">
                <a href="product_list.php" class="btn btn-danger">Cancel</a>
            </div>
        </div>

    </form>
    </div>
</body>
</html>