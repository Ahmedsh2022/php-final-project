<?php
session_start();
if (!isset($_SESSION['is_login']) && !$_SESSION['is_login']) {
    header('Location:login.php');
}
require_once "partial/DB_CONNECTION.php";
$errors = [];
$success = false;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['c_name'];


    if (empty($name)) {
        $errors['name_error'] = "Name is required, please fill it";
    }
    


    if (count($errors) > 0) {
        $errors['general_error'] = "please fix all errors";
    } else {
        $query = "update categories set name='$name' where id =" . $_GET['id'];
        $result = mysqli_query($connection, $query);
        if ($result) {
            $errors = [];
            $success = true;
            header('Location:show_category.php');
        } else {
            $errors['general_error'] = "please fix all errors";
        }
    }
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "select * from categories where id = $id";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);
}


?>

<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">


<?php
include "partial/header.php";
?>

<body class="vertical-layout vertical-menu-modern 2-columns   menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
    <!-- fixed-top-->
    <?php include "partial/nav.php" ?>
    <?php include "partial/sidebar.php" ?>

    <!-- ////////////////////////////////////////////////////////////////////////////-->

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Basic form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height d-flex align-items-center justify-content-center">
                        <div class="col-md-6  ">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form">Update Category</h4>
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
                                    <div class="card-body">
                                        <?php
                                        if (!empty($errors['general_error'])) {
                                            echo "<div class='alert alert-danger'>" . $errors["general_error"] . "</div>";
                                        } elseif ($success) {
                                            echo "<div class='alert alert-success'>Category Updated Succesfully</div>";
                                        }
                                        ?>
                                        <form class="form" method="post" action=" <?php echo $_SERVER['PHP_SELF'] . "?id=" . $_GET['id'] ?>">
                                            <div class="form-body">
                                                <h4 class="form-section"><i class="ft-user"></i>Edit Category</h4>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="projectinput1">Category Name</label>
                                                            <input type="text" id="projectinput1" class="form-control" placeholder="Category Name" name="c_name" value="<?php
                                                                                                                                                                        echo $row['name']
                                                                                                                                                                        ?>" />
                                                            <?php
                                                            if (!empty($errors['name_error'])) {
                                                                echo "<span class='text-danger'>" . $errors["name_error"] . "</span>";
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    
                                                </div>

                                            </div>
                                            <div class="form-actions">
                                                <a href="show_category.php"> <button type="button" class="btn btn-warning mr-1">
                                                        <i class="ft-x"></i> Cancel
                                                    </button></a>

                                                <button type="submit" class="btn btn-primary">
                                                    <i class="la la-check-square-o"></i> Update
                                                </button>
                                            </div>
                                        </form>
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
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <?php
    include "partial/footer.php";
    ?>
</body>

</html>