<?php
if (isset($_POST['equipcode'])) {
    $equipcode = $_POST['equipcode'];
    $deptcode = $_POST['deptcode'];
    $dateborrow = isset($_POST['dateborrow']) ? $_POST['dateborrow'] : date("Y-m-d");

    $stmt = $conn->prepare("SELECT borrowno FROM borrowing WHERE status>0 AND equipcode=?");
    $param = array($equipcode);
    $stmt->execute($param);
    if ($stmt->rowCount() > 0) {
        $_SESSION['alert'] = "<div class='alert alert-warning alert-dismissible fade show position-absolute' role='alert' style='width: 100%;'>
                    <strong>Sorry</strong> Cylinder is not ready for borrowing
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
        echo "<script>window.history.back();</script>";
        exit();
    }
    $arrdate = explode("-", $dateborrow);
    $tempcode = $arrdate[0] . $arrdate[1] . "-";

    $stmt = $conn->prepare("SELECT MAX(borrowno) AS borrowno FROM borrowing WHERE borrowno LIKE ?");
    $param = array($tempcode . "%");
    $stmt->execute($param);

    if ($stmt->rowCount() <= 0) {
        $borrowno = $tempcode . "0001";
    } else {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $arrcode = explode("-", $row['borrowno']);
        $borrowno = sprintf("%s%04d", $tempcode, 1 + (int)$arrcode[1]);
    }

    $stmt = $conn->prepare("INSERT INTO borrowing(borrowno,equipcode,deptcode,dateborrow,status) VALUES(?,?,?,?,?)");
    $param = array($borrowno, $equipcode, $deptcode, $dateborrow, 1);
    try {
        $stmt->execute($param);
        $_SESSION['alert'] = "<div class='alert alert-success alert-dismissible fade show position-absolute' role='alert' style='width: 100%;'>
                    <strong>Completed</strong> Save Data Completed
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
        echo "<script>window.history.back();</script>";
        exit();
    } catch (Exception $ex) {
        $_SESSION['alert'] = "<div class='alert alert-danger alert-dismissible fade show position-absolute' role='alert' style='width: 100%;'>
                    <strong>Incompleted</strong> Can't Save Data
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
        echo "<script>window.history.back();</script>";
        exit();
    }
}
$stmt = $conn->prepare("SELECT * FROM departments");
$stmt->execute();
$departments = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT equipments.equipcode,equipments.equipname,equipments.equipmodel,equipments.equipsn FROM equipments 
LEFT JOIN (SELECT equipcode FROM borrowing WHERE status>0) AS borrowing ON equipments.equipcode = borrowing.equipcode 
WHERE borrowing.equipcode IS NULL");
$stmt->execute();
$equipments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div id="app">
    <h1>Add to borrowed cylinder list</h1>
    <hr />
    <div class="container">
        <label for="equipTable" class="form-label">Select Cylinder</label>
        <table id="equipTable" class="display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>ID Code</th>
                    <th>Type Gas</th>
                    <th>Size</th>
                    <th>S/N</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in equipments" :key="index" @click="showDetail(index)" style="cursor: pointer;">
                    <td>{{ item.equipcode }}</td>
                    <td>{{ item.equipname }}</td>
                    <td>{{ item.equipmodel }}</td>
                    <td>{{ item.equipsn }}</td>
                    <td>
                        <span data='0' class='badge rounded-pill text-bg-success' style='width: 120px;'>Ready to use</span>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="text-center">
            <a href="?page=borrow/index" class="btn btn-info">Back</a>
        </div>
    </div>

    <!-- confirmModal -->
    <div class="modal fade" id="confirmModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="confirmModalLabel">Confirm</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post">
                    <input type="hidden" name="equipcode" v-model="borrow.equipcode" />
                    <div class="modal-body g-3">
                        <div class="mb-3">
                            <label for="equipcode" class="form-label">ID Code</label>
                            <input type="text" class="form-control" id="equipcode" name="equipcode" placeholder="ID Code" v-model="borrow.equipcode" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="equipname" class="form-label">Type Gas</label>
                            <input type="text" class="form-control" id="equipname" placeholder="Type Gas" v-model="borrow.equipname" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="equipmodel" class="form-label">Size</label>
                            <input type="text" class="form-control" id="equipmodel" placeholder="Size" v-model="borrow.equipmodel" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="equipsn" class="form-label">S/N</label>
                            <input type="text" class="form-control" id="equipsn" placeholder="S/N" v-model="borrow.equipsn" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="deptcode" class="form-label">Department</label>
                            <select class="form-select" id="deptcode" name="deptcode" required>
                                <option value="" selected disabled>Select Department</option>
                                <option v-for="(item, index) in departments" :value="item.deptcode" :key="index">{{ item.deptname }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="dateborrow" class="form-label">Borrow Date</label>
                            <input type="date" class="form-control" id="dateborrow" name="dateborrow" placeholder="Borrow Date" value="<?= date("Y-m-d") ?>" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save</button>
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
                departments: <?= json_encode($departments, JSON_UNESCAPED_UNICODE) ?>,
                equipments: <?= json_encode($equipments, JSON_UNESCAPED_UNICODE) ?>,
                borrow: {
                    equipcode: null,
                    equipname: null,
                    equipmodel: null,
                    equipsn: null,
                    deptcode: "",
                    dateborrow: '<?= date("Y-m-d") ?>'
                }
            }
        },
        methods: {
            initfn() {
                this.table = new DataTable('#equipTable', {
                    columnDefs: [{
                            className: "dt-head-center",
                            targets: [3]
                        },
                        {
                            className: "dt-body-center",
                            targets: [3]
                        }
                    ],
                    fixedColumns: {
                        left: 1,
                    },
                    paging: true,
                    scrollX: true,
                });

                let equipments = this.equipments.map(row => {
                    return [row.equipcode, row.equipname, row.equipmodel, row.equipsn];
                });
            },
            showDetail(index) {
                let temp = this.equipments[index];
                this.borrow = temp;

                let confirmModal = new bootstrap.Modal('#confirmModal', {});
                confirmModal.show();
            }
        },
        mounted() {
            this.initfn();
        },
    }).mount('#app')
</script>