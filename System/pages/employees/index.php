<?php require_once "../../modules/auth/auth_check.php"; ?>

<!DOCTYPE html>
<html lang="en">
<?php require_once "../../includes/header.php"; ?>
<style>
    .table-btn-container,
    .excel-btn-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }
</style>

<body class="no-skin">
    <?php require_once "../../includes/navbar.php"; ?>
    <div class="main-container ace-save-state" id="main-container">
        <?php require_once "../../includes/sidebar.php"; ?>
        <div class="main-content">
            <div class="main-content-inner">
                <div class="page-content">
                    <div class="page-header">
                        <h1>Employees</h1>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="widget-box widget-color-orange">
                                <div class="widget-header">
                                    <div class="header-title">
                                        List of Employees
                                    </div>
                                </div>
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <div class="p-4">
                                            <div class="table-btn-container">
                                                <?php
                                                require_once 'addModal.php';
                                                require_once 'editModal.php';
                                                require_once 'importModal.php';
                                                ?>
                                                <div class="excel-btn-container">
                                                    <button class="btn btn-md btn-white" id="generateExcelTemplateBtn">
                                                        Generate</button>
                                                    <button class="btn btn-md btn-primary " id="importExcelBtn">
                                                        Import</button>
                                                    <button class="btn btn-md btn-success" id="exportExcelBtn">
                                                        Export</button>
                                                </div>
                                            </div>

                                            <hr>
                                            <div id="employee-table"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php require_once "../../includes/footer.php"; ?>
    </div>

    <script type="text/javascript" src="../employees/ajax/deleteEmployee.js<?php echo randomNum() ?>"></script>
    <script type="text/javascript">
        let employeeTable;
        $(document).ready(function () {
            employeeTable = initializeTable("employee",
                [
                    { title: "ID", field: "RID", headerFilter: "input", vertAlign: "middle" },
                    { title: "FIRSTNAME", field: "FIRSTNAME", headerFilter: "input", vertAlign: "middle" },
                    { title: "LASTNAME", field: "LASTNAME", headerFilter: "input", vertAlign: "middle" },
                    { title: "MIDDLENAME", field: "MIDDLENAME", headerFilter: "input", vertAlign: "middle" },
                    { title: "DEPARTMENT", field: "DEPARTMENT", headerFilter: "input", vertAlign: "middle" },
                    // { title: "CREATED_BY", field: "CREATED_BY", headerFilter: "input", vertAlign: "middle" },
                    // { title: "UPDATED_BY", field: "UPDATED_BY", headerFilter: "input", vertAlign: "middle" },
                    // { title: "DELETED_BY", field: "DELETED_BY", headerFilter: "input", vertAlign: "middle" },
                ],
                localStorage.getItem('employeeList')
            );
            populateTable("../../modules/employee/get_all_employee.php", employeeTable);
        });
    </script>
    <script type="text/javascript" src="../employees/ajax/exportExcel.js<?php echo randomNum() ?>"></script>
    <script type="text/javascript" src="../employees/ajax/generateTemplate.js<?php echo randomNum() ?>"></script>
</body>

</html>