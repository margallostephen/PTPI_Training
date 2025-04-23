$(document).on("click", ".deleteBtn", function () {
  let departmentId = $(this).data("id");

  Swal.fire({
    title: "Delete Department",
    text: "Are you sure you want to delete this department?",
    icon: "warning",
    iconColor: "#D15B47",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Yes, delete it!",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../../modules/department/delete_department.php",
        type: "POST",
        dataType: "json",
        data: { department_id: departmentId },
        success: function (response) {
          if (response.success) {
            toastr.success(response.message, "Success");
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
    }
  });
});
