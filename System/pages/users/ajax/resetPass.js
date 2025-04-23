$(document).ready(function () {
  $("#resetPassForm").on("submit", function (e) {
    e.preventDefault();

    $.ajax({
      url: "../../modules/user/reset_password.php",
      type: "POST",
      dataType: "json",
      data: {
        user_id: $("#reset_user_id").val(),
        new_password: $("#editPassword").val()
      },
      success: function (response) {
        if (response.success) {
          toastr.success(response.message, "Success");
          $("#resetPassForm")[0].reset();
          $("#modalReset").modal("hide");
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
