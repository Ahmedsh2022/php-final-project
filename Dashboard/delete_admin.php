<?php
require_once "partial/DB_CONNECTION.php";
$id = $_POST['id'];
$query = "DELETE FROM admins WHERE id=".$id;
$result = mysqli_query($connection,$query);
if ($result){
    header('Location:show_all_admins.php');
}