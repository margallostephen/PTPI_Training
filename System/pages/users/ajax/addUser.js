$(document).ready(function () {
  $("#addUserForm").on("submit", function (e) {
    e.preventDefault();

    $.ajax({
      url: "../../modules/user/create_user.php",
      type: "POST",
      dataType: "json",
      data: {
        username: $("#username").val(),
        email: $("#email").val(),
        password: $("#password").val(),
        user_role: $("#role").val(),
        employee_id: $("#employee").val(),
      },
      success: function (response) {
        if (response.success) {
          toastr.success(response.message, "Success");
          $("#addUserForm")[0].reset();
          $("#role").val("").trigger("change");
          $("#modalAdd").modal("hide");
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
