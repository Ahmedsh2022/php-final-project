<?php
require_once "partial/DB_CONNECTION.php";
$id = $_GET['id'];
$query = "DELETE FROM secondary_categories WHERE id=".$id;
$result = mysqli_query($connection,$query);
if ($result){
    header('Location:show_secondary_categories.php');
}