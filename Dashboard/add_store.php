<?php
session_start();
if (!isset($_SESSION['is_login']) && !$_SESSION['is_login']) {
    header('Location:login.php');
}
include 'partial/DB_connection.php';
$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = strtoupper($_POST['name']);
    $description = $_POST['description'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $file_name = $_FILES['image']['name'];
    $category_id = $_POST['category_id'];


    if (empty($name)) {
        $errors['name'] = "Name is required";
    }
    if (empty($description)) {
        $errors['description'] = "description is required";
    }
    if (empty($address)) {
        $errors['address'] = "address is required";
    }
    if (empty($phone)) {
        $errors['phone'] = "phone is required";
    }

    if (empty($file_name)) {
        $errors['image'] = "Image is required";
    }


    if (count($errors) > 0) {
        $errors['general_error'] = "please fix all errors";
    } else {
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_type = $_FILES['image']['type'];
        $file_tmp_name = $_FILES['image']['tmp_name'];
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $file_new_name = time() . rand(1, 100000) . "." . $file_ext;

        $upload_path = 'uploads/images/' . $file_new_name;
        move_uploaded_file($file_tmp_name, $upload_path);

        $query = "INSERT INTO stores (name,description,address,phone,image,category_id)
        VALUES('$name','$description','$address','$phone','$file_new_name',$category_id)";
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

<body class="vertical-layout vertical-menu-modern 2-columns   menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">

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
                                <li class="breadcrumb-item active">Add Store
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Basic form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form"></h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-content collapse show">
                                        <div class="card-body">
                                            <?php
                                            if (!empty($errors['general_error'])) {
                                                echo "<div class='alert alert-danger'>" . $errors['general_error'] . "</div>";
                                            } elseif ($success) {
                                                echo "<div class='alert alert-success'>Store Added Successfully</div>";
                                            }


                                            ?>
                                            <form class="form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                                                <div class="form-body">
                                                    <h4 class="form-section"><i class="ft-home"></i>Add Store
                                                    </h4>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="name"> Name </label>
                                                                <input type="text" id="name" class="form-control" placeholder="Enter Name Of Store" name="name">
                                                                <span class="text-danger errors">
                                                                    <?php
                                                                    if (isset($errors['name'])) {
                                                                        print_r($errors['name']);
                                                                    }

                                                                    ?>

                                                                </span>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="description"> Description </label>
                                                                <input type="text" id="description" class="form-control" placeholder="Enter description Of Store" name="description">
                                                                <span class="text-danger errors">
                                                                    <?php
                                                                    if (isset($errors['description'])) {
                                                                        print_r($errors['description']);
                                                                    }

                                                                    ?>

                                                                </span>

                                                            </div>
                                                        </div>


                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="address"> Address </label>
                                                                <input type="text" id="address" class="form-control" placeholder="Enter Address of Store" name="address">
                                                                <span class="text-danger errors">
                                                                    <?php
                                                                    if (isset($errors['address'])) {
                                                                        print_r($errors['address']);
                                                                    }
                                                                    ?>

                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="phone"> Phone </label>
                                                                <input type="text" id="phone" class="form-control" placeholder="Phone of Store" name="phone">
                                                                <span class="text-danger errors">
                                                                    <?php
                                                                    if (isset($errors['phone'])) {
                                                                        print_r($errors['phone']);
                                                                    }
                                                                    ?>

                                                                </span>
                                                            </div>
                                                        </div>


                                                    </div>


                                                    <div class="row">

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="name"> Category </label>
                                                                <select class="form-control" name="category_id">
                                                                    <?php
                                                                    include 'DB_CONNECTION.php';
                                                                    $query = "SELECT * from categories";
                                                                    $result = mysqli_query($connection, $query);
                                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                                        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                                                    }


                                                                    ?>
                                                                </select>

                                                                <span class="text-danger errors">
                                                                    <?php
                                                                    if (isset($errors['category_id'])) {
                                                                        print_r($errors['category_id']);
                                                                    }
                                                                    ?>

                                                                </span>
                                                            </div>

                                                        </div>


                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="name"> Logo Image </label>
                                                                <input type="file" multiple class="form-control" name="image">
                                                                <span class="text-danger errors">
                                                                    <?php
                                                                    if (isset($errors['image'])) {
                                                                        print_r($errors['image']);
                                                                    }
                                                                    ?>

                                                                </span>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <section id="chkbox-radio">
                                                    <div class="row">


                                                    </div>

                                                </section>


                                                <div class="form-actions">
                                                    <button type="button" class="btn btn-warning mr-1" onclick="history.back();">
                                                        <i class="ft-x"></i> Back
                                                    </button>
                                                    <button type="submit" id="btn_create_product" class="btn btn-primary">
                                                        <i class="la la-check-square-o"></i> Save
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- // Basic form layout section end -->
            </div>
        </div>
    </div>
    <?php
    include "partial/footer.php";
    ?>
</body>

</html>