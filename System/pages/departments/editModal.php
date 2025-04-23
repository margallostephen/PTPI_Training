<div id="modalEdit" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Department</h4>
            </div>
            <form id="editDepartmentForm">
                <div class="modal-body">
                    <div class="form-group hidden">
                        <label>Department ID</label>
                        <input type="text" class="form-control" id="department_id">
                    </div>
                    <div class="form-group">
                        <label>Department Name</label>
                        <input type="text" class="form-control" id="editDepartment"
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

<script type="text/javascript" src="../departments/ajax/editDepartment.js<?php echo randomNum() ?>"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".editModalBtn").click(function () {
            $("#modalEdit").modal("show");
        });

        $(document).on("click", ".editModalBtn", function () {
            let departmentId = $(this).attr('data-id');

            $.ajax({
                url: '../../modules/department/get_department.php',
                type: 'POST',
                data: { department_id: departmentId },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        $('#department_id').val(response.data.RID);
                        $('#editDepartment').val(response.data.DEPT_DESC);
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