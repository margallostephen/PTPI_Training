<div id="modalImport" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Import Excel</h4>
            </div>
            <form id="importExcelForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Select File</label>
                        <input type="file" class="form-control" id="excelFileImport" accept=".xlsx,.xls" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="submitImportExcelBtn">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    let jsonData = [];

    $(document).ready(function () {
        $("#importExcelBtn").click(function () {
            $("#modalImport").modal("show");
        });

        $("#excelFileImport").on("change", function (e) {
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = ({ target }) => {
                const workbook = XLSX.read(new Uint8Array(target.result), { type: "array" });
                jsonData = XLSX.utils.sheet_to_json(workbook.Sheets[workbook.SheetNames[0]], { defval: "" });
            };
            reader.readAsArrayBuffer(file);
        });
    });
</script>
<script type="text/javascript" src="../employees/ajax/importExcel.js<?php echo randomNum() ?>"></script>