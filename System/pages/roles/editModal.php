<div id="modalEdit" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Role</h4>
            </div>
            <form id="editRoleForm">
                <div class="modal-body">
                    <div class="form-group hidden">
                        <label>Role ID</label>
                        <input type="text" class="form-control" id="role_id">
                    </div>
                    <div class="form-group">
                        <label>Role Name</label>
                        <input type="text" class="form-control" id="editRole"
                            oninput="this.value = this.value.toUpperCase()">
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

<script type="text/javascript" src="../roles/ajax/editRole.js<?php echo randomNum() ?>"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $(".editModalBtn").click(function () {
            $("#modalEdit").modal("show");
        });

        $(document).on("click", ".editModalBtn", function () {
            let roleId = $(this).attr('data-id');

            $.ajax({
                url: '../../modules/role/get_role.php',
                type: 'POST',
                data: { role_id: roleId },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        $('#role_id').val(response.data.RID);
                        $('#editRole').val(response.data.ROLE_NAME);
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