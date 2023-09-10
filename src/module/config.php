<?php
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard/index';
$page = (int)file_exists("pages/" . $page . ".php") ? $page : "dashboard/index";

$textstatus = array("Ready for use", "Lending", "Empty Cylinder", "Filling Gas");

$equipstatus = array(
    "<span data='0' class='badge rounded-pill text-bg-success' style='width: 120px;'>Ready for use</span>",
    "<span data='1' class='badge rounded-pill text-bg-info' style='width: 120px;'>Lending</span>",
    "<span data='2' class='badge rounded-pill text-bg-warning' style='width: 120px;'>Empty Cylinder</span>",
    "<span data='3' class='badge rounded-pill text-bg-secondary' style='width: 120px;'>Filling Gas</span>"
);

if (isset($_SESSION['alert'])) {
    $alert = $_SESSION['alert'];
    unset($_SESSION['alert']);
} else {
    $alert = null;
}

// $alert = "<div class='alert alert-success alert-dismissible fade show position-absolute' role='alert' style='width: 100%;'>
//             <strong>Success</strong> You should check in on some of those fields below.
//             <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
//         </div>";
