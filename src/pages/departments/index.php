<?php
if (isset($_POST['deptcode'])) {
    $deptcode = $_POST['deptcode'];
    $deptname = isset($_POST['deptname']) ? $_POST['deptname'] : "";
    $stmt = $conn->prepare("INSERT INTO departments(deptcode,deptname) VALUES(?,?)");
    $param = array($deptcode, $deptname);
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
}

$stmt = $conn->prepare("SELECT * FROM departments");
$stmt->execute();

$departments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//     array_push($departments, array($row['deptcode'], $row['deptname']));
// }

?>
<div id="app">
    <h1>Departments Details</h1>
    <hr />
    <div class="container">
        <div class="text-end mb-3">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addnewModal">Add New Department</button>
        </div>
        <table id="deptTable" class="display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Department Code</th>
                    <th>Department Name</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in departments" :key="index" @click="showDetail(index)" style="cursor: pointer;">
                    <td>{{ item.deptcode }}</td>
                    <td>{{ item.deptname }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- addnewModal -->
    <div class="modal fade" id="addnewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addnewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addnewModalLabel">Add New Department</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post">
                    <div class="modal-body g-3">
                        <div class="mb-3">
                            <label for="deptcode" class="form-label">Department Code</label>
                            <input type="text" class="form-control" id="deptcode" name="deptcode" placeholder="Department Code" required>
                        </div>
                        <div class="mb-3">
                            <label for="deptname" class="form-label">Department Name</label>
                            <input type="text" class="form-control" id="deptname" name="deptname" placeholder="Department Name" required>
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
                    <h1 class="modal-title fs-5" id="detailModalLabel">Department Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body g-3">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th scope="row" style="background-color: #eeeeee; width: 150px;">Department Code :</th>
                                <td>{{ department.deptcode }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="background-color: #eeeeee; width: 150px;">Department Name :</th>
                                <td>{{ department.deptname }}</td>
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
                departments: <?= json_encode($departments, JSON_UNESCAPED_UNICODE); ?>,
                department: {}
            }
        },
        methods: {
            initfn() {
                this.table = new DataTable('#deptTable', {
                    fixedColumns: {
                        left: 1,
                    },
                    paging: true,
                    scrollX: true,
                });
            },
            showDetail(index) {
                let temp = this.departments[index];
                this.department = temp;

                let detailModal = new bootstrap.Modal('#detailModal', {});
                detailModal.show();
            },
            gotoDetail() {
                window.location.href = '?page=departments/detail&deptcode=' + this.department.deptcode;
            }
        },
        mounted() {
            this.initfn();
        },
    }).mount('#app')
</script>