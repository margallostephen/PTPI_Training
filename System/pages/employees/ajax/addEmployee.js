$(document).ready(function () {
  $("#addEmployeeForm").on("submit", function (e) {
    e.preventDefault();

    $.ajax({
      url: "../../modules/employee/add_employee.php",
      type: "POST",
      dataType: "json",
      data: {
        lastname: $("#lastname").val(),
        firstname: $("#firstname").val(),
        middlename: $("#middlename").val(),
        department: $("#department").val(),
      },
      success: function (response) {
        if (response.success) {
          toastr.success(response.message, "Success");
          $("#addEmployeeForm")[0].reset();
          $("#department").val("").trigger("change");
          $("#modalAdd").modal("hide");
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
