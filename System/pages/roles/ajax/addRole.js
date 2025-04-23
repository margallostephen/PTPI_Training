$(document).ready(function () {
  $("#addRoleForm").on("submit", function (e) {
    e.preventDefault();

    $.ajax({
      url: "../../modules/role/add_role.php",
      type: "POST",
      dataType: "json",
      data: {
        role: $("#role").val(),
      },
      success: function (response) {
        if (response.success) {
          toastr.success(response.message, "Success");
          $("#addRoleForm")[0].reset();
          $("#modalAdd").modal("hide");
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
