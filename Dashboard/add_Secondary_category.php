<?php
//Being sure of signning in
session_start();
if (!isset($_SESSION['is_login']) && !$_SESSION['is_login']) {
    header('Location:login.php');
}
//database connection
include "partial/DB_CONNECTION.php";
//for being sure there are no fails or errors
$errors = [];
$success = false;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //geting the super global variables
    $name = $_POST['c_name'];
    $pc_id = $_POST['pc_id'];
    $description = $_POST['c_description'];

    //vlaidation of all regarded fields with its convenient name
    if (empty($name)) {
        $errors['name_error'] = "*Name is required, please fill it";
    }
    if (empty($description)) {
        $description = 'No Description';
    }
    if (strcmp($pc_id, 'empty') == 0) {
        $errors['pc_id_error'] = "*please choose the primary category";
    }




    if (count($errors) > 0) {
        $errors['general_error'] = "*please fix all errors";
    } else {
        //if no failures add into database
        $query = "INSERT INTO secondary_categories (name,description,pc_id)
        VALUES('$name','$description','$pc_id')";
        $result = mysqli_query($connection, $query);
        if ($result) {
            $errors = [];
            $success = true;
        } else {
            $errors['general_error'] = "*please fix all errors";
        }
    }
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
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form">Category Info</h4>
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
                                            echo "<div class='alert alert-success'>Category Added Succesfully</div>";
                                        }
                                        ?>
                                        <form class="form" method="post" action=" <?php echo $_SERVER['PHP_SELF'] ?>">
                                            <div class="form-body">
                                                <h4 class="form-section"><i class="ft-user"></i>Add Secondary Category</h4>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="projectinput1">Category Name</label>
                                                            <input type="text" id="projectinput1" class="form-control" placeholder="Category Name" name="c_name">
                                                            <?php
                                                            if (!empty($errors['name_error'])) {
                                                                echo "<span class='text-danger'>" . $errors["name_error"] . "</span>";
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="projectinput2">Primary Category</label>
                                                            <select name="pc_id" class="form-control mx-auto">
                                                                <option value="empty" selected>Choose Primary Category</option>
                                                                <?php
                                                                $query1 = "select * from categories order by id";
                                                                $result1 = mysqli_query($connection, $query1);
                                                                if (mysqli_num_rows($result1) > 0) {
                                                                    while ($row1 = mysqli_fetch_assoc($result1)) {
                                                                        echo "<option class='' value='" . $row1['id'] . "'>" . $row1['name'] . "</option>";
                                                                    }
                                                                }
                                                                ?>

                                                            </select>
                                                            <?php
                                                            if (!empty($errors['pc_id_error'])) {
                                                                echo "<span class='text-danger'>" . $errors['pc_id_error'] . "</span>";
                                                            }
                                                            ?>
                                                            <?php
                                                            if (!empty($errors['c_error'])) {
                                                                echo "<span class='text-danger'>" . $errors["c_error"] . "</span>";
                                                            }
                                                            ?>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="projectinput2">Category Description (Optional)</label>
                                                            <br>
                                                            <textarea class="form-control" id="projectinput2" rows="3" name="c_description"></textarea>
                                                            <?php
                                                            if (!empty($errors['description_error'])) {
                                                                echo "<span class='text-danger'>" . $errors['description_error'] . "</span>";
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="form-actions">
                                                <a href="show_secondary_categories.php">
                                                    <button type="button" class="btn btn-warning mr-1">
                                                        <i class="ft-x"></i> Cancel
                                                    </button>
                                                </a>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="la la-check-square-o"></i> Save
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