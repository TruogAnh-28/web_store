<?php
$host = "localhost";
$user ="root";
$password ="";
$database = "db_shop";
$connect = new mysqli($host,$user,$password,$database);

//set unicode utf8
mysqli_set_charset($connect, "utf8");

//check connect
if ($connect->connect_error) {
    var_dump($connect->connect_error);
    die();
}
else{
  // echo "success";
}