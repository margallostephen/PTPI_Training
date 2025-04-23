<?php require_once "../../modules/auth/auth_check.php"; ?>

<!DOCTYPE html>
<html lang="en">
<?php require_once "../../includes/header.php"; ?>

<body class="no-skin">
    <?php require_once "../../includes/navbar.php"; ?>
    <div class="main-container ace-save-state" id="main-container">
        <?php require_once "../../includes/sidebar.php"; ?>
        <div class="main-content">
            <div class="main-content-inner">
                <div class="page-content">
                    <div class="page-header">
                        <h1>Departments</h1>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="widget-box widget-color-orange">
                                <div class="widget-header">
                                    <div class="header-title">
                                        List of Departments
                                    </div>
                                </div>
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <div class="p-4">
                                            <?php
                                            require_once 'addModal.php';
                                            require_once 'editModal.php';
                                            ?>
                                            <hr>
                                            <div id="department-table"></div>
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

    <script type="text/javascript" src="../departments/ajax/deleteDepartment.js<?php echo randomNum() ?>"></script>
    <script type="text/javascript">
        let departmentTable;
        $(document).ready(function () {
            departmentTable = initializeTable("department",
                [
                    { title: "ID", field: "RID", headerFilter: "input", vertAlign: "middle" },
                    { title: "DEPARTMENT NAME", field: "DEPT_DESC", headerFilter: "input", vertAlign: "middle" },
                ],
                localStorage.getItem('departmentList')
            );
            populateTable("../../modules/department/get_all_department.php", departmentTable);
        });
    </script>
</body>

</html>