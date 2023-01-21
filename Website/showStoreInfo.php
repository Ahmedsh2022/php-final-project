<?php
include_once "../Dashboard/partial/DB_CONNECTION.php";
$storeId = strtoupper($_GET['id']);
$query1 = "SELECT * from stores where id = '$storeId'";
$result1 = mysqli_query($connection, $query1);
$store = mysqli_fetch_assoc($result1);
$string = exec('getmac');
$mac = substr($string, 0, 17);

$query7 = "SELECT * from rating where store_id = '$storeId'";
$result7 = mysqli_query($connection, $query7);
$ratings = [];
$macs = [];
$isRatedfinal = false;

if (mysqli_num_rows($result7) > 0) {
    while ($rating = mysqli_fetch_assoc($result7)) {
        $ratings[] = $rating['rate'];
        $macs[] = $rating['macAdd'];
    }
};

$total = count($ratings);
$sum = array_sum($ratings) ?? 0;

if ($total == 0) {
    $average = 0;
} else {
    $average = ($sum / $total);
}


?>


<!DOCTYPE html>
<html lang="en">
<?php
include_once "partial/head.php";
?>

<body>
    <?php
    include_once "partial/header.php";
    include_once "partial/nav.php";
    ?>



    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- Product main img -->
                <div class="col-md-5 col-md-push-1">
                    <div id="product-main-img">
                        <div class="product-preview">
                            <?php
                            echo '<img src="http://localhost/iug1/Final%20Project/Dashboard/uploads/images/'.$store["image"] . '"alt="">';
                            ?>
                        </div>
                    </div>
                </div>
                <!-- /Product main img -->



                <!-- Product details -->
                <div style="margin-left: 10%;" class="col-md-5">
                    <div class="product-details" style="margin-top: 30%;">
                        <h2 class="product-name"><?php echo $store['name'] ?></h2>
                        <div>
                            <div class="product-rating">
                                <?php
                                $all = 5;
                                $now = intval($average);
                                for ($i = 0; $i < $now; $i++) {
                                    echo '<i class="fa fa-star"></i>';
                                    $all--;
                                }
                                while ($all != 0) {
                                    echo '<i class="fa fa-star-o"></i>';
                                    $all--;
                                }
                                ?>
                            </div>
                            <span class="review-link"><a data-toggle="tab" href="#tab3"><b> Review(s) | Add your review</b></a></span>
                        </div>

                        <p style="margin-top:1% ;"><?php echo $store['description'] ?></p>




                        <ul class="product-links">
                            <li>Category:</li>
                            <?php
                            include_once "../Dashboard/partial/DB_CONNECTION.php";
                            $query1 = "SELECT * from categories where id=" . $store['category_id'];
                            $result1 = mysqli_query($connection, $query1);
                            $row1 = mysqli_fetch_assoc($result1);
                            $id1 = $row1["id"];
                            $category = $row1["name"];
                            echo "<li><a href='show_stores.php?category_id=$id1'>" . $row1["name"] . "</a></li>";


                            ?>
                        </ul>


                    </div>
                </div>
                <!-- /Product details -->

                <!-- Product tab -->
                <div class="col-md-12">
                    <div id="product-tab">
                        <!-- product tab nav -->
                        <ul class="tab-nav">
                            <li class="active"><a data-toggle="tab" href="#tab1">Description</a></li>
                            <li><a data-toggle="tab" href="#tab3">Reviews <?php echo $total ?></a></li>
                        </ul>
                        <!-- /product tab nav -->

                        <!-- product tab content -->
                        <div class="tab-content">
                            <!-- tab1  -->
                            <div id="tab1" class="tab-pane fade in active">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p><?php echo $store['description'] ?></p>
                                    </div>
                                </div>
                            </div>
                            <!-- /tab1  -->



                            <!-- tab3  -->
                            <div id="tab3" class="tab-pane fade in">
                                <div class="row">
                                    <!-- Rating -->
                                    <div class="col-md-3" style="margin: 0% 5%;">
                                        <div id="rating">
                                            <div class="rating-avg">
                                                <span><?php printf("%.1f", $average)  ?></span>
                                                <div class="rating-stars">
                                                    <?php
                                                    $all = 5;
                                                    $now = intval($average);
                                                    for ($i = 0; $i < $now; $i++) {
                                                        echo '<i class="fa fa-star"></i>';
                                                        $all--;
                                                    }
                                                    while ($all != 0) {
                                                        echo '<i class="fa fa-star-o"></i>';
                                                        $all--;
                                                    }
                                                    ?>

                                                </div>
                                            </div>
                                            <ul class="rating">
                                                <?php

                                                for ($j = 5; $j > 0; $j--) {
                                                    echo '<li><div class="rating-stars">';
                                                    $all = 5;
                                                    $now = intval($j);
                                                    $rate = ($now / $all) * 100;
                                                    for ($i = 0; $i < $now; $i++) {
                                                        echo '<i class="fa fa-star"></i>';
                                                        $all--;
                                                    }
                                                    while ($all != 0) {
                                                        echo '<i class="fa fa-star-o"></i>';
                                                        $all--;
                                                    }

                                                    echo '</div>
                                                    <div class="rating-progress">
                                                        <div style="width:' . $rate . '%;"></div>
                                                    </div>
                                                    <span class="sum">' . $now . '</span>
                                                </li>';
                                                }

                                                ?>


                                            </ul>
                                        </div>
                                    </div>
                                    <!-- /Rating -->



                                    <!-- Review Form -->
                                    <div style="margin: 5% 20%;" class="col-md-3">
                                        <span><?php
                                                if (in_array($mac, $macs)) {
                                                    echo "<strong>You Rated this Store!</strong>";
                                                }
                                                ?>
                                        </span>
                                        <div id="review-form">
                                            <form class="review-form" action="rating1.php" method="GET">
                                                <div class="input-rating">
                                                    <span><b> Rating:</b> </span>
                                                    <div class="stars">
                                                        <input id="star5" name="ratings" value="5" type="radio" <?php
                                                                                                                if (in_array($mac, $macs)) {
                                                                                                                    echo "disabled";
                                                                                                                }
                                                                                                                ?>><label for="star5"></label>
                                                        <input id="star4" name="ratings" value="4" type="radio" <?php
                                                                                                                if (in_array($mac, $macs)) {
                                                                                                                    echo "disabled";
                                                                                                                }
                                                                                                                ?>><label for="star4"></label>
                                                        <input id="star3" name="ratings" value="3" type="radio" <?php
                                                                                                                if (in_array($mac, $macs)) {
                                                                                                                    echo "disabled";
                                                                                                                }
                                                                                                                ?>><label for="star3"></label>
                                                        <input id="star2" name="ratings" value="2" type="radio" <?php
                                                                                                                if (in_array($mac, $macs)) {
                                                                                                                    echo "disabled";
                                                                                                                }
                                                                                                                ?>><label for="star2"></label>
                                                        <input id="star1" name="ratings" value="1" type="radio" <?php
                                                                                                                if (in_array($mac, $macs)) {
                                                                                                                    echo "disabled";
                                                                                                                }
                                                                                                                ?>><label for="star1"></label>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="store_id" value="<?php echo $store['id'] ?>" class="primary-btn">
                                                <input type="submit" class="primary-btn" <?php
                                                                                            if (in_array($mac, $macs)) {
                                                                                                echo "disabled";
                                                                                            }
                                                                                            ?>>
                                            </form>

                                        </div>
                                    </div>
                                    <!-- /Review Form -->
                                </div>
                            </div>
                            <!-- /tab3  -->
                        </div>
                        <!-- /product tab content  -->
                    </div>
                </div>
                <!-- /product tab -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->



    <!-- FOOTER -->
    <?php
    include_once "partial/footer.php";
    ?>

</body>

</html>