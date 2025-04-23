$(document).ready(function () {
  $("#editEmployeeForm").on("submit", function (e) {
    e.preventDefault();

    $.ajax({
      url: "../../modules/employee/edit_employee.php",
      type: "POST",
      dataType: "json",
      data: {
        employee_id: $("#employee_id").val(),
        lastname: $("#editLastname").val(),
        firstname: $("#editFirstname").val(),
        middlename: $("#editMiddlename").val(),
        department: $("#editDepartment").val(),
      },
      success: function (response) {
        if (response.success) {
          toastr.success(response.message, "Success");
          $("#editEmployeeForm")[0].reset();
          $("#editDepartment").val("").trigger("change");
          $("#modalEdit").modal("hide");
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
