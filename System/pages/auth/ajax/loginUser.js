$(document).ready(function () {
  $("#loginForm").on("submit", function (e) {
    e.preventDefault();

    $.ajax({
      url: "../../modules/auth/login_user.php",
      type: "POST",
      dataType: "json",
      data: {
        user: $("#user").val(),
        password: $("#password").val(),
      },
      success: function (response) {
        if (response.success) {
          toastr.success("Log in successfully.", "Success");
          $("#loginForm")[0].reset();
          setTimeout(() => {
            window.location.href = "../../pages/dashboard";
          }, 1000);
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
