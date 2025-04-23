<?php require_once "../../modules/auth/auth_check.php"; ?>

<!DOCTYPE html>
<html lang="en">
<?php require_once "../../includes/header.php"; ?>
<style>
    .table-btn-container,
    #statusSelectContainer {
        max-width: fit-content;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
    }

    #statusSelectContainer,
    #statusSelectContainer label {
        margin: 0px;
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
                        <h1>User Management</h1>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="widget-box widget-color-orange">
                                <div class="widget-header">
                                    <div class="header-title">
                                        List of Users
                                    </div>
                                </div>
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <div class="p-4">
                                            <div class="table-btn-container">
                                                <?php
                                                require_once 'addModal.php';
                                                require_once 'editModal.php';
                                                require_once 'resetModal.php';
                                                ?>
                                                <div class="form-group" id="statusSelectContainer">
                                                    <label>Status: </label>
                                                    <select class="form-select" id="status">
                                                        <option value="">Select</option>
                                                        <option value="0">Active</option>
                                                        <option value="1">Disabled</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <hr>
                                            <div id="user-table"></div>
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

    <script type="text/javascript" src="../users/ajax/deleteUser.js<?php echo randomNum() ?>"></script>
    <script type="text/javascript" src="../users/ajax/changeStatus.js<?php echo randomNum() ?>"></script>
    <script type="text/javascript">
        let userTable;
        $(document).ready(function () {
            userTable = initializeTable("user",
                [
                    { title: "ID", field: "RID", headerFilter: "input", vertAlign: "middle" },
                    { title: "EMPLOYEE ID", field: "EMPLOYEE_ID", headerFilter: "input", vertAlign: "middle" },
                    { title: "USERNAME", field: "USERNAME", headerFilter: "input", vertAlign: "middle" },
                    { title: "EMAIL", field: "EMAIL", headerFilter: "input", vertAlign: "middle" },
                    { title: "STATUS", field: "IS_DISABLED", headerFilter: "input", vertAlign: "middle" },
                    { title: "USER ROLE", field: "USER_ROLE", headerFilter: "input", vertAlign: "middle" },
                ],
                localStorage.getItem('userList')
            );
            populateTable("../../modules/user/get_all_user.php", userTable);
        });

        const key = 'selectedStatus';
        const $selectStatus = $('#status').select2({ minimumResultsForSearch: Infinity, width: "100%" });

        $selectStatus.val(localStorage.getItem(key)).trigger('change.select2');

        $selectStatus.on('change', () => {
            localStorage.setItem(key, $selectStatus.val());

            populateTable("../../modules/user/get_all_user.php", userTable, { status: localStorage.getItem(key) });
        });

    </script>
</body>

</html>