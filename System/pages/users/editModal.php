<div id="modalEdit" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit User</h4>
            </div>
            <form id="editUserForm">
                <div class="modal-body">
                    <div class="form-group hidden">
                        <label>User ID</label>
                        <input type="text" class="form-control" id="user_id">
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" id="editUsername">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" id="editEmail">
                    </div>
                    <div class="form-group">
                        <label>Select Role</label>
                        <select class="form-select" id="editRole">
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Select Employee ID</label>
                        <select class="form-select" id="editEmployee">
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="editBtn">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" src="../users/ajax/editUser.js<?php echo randomNum() ?>"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $(".editModalBtn").click(function () {
            $("#modalEdit").modal("show");
        });

        populateSelect(
            "../../modules/role/get_all_role.php",
            $('#editRole').select2({
                width: '100%'
            })
        );
        populateSelect(
            "../../modules/employee/get_all_employee.php",
            $('#editEmployee').select2({
                width: '100%'
            })
        );

        $(document).on("click", ".editModalBtn", function () {
            let userId = $(this).attr('data-id');

            $.ajax({
                url: '../../modules/user/get_user.php',
                type: 'POST',
                data: { user_id: userId },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        $('#user_id').val(response.data.RID);
                        $('#editUsername').val(response.data.USERNAME);
                        $('#editEmail').val(response.data.EMAIL);
                        $('#editRole').val(response.data.USER_ROLE).trigger('change');
                        $('#editEmployee').val(response.data.EMPLOYEE_ID).trigger('change');
                        $('#modalEdit').modal('show');
                    } else {
                        toastr.warning(response.message, "Warning");
                    }
                },
                error: function (error) {
                    toastr.error("Something went wrong.", "Error");
                    console.error("AJAX request failed:", error);
                }
            });
        });
    });
</script>