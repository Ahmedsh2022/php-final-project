<?php
require_once "partial/DB_CONNECTION.php";
$id = $_GET['id'];
$image = $_GET['image'];

$query = "DELETE FROM products WHERE id=" . $id;
$result = mysqli_query($connection, $query);
if ($result) {
    unlink("uploads/images/" . $image);
    header('Location:show_all_products.php');
}


