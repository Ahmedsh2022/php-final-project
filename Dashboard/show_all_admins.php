<?php
session_start();
if (!isset($_SESSION['is_login']) && !$_SESSION['is_login']) {
    header('Location:login.php');
}
$email = $_SESSION['email'];
?>

<!doctype html>
<html class="loading" lang="en" data-textdirection="ltr">
<?php
include "partial/header.php";
?>

<body class="vertical-layout vertical-menu-modern 2-columns   menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
    <!-- fixed-top-->
    <?php

    include "partial/nav.php";
    include "partial/sidebar.php";

    ?>
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section id="dom">
                    <div class="row" style="box-sizing: border-box;">
                        <div class="col-12">
                            <div class="card" style="box-sizing: border-box;">
                                <div class="card-header">
                                    <h4 class="card-title">Admins </h4>
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

                                <div class="card-content collapse show" style="box-sizing: border-box;">
                                    <div class="card-body card-dashboard" style="box-sizing: border-box;">
                                        <table style="box-sizing: border-box; max-width: 600px;  margin: 0 auto;" class="table display nowrap table-striped table-bordered scroll-horizontal" width="100%">
                                            <thead>

                                                <tr>
                                                    <th>Admin ID</th>
                                                    <th>Admin Name</th>
                                                    <th> Username</th>
                                                    <th> Email </th>
                                                    <th> Country </th>
                                                    <th> Gender </th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                include_once "partial/DB_CONNECTION.php";
                                                $limit = 3;
                                                $page = $_GET['page'] ?? 1;
                                                $offset = ($page - 1) * $limit;
                                                $query9 = "select * from admins limit $limit offset $offset";

                                                $result9 = mysqli_query($connection, $query9);
                                                if (mysqli_num_rows($result9) > 0) {

                                                    while ($row9 = mysqli_fetch_assoc($result9)) {
                                                        if($row9['gender']){
                                                            $gender = "Female";
                                                        }else{
                                                            $gender = "Male";
                                                        }
                                                        echo   '<tr>' . '<td> ' . $row9['id'] . '</td>' . '<td>' . $row9['name'] . '</td>' . '<td>' . $row9['username'] . '</td>' .
                                                            '<td>' . $row9['email'] . '</td>' . '<td>' . $row9['country'] . '</td>' . '<td>' .  $gender . '</td>' .
                                                            '</tr>';
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
                    <div class="justify-content-center d-flex">
                        <div class="row">
                            <div class="col-12">
                                <?php
                                $query = "SELECT count(id) as row_no from admins";
                                $result = mysqli_query($connection, $query);
                                $row = mysqli_fetch_assoc($result);
                                $page_count = ceil($row['row_no'] / $limit);
                                echo "<ul class='pagination'>";
                                for ($i = 1; $i <= $page_count; $i++) {
                                    echo "<li class='page-item'><a class='page-link' href='show_all_admins.php?page=$i'>$i</a></li>";
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