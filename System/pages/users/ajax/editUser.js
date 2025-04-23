$(document).ready(function () {
  $("#editUserForm").on("submit", function (e) {
    e.preventDefault();

    $.ajax({
      url: "../../modules/user/edit_user.php",
      type: "POST",
      dataType: "json",
      data: {
        user_id: $("#user_id").val(),
        username: $("#editUsername").val(),
        email: $("#editEmail").val(),
        user_role: $("#editRole").val(),
        employee_id: $("#editEmployee").val(),
      },
      success: function (response) {
        if (response.success) {
          toastr.success(response.message, "Success");
          $("#editUserForm")[0].reset();
          $("#editRole, #editEmployee").val("").trigger("change");
          $("#modalEdit").modal("hide");
          populateTable("../../modules/user/get_all_user.php", userTable);
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
