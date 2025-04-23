$(document).ready(function () {
  $("#addDepartmentForm").on("submit", function (e) {
    e.preventDefault();

    $.ajax({
      url: " ../../modules/department/add_department.php",
      type: "POST",
      dataType: "json",
      data: {
        department: $("#department").val(),
      },
      success: function (response) {
        if (response.success) {
          toastr.success(response.message, "Success");
          $("#addDepartmentForm")[0].reset();
          $("#modalAdd").modal("hide");
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
        console.error("AJAX request failed: ", error);
      },
    });
  });
});
