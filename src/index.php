<?php
session_start();
require('mysql/connect.php');
require('module/config.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BNH Medical Gas</title>

    <!-- jQuery -->
    <script src="vender/datatable/js/jquery-3.7.0.js"></script>
    <!-- bootstrap 5 -->
    <link href="vender/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <script src="vender/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Datatable -->
    <link href="vender/datatable/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="vender/datatable/css/fixedColumns.dataTables.min.css" rel="stylesheet" />
    <script src="vender/datatable/js/jquery.dataTables.min.js"></script>
    <script src="vender/datatable/js/dataTables.fixedColumns.min.js"></script>
    <!-- vueJS -->
    <script src="vender/vue/vue.global.js"></script>
</head>

<body>
    <?php
    require('module/mainmenu.php');
    echo $alert;
    require('pages/' . $page . '.php');
    ?>
</body>

</html>