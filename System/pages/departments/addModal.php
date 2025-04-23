<button type="button" class="btn btn-primary" id="addModalBtn">Add</button>

<div id="modalAdd" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Department</h4>
            </div>
            <form id="addDepartmentForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Department Name</label>
                        <input type="text" class="form-control" id="department"
                            oninput="this.value = this.value.toUpperCase()">
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

<script type="text/javascript" src="../departments/ajax/addDepartment.js<?php echo randomNum() ?>"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#addModalBtn").click(function () {
            $("#modalAdd").modal("show");
        });
    });
</script>