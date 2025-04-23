<button type="button" class="btn btn-primary" id="addModalBtn">Add</button>

<div id="modalAdd" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add User</h4>
            </div>
            <form id="addUserForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" id="username">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" id="email">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" id="password">
                    </div>
                    <div class="form-group">
                        <label>Select Role</label>
                        <select class="form-select" id="role">
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Select Employee ID</label>
                        <select class="form-select" id="employee">
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="addBtn">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" src="../users/ajax/addUser.js<?php echo randomNum() ?>"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#addModalBtn").click(function () {
            populateSelect(
                "../../modules/role/get_all_role.php",
                $('#role').select2({
                    width: '100%'
                })
            );
            populateSelect(
                "../../modules/employee/get_all_employee.php",
                $('#employee').select2({
                    width: '100%'
                })
            );
            $("#modalAdd").modal("show");
        });
    });
</script>