$(document).ready(function () {
  $("#importExcelForm").on("submit", function (e) {
    e.preventDefault();

    const departmentList =
      JSON.parse(localStorage.getItem("departmentList")) || [];

    const cleanedData = jsonData.map((emp) => {
      return {
        ...emp,
        MIDDLENAME: emp.MIDDLENAME === "N/A" ? null : emp.MIDDLENAME,
        DEPARTMENT:
          (
            departmentList.find(
              (dept) => dept.DEPT_DESC == emp.DEPARTMENT.toUpperCase()
            ) ?? {}
          ).RID ?? null,
      };
    });

    $.ajax({
      url: "../../modules/excel/import_excel.php",
      method: "POST",
      data: JSON.stringify({
        table: "employees",
        data: cleanedData,
      }),
      contentType: "application/json",
      dataType: "json",
      success: function (response) {
        if (response.success) {
          toastr.success(response.message, "Success");
          $("#importExcelForm")[0].reset();
          $("#modalImport").modal("hide");
          populateTable(
            "../../modules/employee/get_all_employee.php",
            employeeTable
          );
        } else {
          toastr.warning(response.message, "Warning");
        }
      },
      error: function (error) {
        toastr.error("Something went wrong.", "Error");
        console.error("AJAX request failed:", error);
      },
    });
  });
});
