<?php
if (isset($_POST['equipcode'])) {
    $equipold = $_POST['equipold'];
    $equipcode = $_POST['equipcode'];
    $equipname = isset($_POST['equipname']) ? $_POST['equipname'] : "";
    $equipmodel = isset($_POST['equipmodel']) ? $_POST['equipmodel'] : "";
    $equipsn = isset($_POST['equipsn']) ? $_POST['equipsn'] : "";
    $stmt = $conn->prepare("UPDATE equipments SET equipcode=?,equipname=?,equipmodel=?,equipsn=? WHERE equipcode=?");
    $param = array($equipcode, $equipname, $equipmodel, $equipsn, $equipold);
    try {
        $stmt->execute($param);
        $_SESSION['alert'] = "<div class='alert alert-success alert-dismissible fade show position-absolute' role='alert' style='width: 100%;'>
                    <strong>Completed</strong> Save Data Completed
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
        echo "<script>window.location.replace('?page=equipments/detail&equipcode=$equipcode');</script>";
        exit();
    } catch (Exception $ex) {
        $_SESSION['alert'] = "<div class='alert alert-danger alert-dismissible fade show position-absolute' role='alert' style='width: 100%;'>
                    <strong>Incompleted</strong> Can't Save Data
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
        echo "<script>window.history.back();</script>";
        exit();
    }
} else if (isset($_POST['equipremove'])) {
    $equipcode = $_POST['equipremove'];
    $stmt = $conn->prepare("DELETE FROM equipments WHERE equipcode=?");
    $param = array($equipcode);
    try {
        $stmt->execute($param);
        $_SESSION['alert'] = "<div class='alert alert-success alert-dismissible fade show position-absolute' role='alert' style='width: 100%;'>
                    <strong>Complete</strong> Delete Data Completed
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
        echo "<script>window.location.replace('?page=equipments/index');</script>";
        exit();
    } catch (Exception $ex) {
        $_SESSION['alert'] = "<div class='alert alert-danger alert-dismissible fade show position-absolute' role='alert' style='width: 100%;'>
                    <strong>Incompleted</strong> Can't Delete Data
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
        echo "<script>window.history.back();</script>";
        exit();
    }
}

$equipcode = isset($_GET['equipcode']) ? $_GET['equipcode'] : null;

$stmt = $conn->prepare("SELECT equipments.equipcode, equipments.equipname, equipments.equipmodel, equipments.equipsn, borrowing.status, 
borrowing.dateborrow, borrowing.datereturn, borrowing.datesend, borrowing.dateready, departments.deptname FROM equipments 
LEFT JOIN (SELECT * FROM borrowing WHERE status != 0) AS borrowing ON equipments.equipcode = borrowing.equipcode 
LEFT JOIN departments ON borrowing.deptcode = departments.deptcode
WHERE equipments.equipcode = ?");
$param = array($equipcode);
$stmt->execute($param);

if ($stmt->rowCount() <= 0) {
    $_SESSION['alert'] = "<div class='alert alert-warning alert-dismissible fade show position-absolute' role='alert' style='width: 100%;'>
                    <strong>Error</strong> Not Found Data
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
    echo "<script>window.history.back();</script>";
    exit();
} else {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $equipname = $row['equipname'];
    $equipmodel = $row['equipmodel'];
    $equipsn = $row['equipsn'];
    $deptname = $row['deptname'];
    $status = (int)$row['status'];
    if ($status == 1) $arrdate = explode("-", $row['dateborrow']);
    else if ($status == 2) $arrdate = explode("-", $row['datereturn']);
    else if ($status == 3) $arrdate = explode("-", $row['datesend']);
    else $arrdate = explode("-", date("Y-m-d"));
    $equipdate = $arrdate[2] . "/" . $arrdate[1] . "/" . $arrdate[0];
}

?>
<style>
    th {
        text-align: end;
        font-weight: bolder;
        width: 200px;
        background-color: #eeeeee;
    }
</style>
<div id="app">
    <h1>Gas Cylinder Details</h1>
    <hr />
    <div class="container">
        <table class="table table-hover">
            <tbody>
                <tr>
                    <th scope="row" style="background-color: #eeeeee;">ID Code :</th>
                    <td><?= $equipcode ?></td>
                </tr>
                <tr>
                    <th scope="row" style="background-color: #eeeeee;">Type Gas :</th>
                    <td><?= $equipname ?></td>
                </tr>
                <tr>
                    <th scope="row" style="background-color: #eeeeee;">Size :</th>
                    <td><?= $equipmodel ?></td>
                </tr>
                <tr>
                    <th scope="row" style="background-color: #eeeeee;">S/N :</th>
                    <td><?= $equipsn ?></td>
                </tr>
                <tr>
                    <th scope="row" style="background-color: #eeeeee;">Status :</th>
                    <td><?= $equipstatus[$status] ?></td>
                </tr>
                <?php if ($status == 1) : ?>
                    <tr>
                        <th scope="row" style="background-color: #eeeeee;">Department :</th>
                        <td><?= $deptname ?></td>
                    </tr>
                    <tr>
                        <th scope="row" style="background-color: #eeeeee;">Borrow Date :</th>
                        <td><?= $equipdate ?></td>
                    </tr>
                <?php elseif ($status == 2) : ?>
                    <tr>
                        <th scope="row" style="background-color: #eeeeee;">Return Date:</th>
                        <td><?= $equipdate ?></td>
                    </tr>
                <?php elseif ($status == 3) : ?>
                    <tr>
                        <th scope="row" style="background-color: #eeeeee;">Send to fill Date :</th>
                        <td><?= $equipdate ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="text-center">
            <button class="btn btn-warning me-3" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
            <button class="btn btn-danger me-3" data-bs-toggle="modal" data-bs-target="#removeModal">Delete</button>
            <button class="btn btn-info me-3" onclick="window.history.back();">Back</button>
        </div>
    </div>

    <!-- editModal -->
    <div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModalLabel">Edit</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post">
                    <input type="hidden" name="equipold" value="<?= $equipcode ?>" />
                    <div class="modal-body g-3">
                        <div class="mb-3">
                            <label for="equipcode" class="form-label">ID Code</label>
                            <input type="text" class="form-control" id="equipcode" name="equipcode" value="<?= $equipcode ?>" placeholder="ID Code" required>
                        </div>
                        <div class="mb-3">
                            <label for="equipname" class="form-label">Type Gas</label>
                            <input type="text" class="form-control" id="equipname" name="equipname" value="<?= $equipname ?>" placeholder="Type Gas" required>
                        </div>
                        <div class="mb-3">
                            <label for="equipmodel" class="form-label">Size</label>
                            <input type="text" class="form-control" id="equipmodel" name="equipmodel" value="<?= $equipmodel ?>" placeholder="Size" required>
                        </div>
                        <div class="mb-3">
                            <label for="equipsn" class="form-label">S/N</label>
                            <input type="text" class="form-control" id="equipsn" name="equipsn" value="<?= $equipsn ?>" placeholder="S/N" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- removeModal -->
    <div class="modal fade" id="removeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="removeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="removeModalLabel">Delete</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <h2 class="text-center text-danger">Confirm ?</h2>
                        <input type="hidden" name="equipremove" value="<?= $equipcode ?>" />
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Delete</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script>
    const {
        createApp
    } = Vue
    createApp({
        data() {
            return {}
        },
    }).mount('#app')
</script>