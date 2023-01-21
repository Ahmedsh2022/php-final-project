<?php
session_start();
if (!isset($_SESSION['is_login']) && !$_SESSION['is_login']) {
    header('Location:login.php');
}
include 'partial/DB_CONNECTION.php';
$errors = [];
$success = false;

if (isset($_POST["p_update"])) {

    $p_name = $_POST["p_name"];
    $p_price = floatval($_POST["p_price"]);
    $c_id = $_POST['pc_id'];
    $sc_id = $_POST['sc_id'];
    if (isset($_POST['check_image_updaate'])) {
        $p_image_name = $_FILES['p_image']['name'];
        if (empty($p_image_name)) {
            $errors['image_error'] = "Image is required, please fill it";
        }
    }
    $description = $_POST['p_description'];


    if (empty($p_name)) {
        $errors['name_error'] = "*Name is required, please fill it";
    }

    if (empty($p_price)) {
        $errors['price_error'] = "*Price is required, please fill it";
    }


    if (count($errors) > 0) {
        $errors['general_error'] = "please fix all errors";
    } else {
        if (isset($_POST['check_image_updaate'])) {
            $file_name = $_FILES['p_image']['name'];
            $file_size = $_FILES['p_image']['size'];
            $file_type = $_FILES['p_image']['type'];
            $file_tmp_name = $_FILES['p_image']['tmp_name'];
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $file_new_name = $p_name . "" . time() . rand(1, 100000) . "." . $file_ext;

            $upload_path = 'uploads/images/' . $file_new_name;
            move_uploaded_file($file_tmp_name, $upload_path);

            $query20 = "UPDATE products 
            SET name='$p_name',price='$p_price',pc_id='$c_id',
            image='$file_new_name',sc_id='$sc_id',description='$description' 
            where id = '" . $_GET['id'] . "'";
        } else {
            $query20 = "UPDATE products 
            SET name='$p_name',price='$p_price',pc_id='$c_id',sc_id='$sc_id',description='$description'
             where id = '" . $_GET['id'] . "'";
        }

        $result20 = mysqli_query($connection, $query20);
        if ($result20) {
            $errors = [];
            $success = true;
            header('Location:show_all_products.php');
        } else {
            $errors['general_error'] = "please fix all errors";
        }
    }

}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query1 = "select * from products where id = $id";
    $result1 = mysqli_query($connection, $query1);
    $row = mysqli_fetch_assoc($result1);
}
?>

<html>
<?php
include "partial/header.php";
?>

<body class="vertical-layout vertical-menu-modern 2-columns   menu-expanded fixed-navbar" data-open="click"
      data-menu="vertical-menu-modern" data-col="2-columns">

<?php
include "partial/nav.php";
include "partial/sidebar.php";
?>

<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">Main </a>
                            </li>
                            <li class="breadcrumb-item"><a href="">
                                    Products</a>
                            </li>
                            <li class="breadcrumb-item active">Update Product
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- Basic form layout section start -->
            <div class="container">

                <div class="d-flex justify-content-center align-items-center">
                    <div class="card mt-4 col-md-12">
                        <div class="card-body">
                            <?php
                            if (!empty($errors['general_error'])) {
                                echo "<div class='alert alert-danger'>" . $errors["general_error"] . "</div>";
                            } elseif ($success) {
                                echo "<div class='alert alert-success'>Product Updated Succesfully</div>";
                            }
                            ?>
                            <form class="form" method="post"
                                  action=" <?php echo $_SERVER['PHP_SELF'] . "?id=" . $_GET['id'] ?>"
                                  enctype="multipart/form-data">
                                <div class="form-body ">
                                    <h4 class="form-section text-center"><i class="ft-user"></i>Update Product Details
                                    </h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput1">Product Name</label>
                                                <input type="text" class="form-control mx-auto"
                                                       placeholder="Product Name" name="p_name"
                                                       value="<?php echo $row['name'] ?>">
                                                <?php
                                                if (!empty($errors['name_error'])) {
                                                    echo "<span class='text-danger'>" . $errors["name_error"] . "</span>";
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput2">Price</label>
                                                <input type="text" class="form-control mx-auto"
                                                       placeholder="Product Price" name="p_price"
                                                       value="<?php echo $row['price'] ?>">
                                                <?php
                                                if (!empty($errors['price_error'])) {
                                                    echo "<span class='text-danger'>" . $errors["price_error"] . "</span>";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="projectinput3">Description</label>
                                                <textarea type="number" min='1' class="form-control mx-auto"
                                                          name="p_description"
                                                ><?php echo $row['description'] ?> </textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="projectinput4">Primary Category</label>
                                                <select name="pc_id" class="form-control mx-auto">
                                                    <?php
                                                    $query1 = "select * from categories";
                                                    $result1 = mysqli_query($connection, $query1);
                                                    if (mysqli_num_rows($result1) > 0) {
                                                        while ($row1 = mysqli_fetch_assoc($result1)) {
                                                            if ($row['pc_id'] == $row1['id']) {
                                                                echo "<option class='form-control mx-auto' selected='' value='" . $row1['id'] . "'>" . $row1['name'] . "</option>";
                                                            } else {
                                                                echo "<option class='form-control mx-auto' value='" . $row1['id'] . "'>" . $row1['name'] . "</option>";
                                                            }
                                                        }
                                                    }
                                                    ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="projectinput4">Secondary Category</label>
                                                <select name="sc_id" class="form-control mx-auto">
                                                    <?php
                                                    $query1 = "select * from secondary_categories";
                                                    $result1 = mysqli_query($connection, $query1);
                                                    if (mysqli_num_rows($result1) > 0) {
                                                        while ($row1 = mysqli_fetch_assoc($result1)) {
                                                            if ($row['sc_id'] == $row1['id']) {
                                                                echo "<option class='form-control mx-auto' selected='' value='" . $row1['id'] . "'>" . $row1['name'] . "</option>";
                                                            } else {
                                                                echo "<option class='form-control mx-auto' value='" . $row1['id'] . "'>" . $row1['name'] . "</option>";
                                                            }
                                                        }
                                                    }
                                                    ?>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <img class=" border border-dark rounded d-block"
                                                 src="<?php echo "uploads/images/" . $row['image'] ?>"
                                                 width="200px"
                                                 height=200px;>

                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox mt-2">
                                                    <input type="checkbox" class="custom-control-input "
                                                           name='check_image_updaate' id="customCheck1">
                                                    <label class="custom-control-label" for="customCheck1">Update
                                                        Product Image</label>
                                                </div>

                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Upload Product Image</span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input"
                                                               id="inputGroupFile01" name="p_image">
                                                        <label class="custom-file-label" for="inputGroupFile01">Choose
                                                            Image</label>
                                                    </div>
                                                </div>
                                                <?php
                                                if (isset($_POST['image_update'])) {
                                                    if (!empty($errors['image_error'])) {
                                                        echo "<span class='text-danger'>" . $errors["image_error"] . "</span>";
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <button name="p_update" type="submit" class="btn btn-primary">
                                        <i class="la la-check-square-o"></i> Update Porduct
                                    </button>
                                    <a href="show_all_products.php">
                                        <button name="p_update" type="button" class="btn btn-warning mr-1 ">
                                            <i class="la la-check-square-o"></i> Cancel
                                        </button>
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
<?php
include "partial/footer.php";
?>
</body>

</html>