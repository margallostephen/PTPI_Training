<div id="modalEdit" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Employee</h4>
            </div>
            <form id="editEmployeeForm">
                <div class="modal-body">
                    <div class="form-group hidden">
                        <label>Employee ID</label>
                        <input type="text" class="form-control" id="employee_id">
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control" id="editLastname"
                            oninput="this.value = this.value.toUpperCase()">
                    </div>
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" class="form-control" id="editFirstname"
                            oninput="this.value = this.value.toUpperCase()">
                    </div>
                    <div class="form-group">
                        <label>Middle Name</label>
                        <input type="text" class="form-control" id="editMiddlename"
                            oninput="this.value = this.value.toUpperCase()">
                    </div>
                    <div class="form-group">
                        <label>Select Department</label>
                        <select class="form-select" id="editDepartment">
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

<script type="text/javascript" src="../employees/ajax/editEmployee.js<?php echo randomNum() ?>"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $(".editModalBtn").click(function () {
            $("#modalEdit").modal("show");
        });

        populateSelect(
            "../../modules/department/get_all_department.php",
            $('#editDepartment').select2({
                width: '100%'
            })
        );

        $(document).on("click", ".editModalBtn", function () {
            let employeeId = $(this).attr('data-id');

            $.ajax({
                url: '../../modules/employee/get_employee.php',
                type: 'POST',
                data: { employee_id: employeeId },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        $('#employee_id').val(response.data.RID);
                        $('#editFirstname').val(response.data.FIRSTNAME);
                        $('#editLastname').val(response.data.LASTNAME);
                        $('#editMiddlename').val(response.data.MIDDLENAME);
                        $('#editDepartment').val(response.data.DEPARTMENT).trigger('change');
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