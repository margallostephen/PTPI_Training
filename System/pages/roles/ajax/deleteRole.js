$(document).on("click", ".deleteBtn", function () {
  let roleId = $(this).data("id");

  Swal.fire({
    title: "Delete User Role",
    text: "Are you sure you want to delete this role?",
    icon: "warning",
    iconColor: "#D15B47",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Yes, delete it!",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../../modules/role/delete_role.php",
        type: "POST",
        dataType: "json",
        data: { role_id: roleId },
        success: function (response) {
          if (response.success) {
            toastr.success(response.message, "Success");
            populateTable(
              "../../modules/role/get_all_role.php",
              roleTable
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
