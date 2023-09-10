<?php
$db_host = "localhost";
$db_name = "medicalgas";
$db_user = "root";
$db_pass = "";
$connStr = "mysql:host=$db_host; dbname=$db_name; charset=UTF8";
$conn = new PDO($connStr, $db_user, $db_pass);
// $conn->exec("set names utf8"); PHP Version < 5.3.6
// SELECT `deptcode`, `deptname` FROM `departments`
// SELECT `equipcode`, `equipname`, `equipcolor` FROM `equipments`
// SELECT `borrowno`, `equipcode`, `deptcode`, `dateborrow`, `datereturn`, `dateclean`, `dateready`, `status` FROM `borrowing`