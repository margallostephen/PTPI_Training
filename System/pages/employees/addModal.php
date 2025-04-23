<button type="button" class="btn btn-primary" id="addModalBtn">Add</button>

<div id="modalAdd" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Employee</h4>
            </div>
            <form id="addEmployeeForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control" id="lastname"
                            oninput="this.value = this.value.toUpperCase()">
                    </div>
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" class="form-control" id="firstname"
                            oninput="this.value = this.value.toUpperCase()">
                    </div>
                    <div class="form-group">
                        <label>Middle Name</label>
                        <input type="text" class="form-control" id="middlename"
                            oninput="this.value = this.value.toUpperCase()">
                    </div>
                    <div class="form-group">
                        <label>Select Department</label>
                        <select class="form-select" id="department">
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

<script type="text/javascript" src="../employees/ajax/addEmployee.js<?php echo randomNum() ?>"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#addModalBtn").click(function () {
            populateSelect(
                "../../modules/department/get_all_department.php",
                $('#department').select2({
                    width: '100%'
                })
            );
            $("#modalAdd").modal("show");
        });
    });
</script>