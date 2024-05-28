<?php
    require_once '../connection.php';

    if (isset($_REQUEST['update_id'])) {
        try {
            $id = $_REQUEST['update_id'];
            $select_stmt = $db->prepare("SELECT * FROM sp_product WHERE id = :id");
            $select_stmt->bindParam(':id', $id);
            $select_stmt->execute();
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
        } catch(PDOException $e) {
            $e->getMessage();
        }
    }

    if (isset($_REQUEST['btn_update'])) {
        $id_up = $_REQUEST['txt_id'];

        $image_up = $_REQUEST['txt_image'];
        $name_up = $_REQUEST['txt_name'];
        $price_up = $_REQUEST['txt_price'];
        $type_up = $_REQUEST['txt_type'];
        $description_up = $_REQUEST['txt_description'];

        if (empty($id_up)) {
            $errorMsg = 'Please enter Id';
        } else if (empty($image_up)) {
            $errorMsg = 'Please enter Image';
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
                    $update_stmt = $db->prepare("UPDATE sp_product SET id = :id_up, image = :image_up, name = :name_up, price = :price_up, type = :type_up, description = :description_up WHERE id = :id");
                    $update_stmt->bindParam(':id_up', $id_up);
                    $update_stmt->bindParam(':image_up', $image_up);
                    $update_stmt->bindParam(':name_up', $name_up);
                    $update_stmt->bindParam(':price_up', $price_up);
                    $update_stmt->bindParam(':type_up', $type_up);
                    $update_stmt->bindParam(':description_up', $description_up);
                    $update_stmt->bindParam(':id', $id);

                    if ($update_stmt->execute()) {
                        $updateMsg = "Record update successfully...";
                        header("refresh:1;product_list.php");
                    }
                }
            } catch(PDOException $e) {
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
    <title>Edit Product</title>

    <link rel="stylesheet" href="css/admin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

    <div class="container">
    <div class="div1">
        <h2 class="div-login-register"><img src="img/Edit.png" width="70px" class="img">Edit Product</h2>
        <hr>

    <?php
        if(isset($errorMsg)) {
    ?>
        <div class="alert alert-danger">
            <strong>Wrong! <?php echo $errorMsg; ?></strong>
        </div>
    <?php } ?>

    <?php
        if(isset($updateMsg)) {
    ?>
        <div class="alert alert-success">
            <strong>Success! <?php echo $updateMsg; ?></strong>
        </div>
    <?php } ?>

    <form method="post" class="form-horizontal">
        <div class="form-group">
            <label for="id" class="col-sm-3 control-label">Id</label>
            <div>
                <input type="text" name="txt_id" class="form-control" value="<?php echo $id; ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="image" class="col-sm-3 control-label">Image</label>
            <div>
                <input type="file" name="txt_image" class="form-control" value="<?php echo $img; ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="name" class="col-sm-3 control-label">Name</label>
            <div>
                <input type="text" name="txt_name" class="form-control" value="<?php echo $name; ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="price" class="col-sm-3 control-label">Price</label>
            <div>
                <input type="text" name="txt_price" class="form-control" value="<?php echo $price; ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="type" class="col-sm-3 control-label">Type</label>
            <div>
                <input type="text" name="txt_type" class="form-control" value="<?php echo $type; ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="description" class="col-sm-3 control-label">Description</label>
            <div>
                <input type="text" name="txt_description" class="form-control" value="<?php echo $description; ?>">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9 mt-4">
                <input type="submit" name="btn_update" class="btn btn-success" value="Update">
                <a href="product_list.php" class="btn btn-danger">Cancel</a>
            </div>
        </div>

    </form>
    </div>
</body>
</html>