<?php
session_start();
if (!isset($_SESSION['is_login']) && !$_SESSION['is_login']) {
    header('Location:login.php');
}
$emailUser = $_SESSION['email'];
include 'partial/DB_connection.php';
$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = $_POST['name'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $address = $_POST['address'];
    $description = $_POST['description'];


    if (empty($_POST["name"])) {
        $errors['name_error'] = "Name is required";
    }
    if (empty($_POST["phone_number"])) {
        $errors['phone_number_error'] = "Phone number is required";
    }
    if (empty($_POST["email"])) {
        $errors['email_error'] = "Email is required";
    }

    if (empty($_POST["address"])) {
        $errors['address_error'] = "Address is required";
    }
    if (empty($description)) {
        $errors['description_errror'] = "Description is required";
    }

    if (count($errors) > 0) {
        $errors['general_error'] = "Please fix all errors";
    } else {
        if (empty($_POST["password"])) {
            $query = "UPDATE admins 
        SET name='$name',phone_number='$phone_number',email='$email',
        description='$description',address='$address'
        where id=" . $_GET['id'];
        } else {
            $query = "UPDATE admins 
        SET name='$name',phone_number='$phone_number',email='$email',password='$password',
        description='$description',address='$address'
        where id=" . $_GET['id'];
        }


        $result = mysqli_query($connection, $query);
        if ($result) {
            $errors = [];
            $success = true;
            header('Location:show_all_admins.php');
        } else {
            $errors['general_error'] = "please fix all errors";
        }
    }
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query1 = "select * from admins where id = $id";
    $result1 = mysqli_query($connection, $query1);
    $row = mysqli_fetch_assoc($result1);
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
                                        Admins</a>
                                </li>
                                <li class="breadcrumb-item active">Update Admin
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
                                                echo "<div class='alert alert-success'>Admin Added Successfully</div>";
                                            }


                                            ?>
                                            <form class="form" action="<?php echo $_SERVER['PHP_SELF'] . "?id=" . $_GET['id'] ?>" method="post" enctype="multipart/form-data">
                                                <div class="form-body">
                                                    <h4 class="form-section"><i class="ft-home"></i>Update Admin
                                                    </h4>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="name_ar"> Name </label>
                                                                <input type="text" id="name_ar" class="form-control" value="<?php echo $row['name'] ?>" placeholder="Enter Name Of Admin" name="name">
                                                                <span class="text-danger errors">
                                                                    <?php
                                                                    if (isset($errors['name_error'])) {
                                                                        print_r($errors['name_error']);
                                                                    }

                                                                    ?>

                                                                </span>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="phone_number"> Phone Number </label>
                                                                <input type="text" id="phone_number" class="form-control" placeholder="Enter Phone Number" name="phone_number" value="<?php echo $row['phone_number'] ?>">
                                                                <span class=" text-danger errors">
                                                                    <?php
                                                                    if (isset($errors['phone_number_error'])) {
                                                                        print_r($errors['phone_number_error']);
                                                                    }

                                                                    ?>

                                                                </span>

                                                            </div>
                                                        </div>


                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="email"> Email </label>
                                                                <input type="email" id="email" class="form-control" placeholder="Enter The Email" name="email" value="<?php echo $row['email'] ?>">
                                                                <span class=" text-danger errors">
                                                                    <?php
                                                                    if (isset($errors['email_error'])) {
                                                                        print_r($errors['email_error']);
                                                                    }
                                                                    ?>

                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="password"> Password </label>
                                                                <input type="password" name='password' class="form-control form-control-lg input-lg" id="user-password" placeholder="Enter New Password">
                                                                <?php
                                                                if (!empty($errors['password_error'])) {
                                                                    echo "<span class='text-danger'>" . $errors["password_error"] . "</span>";
                                                                }
                                                                ?>

                                                            </div>
                                                        </div>


                                                    </div>


                                                    <div class=" row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="address"> Address </label>
                                                                <input type="text" id="address" class="form-control" placeholder="Enter The Admin Address" name="address" value="<?php echo $row['address'] ?>">
                                                                <span class=" text-danger errors">
                                                                    <?php
                                                                    if (isset($errors['address_error'])) {
                                                                        print_r($errors['address_error']);
                                                                    }
                                                                    ?>

                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="description"> Description </label>
                                                                <input type="text" id="description" class="form-control" placeholder="Enter the admin's address" name="description" value="<?php echo $row['description'] ?>">
                                                                <span class=" text-danger errors">
                                                                    <?php
                                                                    if (isset($errors['description_error'])) {
                                                                        print_r($errors['description_error']);
                                                                    }
                                                                    ?>

                                                                </span>
                                                            </div>
                                                        </div>


                                                    </div>
                                                    <div class="row">

                                                        <div class="form-group mt-1 col-lg-6">

                                                            <input type="checkbox" value="1" name="active" id="switcheryColor4" class="switchery" data-color="success" <?php
                                                                                                                                                                        if ($row['status'] == 1) {
                                                                                                                                                                            echo "checked";
                                                                                                                                                                        }
                                                                                                                                                                        ?> disabled />
                                                            <label for="switcheryColor4" class="card-title ml-2  mr-2"><b>Status(Active/ Blocked)</b>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>




                                                <div class="form-actions">
                                                    <button type="button" class="btn btn-warning mr-1" onclick="history.back();">
                                                        <i class="ft-x"></i> Back
                                                    </button>
                                                    <button type="submit" id="btn_create_product" class="btn btn-primary">
                                                        <i class="la la-check-square-o"></i> Update
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