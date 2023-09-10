<?php
$stmt = $conn->prepare("SELECT equipments.equipcode, equipments.equipname, equipments.equipmodel, equipments.equipsn, borrowing.status 
FROM equipments LEFT JOIN (SELECT * FROM borrowing WHERE status !=0) AS borrowing ON equipments.equipcode = borrowing.equipcode");
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
    <h1>BNH Medical Gas</h1>
    <hr />
    <div class="container">
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

    <!-- detailModal -->
    <div class="modal fade" id="detailModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="detailModalModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="detailModalLabel">General Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body g-3">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th scope="row" style="background-color: #eeeeee; width: 150px;">ID Code:</th>
                                <td>{{ equipment.equipcode }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="background-color: #eeeeee; width: 150px;">Type Gas :</th>
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
                                <th scope="row" style="background-color: #eeeeee; width: 150px;">Status :</th>
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
                equipments: <?= json_encode($equipments, JSON_UNESCAPED_UNICODE) ?>,
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
        mounted() {
            this.initfn();
        },
    }).mount('#app')
</script>