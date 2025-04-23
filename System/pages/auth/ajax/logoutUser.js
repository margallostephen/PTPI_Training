$("#logoutBtn").click(function () {
  $.ajax({
    url: "/System/modules/auth/logout_user.php",
    type: "POST",
    dataType: "json",
    success: function (response) {
      if (response.success) {
        localStorage.clear();
        toastr.success("Log out successfully.", "Success");
        setTimeout(() => {
          window.location.href = "/System/pages/auth";
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
