<div id="modalReset" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Reset Password</h4>
            </div>
            <form id="resetPassForm">
                <div class="modal-body">
                    <div class="form-group hidden">
                        <label>User ID</label>
                        <input type="text" class="form-control" id="reset_user_id">
                    </div>
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" class="form-control" id="editPassword">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="resetBtn">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" src="../users/ajax/resetPass.js<?php echo randomNum() ?>"></script>
<script type="text/javascript">
    $(document).on("click", ".resetPassBtn", function () {
        $("#modalReset").modal("show");
        $("#reset_user_id").val($(this).attr('data-id'));
    });
</script>