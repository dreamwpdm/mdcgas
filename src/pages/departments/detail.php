<?php
if (isset($_POST['deptcode'])) {
    $deptold = $_POST['deptold'];
    $deptcode = $_POST['deptcode'];
    $deptname = isset($_POST['deptname']) ? $_POST['deptname'] : "";
    $stmt = $conn->prepare("UPDATE departments SET deptcode=?,deptname=? WHERE deptcode=?");
    $param = array($deptcode, $deptname, $deptold);
    try {
        $stmt->execute($param);
        $_SESSION['alert'] = "<div class='alert alert-success alert-dismissible fade show position-absolute' role='alert' style='width: 100%;'>
                    <strong>Completed</strong> Save Data Completed
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
        echo "<script>window.location.replace('?page=departments/detail&deptcode=$deptcode');</script>";
        exit();
    } catch (Exception $ex) {
        $_SESSION['alert'] = "<div class='alert alert-danger alert-dismissible fade show position-absolute' role='alert' style='width: 100%;'>
                    <strong>Incompleted</strong> Can't Save Data
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
        echo "<script>window.history.back();</script>";
        exit();
    }
} else if (isset($_POST['deptremove'])) {
    $deptcode = $_POST['deptremove'];
    $stmt = $conn->prepare("DELETE FROM departments WHERE deptcode=?");
    $param = array($deptcode);
    try {
        $stmt->execute($param);
        $_SESSION['alert'] = "<div class='alert alert-success alert-dismissible fade show position-absolute' role='alert' style='width: 100%;'>
                    <strong>Completed</strong> Delete Data Completed
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
        echo "<script>window.location.replace('?page=departments/index');</script>";
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

$deptcode = isset($_GET['deptcode']) ? $_GET['deptcode'] : null;

$stmt = $conn->prepare("SELECT * FROM departments WHERE deptcode = ?");
$param = array($deptcode);
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
    $deptname = $row['deptname'];

    $stmt = $conn->prepare("SELECT * FROM borrowing LEFT JOIN equipments ON borrowing.equipcode = equipments.equipcode 
    WHERE borrowing.status = 1 AND borrowing.deptcode=?");
    $param = array($deptcode);
    $stmt->execute($param);

    $borrowings = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $arrdate = explode("-", $row['dateborrow']);
        $dateborrow = $arrdate[2] . "/" . $arrdate[1] . "/" . $arrdate[0];
        array_push($borrowings, array(
            $row['equipcode'],
            $row['equipname'],
            $row['equipmodel'],
            $dateborrow
        ));
    }
}
?>
<div id="app">
    <h1>Department Details</h1>
    <hr />
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="overflow-x-auto">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th scope="row" style="background-color: #eeeeee; width: 150px;">Department Code :</th>
                                <td><?= $deptcode ?></td>
                            </tr>
                            <tr>
                                <th scope="row" style="background-color: #eeeeee;">Department Name :</th>
                                <td><?= $deptname ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-center">
                    <button class="btn btn-warning me-3" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
                    <button class="btn btn-danger me-3" data-bs-toggle="modal" data-bs-target="#removeModal">Delete</button>
                    <button class="btn btn-info me-3" onclick="window.history.back();">Back</button>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card">
                    <h5 class="card-header">Overdue</h5>
                    <div class="card-body">
                        <table id="borrowTable" class="display nowrap" style="width:100%"></table>
                    </div>
                </div>
            </div>
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
                    <input type="hidden" name="deptold" value="<?= $deptcode ?>" />
                    <div class="modal-body g-3">
                        <div class="mb-3">
                            <label for="deptcode" class="form-label">Department Code</label>
                            <input type="text" class="form-control" id="deptcode" name="deptcode" value="<?= $deptcode ?>" placeholder="Department Code" required>
                        </div>
                        <div class="mb-3">
                            <label for="deptname" class="form-label">Department Name</label>
                            <input type="text" class="form-control" id="deptname" name="deptname" value="<?= $deptname ?>" placeholder="Department Name" required>
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
                        <input type="hidden" name="deptremove" value="<?= $deptcode ?>" />
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
            return {
                table: null,
                borrowings: <?= json_encode($borrowings, JSON_UNESCAPED_UNICODE); ?>
            }
        },
        methods: {
            initfn() {
                this.table = new DataTable('#borrowTable', {
                    columns: [{
                            title: 'ID Code'
                        },
                        {
                            title: 'Type Gas'
                        },
                        {
                            title: 'Size'
                        },
                        {
                            title: 'Borrow Date'
                        }
                    ],
                    fixedColumns: {
                        left: 1,
                    },
                    paging: true,
                    scrollX: true,
                    data: [],
                });

                this.table.clear().rows.add(this.borrowings).draw();
            }
        },
        mounted() {
            this.initfn();
        },
    }).mount('#app')
</script>