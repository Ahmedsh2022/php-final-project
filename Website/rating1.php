<?php
include_once "../Dashboard/partial/DB_CONNECTION.php";
if (isset($_GET['ratings'])) {
    $rating = $_GET['ratings'];
    $storeId = $_GET['store_id'];
    $string = exec('getmac');
    $mac = substr($string, 0, 17);

    $query = "INSERT INTO rating (store_id,macAdd,rate)
    VALUES('$storeId','$mac','$rating')";
    $result = mysqli_query($connection, $query);
    if ($result) {
        $errors = [];
        $success = true;
        header("Location:showStoreInfo.php?id=" . $storeId);
    } else {
        echo "please fix all errors";
    }
}
