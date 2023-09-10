<?php
if (isset($_POST['borrowrtn'])) {
    $borrowno = $_POST['borrowrtn'];
    $datereturn = isset($_POST['datereturn']) ? $_POST['datereturn'] : date("Y-m-d");
    $stmt = $conn->prepare("UPDATE borrowing SET datereturn=?,status=2 WHERE borrowno=?");
    $param = array($datereturn, $borrowno);
    try {
        $stmt->execute($param);
        $_SESSION['alert'] = "<div class='alert alert-success alert-dismissible fade show position-absolute' role='alert' style='width: 100%;'>
                    <strong>Completed</strong> Save Data Completed
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
        echo "<script>window.location.replace('?page=borrow/index');</script>";
        exit();
    } catch (Exception $ex) {
        $_SESSION['alert'] = "<div class='alert alert-danger alert-dismissible fade show position-absolute' role='alert' style='width: 100%;'>
                    <strong>Incompleted</strong> Can't Save Data
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
        echo "<script>window.history.back();</script>";
        exit();
    }
} else if (isset($_POST['borrowcln'])) {
    $borrowno = $_POST['borrowcln'];
    $datesend = isset($_POST['datesend']) ? $_POST['datesend'] : date("Y-m-d");
    $stmt = $conn->prepare("UPDATE borrowing SET datesend=?,status=3 WHERE borrowno=?");
    $param = array($datesend, $borrowno);
    try {
        $stmt->execute($param);
        $_SESSION['alert'] = "<div class='alert alert-success alert-dismissible fade show position-absolute' role='alert' style='width: 100%;'>
                    <strong>Completed</strong> Save Data Completed
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
        echo "<script>window.location.replace('?page=borrow/index');</script>";
        exit();
    } catch (Exception $ex) {
        $_SESSION['alert'] = "<div class='alert alert-danger alert-dismissible fade show position-absolute' role='alert' style='width: 100%;'>
                    <strong>Incompleted</strong> Can't Save Data
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
        echo "<script>window.history.back();</script>";
        exit();
    }
} else if (isset($_POST['borrowred'])) {
    $borrowno = $_POST['borrowred'];
    $dateready = isset($_POST['dateready']) ? $_POST['dateready'] : date("Y-m-d");
    $stmt = $conn->prepare("UPDATE borrowing SET dateready=?,status=0 WHERE borrowno=?");
    $param = array($dateready, $borrowno);
    try {
        $stmt->execute($param);
        $_SESSION['alert'] = "<div class='alert alert-success alert-dismissible fade show position-absolute' role='alert' style='width: 100%;'>
                    <strong>Completed</strong> Save Data Completed
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
        echo "<script>window.location.replace('?page=borrow/index');</script>";
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

$stmt = $conn->prepare("SELECT * FROM borrowing LEFT JOIN equipments ON borrowing.equipcode = equipments.equipcode 
LEFT JOIN departments ON borrowing.deptcode = departments.deptcode WHERE borrowing.status != 0");
$stmt->execute();
$borrows = array();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $arrdate = explode("-", $row['dateborrow']);
    $dateborrow = $arrdate[2] . "/" . $arrdate[1] . "/" . $arrdate[0];
    $arrdate = explode("-", (int)$row['status'] >= 2 ? $row['datereturn'] : date("Y-m-d"));
    $datereturn = $arrdate[2] . "/" . $arrdate[1] . "/" . $arrdate[0];
    $arrdate = explode("-", (int)$row['status'] >= 3 ? $row['datesend'] : date("Y-m-d"));
    $datesend = $arrdate[2] . "/" . $arrdate[1] . "/" . $arrdate[0];
    array_push($borrows, array(
        "borrowno" => $row['borrowno'],
        "equipcode" => $row['equipcode'],
        "equipname" => $row['equipname'],
        "equipmodel" => $row['equipmodel'],
        "equipsn" => $row['equipsn'],
        "deptname" => $row['deptname'],
        "status" => (int)$row['status'],
        "dateborrow" => $dateborrow,
        "datereturn" => $datereturn,
        "datesend" => $datesend,
    ));
}

?>
<div id="app">
    <h1>Gas Cylinder Management</h1>
    <hr />
    <div class="container">
        <div class="text-end mb-3">
            <a href="?page=borrow/borrow" class="btn btn-success">Add to Borrow Cylinder</a>
        </div>
        <table id="borrowTable" class="display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>No. </th>
                    <th>ID Code</th>
                    <th>Type Gas</th>
                    <th>Size</th>
                    <th>S/N</th>
                    <th>Dapartment</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in borrows" :key="index" @click="showDetail(index)" style="cursor: pointer;">
                    <td>{{ item.borrowno }}</td>
                    <td>{{ item.equipcode }}</td>
                    <td>{{ item.equipname }}</td>
                    <td>{{ item.equipmodel }}</td>
                    <td>{{ item.equipsn }}</td>
                    <td>{{ item.deptname }}</td>
                    <td>
                        <span v-if="item.status==1" data='1' class='badge rounded-pill text-bg-info' style='width: 120px;'>Lending</span>
                        <span v-else-if="item.status==2" data='2' class='badge rounded-pill text-bg-warning' style='width: 120px;'>Empty Cylinder</span>
                        <span v-else-if="item.status==3" data='3' class='badge rounded-pill text-bg-secondary' style='width: 120px;'>Filling Gas</span>
                        <span v-else data='0' class='badge rounded-pill text-bg-success' style='width: 120px;'>Ready to Use</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- detailModal -->
    <div class="modal fade" id="detailModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="detailModalLabel">Borrowing History</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th scope="row" style="background-color: #eeeeee; width: 150px;">No. :</th>
                                <td>{{ borrow.borrowno }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="background-color: #eeeeee; width: 150px;">ID Code :</th>
                                <td>{{ borrow.equipcode }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="background-color: #eeeeee; width: 150px;">Type Gas:</th>
                                <td>{{ borrow.equipname }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="background-color: #eeeeee; width: 150px;">Size :</th>
                                <td>{{ borrow.equipmodel }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="background-color: #eeeeee; width: 150px;">S/N :</th>
                                <td>{{ borrow.equipsn }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="background-color: #eeeeee; width: 150px;">Department :</th>
                                <td>{{ borrow.deptname }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="background-color: #eeeeee; width: 150px;">Status:</th>
                                <td>
                                    <span v-if="borrow.status==1" data='1' class='badge rounded-pill text-bg-info' style='width: 120px;'>Lending</span>
                                    <span v-else-if="borrow.status==2" data='2' class='badge rounded-pill text-bg-warning' style='width: 120px;'>Empty Cylinder</span>
                                    <span v-else-if="borrow.status==3" data='3' class='badge rounded-pill text-bg-secondary' style='width: 120px;'>Filling Gas</span>
                                    <span v-else data='0' class='badge rounded-pill text-bg-success' style='width: 120px;'>Ready to use</span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" style="background-color: #eeeeee; width: 150px;">Borrow Date :</th>
                                <td>{{ borrow.dateborrow }}</td>
                            </tr>
                            <tr v-if="borrow.status>=2">
                                <th scope="row" style="background-color: #eeeeee; width: 150px;">Return Date :</th>
                                <td>{{ borrow.datereturn }}</td>
                            </tr>
                            <tr v-if="borrow.status>=3">
                                <th scope="row" style="background-color: #eeeeee; width: 150px;">Send to fill Date :</th>
                                <td>{{ borrow.datesend }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button v-if="borrow.status==1" type="button" class="btn btn-primary" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#returnModal">Empty Cylinder</button>
                    <button v-else-if="borrow.status==2" type="button" class="btn btn-primary" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#cleanModal">Filling Gas</button>
                    <button v-else-if="borrow.status==3" type="button" class="btn btn-primary" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#readyModal">Ready to use</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- returnModal -->
    <div class="modal fade" id="returnModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="returnModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="returnModalLabel">Return Cylinder</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <input type="hidden" name="borrowrtn" v-model="borrow.borrowno" />
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th scope="row" style="background-color: #eeeeee; width: 150px;">No. :</th>
                                    <td>{{ borrow.borrowno }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="background-color: #eeeeee; width: 150px;">ID Code :</th>
                                    <td>{{ borrow.equipcode }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="background-color: #eeeeee; width: 150px;">Type Gas:</th>
                                    <td>{{ borrow.equipname }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="background-color: #eeeeee; width: 150px;">Size :</th>
                                    <td>{{ borrow.equipmodel }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="background-color: #eeeeee; width: 150px;">S/N :</th>
                                    <td>{{ borrow.equipsn }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="background-color: #eeeeee; width: 150px;">Department :</th>
                                    <td>{{ borrow.deptname }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="background-color: #eeeeee; width: 150px;">Status :</th>
                                    <td>
                                        <span v-if="borrow.status==1" data='1' class='badge rounded-pill text-bg-info' style='width: 120px;'>Lending</span>
                                        <span v-else-if="borrow.status==2" data='2' class='badge rounded-pill text-bg-warning' style='width: 120px;'>Empty Cylinder</span>
                                        <span v-else-if="borrow.status==3" data='3' class='badge rounded-pill text-bg-secondary' style='width: 120px;'>Filling Gas</span>
                                        <span v-else data='0' class='badge rounded-pill text-bg-success' style='width: 120px;'>Ready to use</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" style="background-color: #eeeeee; width: 150px;">Borrow Date :</th>
                                    <td>{{ borrow.dateborrow }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="background-color: #eeeeee; width: 150px;">Return Date :</th>
                                    <td>
                                        <input type="date" class="form-control" id="datereturn" name="datereturn" placeholder="Return Date" value="<?= date("Y-m-d") ?>" required>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#detailModal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- cleanModal -->
    <div class="modal fade" id="cleanModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cleanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="cleanModalLabel">Send to fill gas cylinder</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <input type="hidden" name="borrowcln" v-model="borrow.borrowno" />
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th scope="row" style="background-color: #eeeeee; width: 150px;">No. :</th>
                                    <td>{{ borrow.borrowno }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="background-color: #eeeeee; width: 150px;">ID Code :</th>
                                    <td>{{ borrow.equipcode }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="background-color: #eeeeee; width: 150px;">Type Gas :</th>
                                    <td>{{ borrow.equipname }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="background-color: #eeeeee; width: 150px;">Size :</th>
                                    <td>{{ borrow.equipmodel }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="background-color: #eeeeee; width: 150px;">S/N :</th>
                                    <td>{{ borrow.equipsn }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="background-color: #eeeeee; width: 150px;">Department :</th>
                                    <td>{{ borrow.deptname }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="background-color: #eeeeee; width: 150px;">Status :</th>
                                    <td>
                                        <span v-if="borrow.status==1" data='1' class='badge rounded-pill text-bg-info' style='width: 120px;'>Lending</span>
                                        <span v-else-if="borrow.status==2" data='2' class='badge rounded-pill text-bg-warning' style='width: 120px;'>Empty Cylinder</span>
                                        <span v-else-if="borrow.status==3" data='3' class='badge rounded-pill text-bg-secondary' style='width: 120px;'>Filling Gas</span>
                                        <span v-else data='0' class='badge rounded-pill text-bg-success' style='width: 120px;'>Ready to use</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" style="background-color: #eeeeee; width: 150px;">Borrow Date :</th>
                                    <td>{{ borrow.dateborrow }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="background-color: #eeeeee; width: 150px;">Return Date :</th>
                                    <td>{{ borrow.datereturn }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="background-color: #eeeeee; width: 150px;">Send to fill Date :</th>
                                    <td>
                                        <input type="date" class="form-control" id="datesend" name="datesend" placeholder="Send Date" value="<?= date("Y-m-d") ?>" required>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#detailModal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- readyModal -->
    <div class="modal fade" id="readyModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="readyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="readyModalLabel">Cylinder Ready to use</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <input type="hidden" name="borrowred" v-model="borrow.borrowno" />
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th scope="row" style="background-color: #eeeeee; width: 150px;">No. :</th>
                                    <td>{{ borrow.borrowno }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="background-color: #eeeeee; width: 150px;">ID Code :</th>
                                    <td>{{ borrow.equipcode }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="background-color: #eeeeee; width: 150px;">Type Gas:</th>
                                    <td>{{ borrow.equipname }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="background-color: #eeeeee; width: 150px;">Size :</th>
                                    <td>{{ borrow.equipmodel }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="background-color: #eeeeee; width: 150px;">S/N :</th>
                                    <td>{{ borrow.equipsn }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="background-color: #eeeeee; width: 150px;">Department :</th>
                                    <td>{{ borrow.deptname }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="background-color: #eeeeee; width: 150px;">Status:</th>
                                    <td>
                                        <span v-if="borrow.status==1" data='1' class='badge rounded-pill text-bg-info' style='width: 120px;'>Lending</span>
                                        <span v-else-if="borrow.status==2" data='2' class='badge rounded-pill text-bg-warning' style='width: 120px;'>Empty Cylinder</span>
                                        <span v-else-if="borrow.status==3" data='3' class='badge rounded-pill text-bg-secondary' style='width: 120px;'>Filling Gas</span>
                                        <span v-else data='0' class='badge rounded-pill text-bg-success' style='width: 120px;'>Ready to use</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" style="background-color: #eeeeee; width: 150px;">Borrow Date :</th>
                                    <td>{{ borrow.dateborrow }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="background-color: #eeeeee; width: 150px;">Return Date :</th>
                                    <td>{{ borrow.datereturn }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="background-color: #eeeeee; width: 150px;">Send to fill Date :</th>
                                    <td>{{ borrow.datesend }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="background-color: #eeeeee; width: 150px;">Ready to Use Date :</th>
                                    <td>
                                        <input type="date" class="form-control" id="dateready" name="dateready" placeholder="Ready Date" value="<?= date("Y-m-d") ?>" required>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#detailModal">Close</button>
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
                borrows: <?= json_encode($borrows, JSON_UNESCAPED_UNICODE) ?>,
                borrow: {}
            }
        },
        methods: {
            initfn() {
                this.table = new DataTable('#borrowTable', {
                    columnDefs: [{
                            className: "dt-head-center",
                            targets: [5]
                        },
                        {
                            className: "dt-body-center",
                            targets: [5]
                        }
                    ],
                    fixedColumns: {
                        left: 1,
                    },
                    paging: true,
                    scrollX: true,
                });
            },
            showDetail(index) {
                let temp = this.borrows[index];
                this.borrow = temp;

                let detailModal = new bootstrap.Modal('#detailModal', {});
                detailModal.show();
            }
        },
        mounted() {
            this.initfn();
        },
    }).mount('#app')
</script>