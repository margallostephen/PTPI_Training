$(document).on("click", ".deleteBtn", function () {
  let employeeId = $(this).data("id");

  if (!employeeId) {
    console.error("Employee ID is missing.");
    toastr.error("Employee ID is missing.", "Error");
    return;
  }

  Swal.fire({
    title: "Delete Employee Record",
    text: "Are you sure you want to delete this employee?",
    icon: "warning",
    iconColor: "#D15B47",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Yes, delete it!",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../../modules/employee/delete_employee.php",
        type: "POST",
        dataType: "json",
        data: { employee_id: employeeId },
        success: function (response) {
          if (response.success) {
            toastr.success(response.message, "Success");
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
    }
  });
});
