<?php
session_start();
if (!isset($_SESSION['is_login']) && !$_SESSION['is_login']) {
    header('Location:login.php');
} ?>

<!doctype html>
<html class="loading" lang="en" data-textdirection="ltr">
<?php
include "partial/header.php";
?>

<body class="vertical-layout vertical-menu-modern 2-columns   menu-expanded fixed-navbar" data-open="click"
      data-menu="vertical-menu-modern" data-col="2-columns">
<!-- fixed-top-->
<?php include "partial/nav.php" ?>
<?php include "partial/sidebar.php" ?>

<div class="app-content content">
    <div class="content-wrapper">

        <div class="content-body">
            <section id="basic-form-layouts">
                <div class="row match-height">
                    <div class="col-md-12">

                        <div class="card-content">
                            <div class="card-body">
                                <div class="content-body">
                                    <section id="dom">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card">


                                                    <div class="card-content">
                                                        <div class="container col-md-12" style="padding: 10px">
                                                            <table class="table display nowrap table-striped table-bordered scroll-horizontal ">
                                                                <thead>
                                                                <tr>
                                                                    <th>Product ID</th>
                                                                    <th> Product Name</th>
                                                                    <th>Primary Category</th>
                                                                    <th>Secondary Category</th>
                                                                    <th>Image</th>
                                                                    <th>price</th>
                                                                    <th>Description</th>
                                                                    <th>Update</th>
                                                                    <th>Delete</th>

                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php
                                                                $limit = 3;
                                                                $page = $_GET['page'] ?? 1;
                                                                $offset = ($page - 1) * $limit;
                                                                $sql = "SELECT * FROM products limit $limit offset $offset";
                                                                $result = mysqli_query($connection, $sql);
                                                                if (mysqli_num_rows($result) > 0) {
                                                                    while ($row = mysqli_fetch_assoc($result)) {


                                                                        echo "<tr>" .
                                                                            "<td>" . $row['id'] . "</td>" .
                                                                            "<td>" . $row['name'] . "</td>" .
                                                                            "<td>" . $row['pc_id'] . "</td>" .
                                                                            "<td>" . $row['sc_id'] . "</td>" .
                                                                            "<td>" .

                                                                            "<img src='uploads/images/" . $row['image'] . "' alt='' width='50' height='30'>" . "</td>" .
                                                                            "<td>" . $row['price'] . "</td>" .
                                                                            "<td>" . $row['description'] . "</td>" .
                                                                            "<td>
                                                                                <a href='update_product.php?id=" . $row['id'] . "' 
                                                                                class='btn btn-outline-primary  box-shadow-3 mr-1 mb-1'>
                                                                                <i class='icon-pencil'></i></a>" . "</td>"
                                                                            . "<td><form class='p_form' action='delete_product.php'method='GET'>
                                                                                  <input type='hidden' value='" . $row['id'] . "' name='id'>
                                                                                  <input type='hidden' value='" . $row['image'] . "' name='image'>
                                                                                  <button type='submit' class='btn btn-danger delete_product'
                                                                                   id='delete-btn'>DELETE</button>
                                                                                   </form>
                                                                                   </td>"
                                                                            . "</tr>";
                                                                    }
                                                                }

                                                                ?>

                                                                </tbody>
                                                            </table>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="justify-content-center d-flex">
                    <div class="row">
                        <div class="col-12">
                            <?php
                            $query = "SELECT count(id) as row_no from products";
                            $result = mysqli_query($connection, $query);
                            $row = mysqli_fetch_assoc($result);
                            $page_count = ceil($row['row_no'] / $limit);
                            echo "<ul class='pagination'>";
                            for ($i = 1; $i <= $page_count; $i++) {
                                echo "<li class='page-item'><a class='page-link' href='show_all_products.php?page=$i'>$i</a></li>";
                            }


                            ?>



                        </div>

                    </div>
                </div>


            </section>
        </div>
    </div>
</div>


<?php
include "partial/footer.php";
?>


</body>

</html>