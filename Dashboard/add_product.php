<?php
session_start();
if (!isset($_SESSION['is_login']) && !$_SESSION['is_login']) {
    header('Location:login.php');
}
include 'partial/DB_connection.php';
$errors = [];
$success = false;

if (isset($_POST["p_add"]) && $_SERVER["REQUEST_METHOD"] == "POST") {

    $p_name = $_POST["p_name"];
    $p_price = floatval($_POST["p_price"]);
    $c_id = $_POST['c_id'];
    $sc_id = $_POST['sc_id'];
    $p_image_name = $_FILES['p_image']['name'];
    $description = $_POST['p_description'];


    if (empty($p_name)) {
        $errors['name_error'] = "*Name is required, please fill it";
    }
    if (empty($description)) {
        $description = "No Description";
    }
    if (empty($p_price)) {
        $errors['price_error'] = "*Price is required, please fill it";
    }
    if (strcmp($c_id, 'empty') == 0) {
        $errors['c_error'] = "*Primary Category is required, please fill it";
    }
    if (strcmp($sc_id, 'empty') == 0) {
        $errors['sc_error'] = "*Secondary Category is required, please fill it";
    }
    if (empty($p_image_name)) {
        $errors['image_error'] = "*Image is required, please fill it";
    }

    if (count($errors) > 0) {
        $errors['general_error'] = "please fix all errors";
    } else {
        $file_name = $_FILES['p_image']['name'];
        $file_size = $_FILES['p_image']['size'];
        $file_type = $_FILES['p_image']['type'];
        $file_tmp_name = $_FILES['p_image']['tmp_name'];
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $file_new_name = $p_name . "" . time() . rand(1, 100000) . "." . $file_ext;

        $upload_path = 'uploads/images/' . $file_new_name;
        move_uploaded_file($file_tmp_name, $upload_path);

        $query = "INSERT INTO products (name,price,pc_id,image,sc_id,description)
        VALUES('$p_name','$p_price','$c_id','$file_new_name','$sc_id','$description')";
        $result = mysqli_query($connection, $query);
        if ($result) {
            $errors = [];
            $success = true;
        } else {
            $errors['general_error'] = "please fix all errors";
        }
    }
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
                            <li class="breadcrumb-item active">Add Product
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
                                echo "<div class='alert alert-success'>Product Added Succesfully</div>";
                            }
                            ?>
                            <form class="form" method="post" action="" enctype="multipart/form-data">
                                <div class="form-body ">
                                    <h4 class="form-section text-center"><i class="ft-user"></i>Add Product Details</h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput1">Product Name</label>
                                                <input type="text" class="form-control mx-auto"
                                                       placeholder="Product Name" name="p_name">
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
                                                       placeholder="Product Price" name="p_price">
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
                                                <label for="projectinput4">Primary Category</label>
                                                <select name="c_id" class="form-control mx-auto">
                                                    <option value="empty" selected>Choose Primary Category</option>
                                                    <?php
                                                    $query = "select * from categories order by id";
                                                    $result = mysqli_query($connection, $query);
                                                    if (mysqli_num_rows($result) > 0) {
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            echo "<option class='form-control mx-auto' value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                                        }
                                                    }
                                                    ?>

                                                </select>
                                                <?php
                                                if (!empty($errors['c_error'])) {
                                                    echo "<span class='text-danger'>" . $errors["c_error"] . "</span>";
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="projectinput4">Secondaary Category</label>
                                                <select name="sc_id" class="form-control mx-auto">
                                                    <option value="empty" selected>Choose Secondary Category</option>
                                                    <?php
                                                    $query = "select * from secondary_categories order by id";
                                                    $result = mysqli_query($connection, $query);
                                                    if (mysqli_num_rows($result) > 0) {
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            echo "<option class='form-control mx-auto' value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                                        }
                                                    }
                                                    ?>

                                                </select>
                                                <?php
                                                if (!empty($errors['sc_error'])) {
                                                    echo "<span class='text-danger'>" . $errors["sc_error"] . "</span>";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="projectinput2">Product Description (Optional)</label>
                                                <br>
                                                <textarea class="form-control" id="projectinput2" rows="3"
                                                          name="p_description"></textarea>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
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
                                            if (!empty($errors['image_error'])) {
                                                echo "<span class='text-danger'>" . $errors["image_error"] . "</span>";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <a href="show_all_products.php">
                                        <button type="button" class="btn btn-warning mr-1">
                                            <i class="ft-x"></i> Cancel
                                        </button>
                                    </a>
                                    <button name="p_add" type="submit" class="btn btn-primary">
                                        <i class="la la-check-square-o"></i> Add Porduct
                                    </button>
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