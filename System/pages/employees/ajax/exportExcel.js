$("#exportExcelBtn").on("click", function () {
  const tableData = employeeTable.getData().map((row) => {
    const {
      CREATED_BY,
      CREATED_AT,
      UPDATED_BY,
      UPDATED_AT,
      DELETED_BY,
      DELETED_AT,
      ...filteredRow
    } = row;
    return filteredRow;
  });

  $.ajax({
    url: "../../modules/excel/export_excel.php",
    method: "POST",
    data: JSON.stringify(tableData),
    contentType: "application/json",
    dataType: "json",
    success: function (res) {
      if (res.success && res.file) {
        toastr.success("Exported successfully.", "Success");
        window.location.href = res.file;
      } else {
        toastr.warning("Export failed.", "Warning");
      }
    },
    error: function (error) {
      toastr.error("Something went wrong.", "Error");
      console.error("AJAX request failed:", error);
    },
  });
});
