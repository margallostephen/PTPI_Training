$(document).ready(function () {
  $("#editRoleForm").on("submit", function (e) {
    e.preventDefault();

    $.ajax({
      url: "../../modules/role/edit_role.php",
      type: "POST",
      dataType: "json",
      data: {
        role_id: $("#role_id").val(),
        role_name: $("#editRole").val(),
      },
      success: function (response) {
        if (response.success) {
          toastr.success(response.message, "Success");
          $("#editRoleForm")[0].reset();
          $("#modalEdit").modal("hide");
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
  });
});
