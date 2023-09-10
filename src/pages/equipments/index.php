<?php
if (isset($_POST['equipcode'])) {
    $equipcode = $_POST['equipcode'];
    $equipname = isset($_POST['equipname']) ? $_POST['equipname'] : "";
    $equipmodel = isset($_POST['equipmodel']) ? $_POST['equipmodel'] : "";
    $equipsn = isset($_POST['equipsn']) ? $_POST['equipsn'] : "";
    $stmt = $conn->prepare("INSERT INTO equipments(equipcode,equipname,equipmodel,equipsn) VALUES(?,?,?,?)");
    $param = array($equipcode, $equipname, $equipmodel, $equipsn);
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
}

$stmt = $conn->prepare("SELECT equipments.equipcode, equipments.equipname, equipments.equipmodel, equipments.equipsn, borrowing.status FROM equipments 
LEFT JOIN (SELECT * FROM borrowing WHERE status != 0) AS borrowing ON equipments.equipcode = borrowing.equipcode");
$stmt->execute();

$equipments = array();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    array_push(
        $equipments,
        array(
            "equipcode" => $row['equipcode'],
            "equipname" => $row['equipname'],
            "equipmodel" => $row['equipmodel'],
            "equipsn" => $row['equipsn'],
            "status" => (int)$row['status'],
        )
    );
}

?>
<div id="app">
    <h1>Gas Cylinder Details</h1>
    <hr />
    <div class="container">
        <div class="text-end mb-3">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addnewModal">Add New Cylinder</button>
        </div>
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
                        <span v-if="item.status==1" data='1' class='badge rounded-pill text-bg-info' style='width: 120px;'>Lending</span>
                        <span v-else-if="item.status==2" data='2' class='badge rounded-pill text-bg-warning' style='width: 120px;'>Empty Cylinder</span>
                        <span v-else-if="item.status==3" data='3' class='badge rounded-pill text-bg-secondary' style='width: 120px;'>Filling Gas</span>
                        <span v-else data='0' class='badge rounded-pill text-bg-success' style='width: 120px;'>Ready to use</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- addnewModal -->
    <div class="modal fade" id="addnewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addnewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addnewModalLabel">Add New Cylinder</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post">
                    <div class="modal-body g-3">
                        <div class="mb-3">
                            <label for="equipcode" class="form-label">ID Code</label>
                            <input type="text" class="form-control" id="equipcode" name="equipcode" placeholder="ID Code" required>
                        </div>
                        <div class="mb-3">
                            <label for="equipname" class="form-label">Type Gas</label>
                            <input type="text" class="form-control" id="equipname" name="equipname" placeholder="Type Gas" required>
                        </div>
                        <div class="mb-3">
                            <label for="equipmodel" class="form-label">Size</label>
                            <input type="text" class="form-control" id="equipmodel" name="equipmodel" placeholder="Size" required>
                        </div>
                        <div class="mb-3">
                            <label for="equipsn" class="form-label">S/N</label>
                            <input type="text" class="form-control" id="equipsn" name="equipsn" placeholder="S/N" required>
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

    <!-- detailModal -->
    <div class="modal fade" id="detailModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="detailModalModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="detailModalLabel">Gas Cylinder Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body g-3">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th scope="row" style="background-color: #eeeeee; width: 150px;">ID Code :</th>
                                <td>{{ equipment.equipcode }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="background-color: #eeeeee; width: 150px;">Type Gas:</th>
                                <td>{{ equipment.equipname }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="background-color: #eeeeee; width: 150px;">Size :</th>
                                <td>{{ equipment.equipmodel }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="background-color: #eeeeee; width: 150px;">S/N :</th>
                                <td>{{ equipment.equipsn }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="background-color: #eeeeee; width: 150px;">Status:</th>
                                <td>
                                    <span v-if="equipment.status==1" data='1' class='badge rounded-pill text-bg-info' style='width: 120px;'>Lending</span>
                                    <span v-else-if="equipment.status==2" data='2' class='badge rounded-pill text-bg-warning' style='width: 120px;'>Empty Cylinder</span>
                                    <span v-else-if="equipment.status==3" data='3' class='badge rounded-pill text-bg-secondary' style='width: 120px;'>Filling Gas</span>
                                    <span v-else data='0' class='badge rounded-pill text-bg-success' style='width: 120px;'>Ready to use</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info" @click="gotoDetail()">View</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
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
                equipments: <?= json_encode($equipments, JSON_UNESCAPED_UNICODE); ?>,
                equipment: {}
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
                        },
                        // {
                        //     visible: false,
                        //     searchable: false,
                        //     target: [4]
                        // }
                    ],
                    fixedColumns: {
                        left: 1,
                    },
                    paging: true,
                    scrollX: true,
                });
            },
            showDetail(index) {
                let temp = this.equipments[index];
                this.equipment = temp;

                let detailModal = new bootstrap.Modal('#detailModal', {});
                detailModal.show();
            },
            gotoDetail() {
                window.location.href = '?page=equipments/detail&equipcode=' + this.equipment.equipcode;
            }
        },
        computed: {},
        mounted() {
            this.initfn();
        },
    }).mount('#app')
</script>