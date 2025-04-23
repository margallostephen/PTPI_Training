$(document).ready(function () {
  $("#editDepartmentForm").on("submit", function (e) {
    e.preventDefault();

    $.ajax({
      url: "../../modules/department/edit_department.php",
      type: "POST",
      dataType: "json",
      data: {
        department_id: $("#department_id").val(),
        department_name: $("#editDepartment").val(),
      },
      success: function (response) {
        if (response.success) {
          toastr.success(response.message, "Success");
          $("#editDepartmentForm")[0].reset();
          $("#modalEdit").modal("hide");
          populateTable(
            "../../modules/department/get_all_department.php",
            departmentTable
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
