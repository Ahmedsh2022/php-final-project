<?php


$connection = mysqli_connect('localhost', 'root', '', 'finalproject');
if (!$connection) {
    die('Error' .
        mysqli_connect_error());
}