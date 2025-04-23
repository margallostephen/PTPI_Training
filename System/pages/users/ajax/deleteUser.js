$(document).on("click", ".deleteBtn", function () {
  let userId = $(this).data("id");

  if (!userId) {
    console.error("User ID is missing.");
    toastr.error("User ID is missing.", "Error");
    return;
  }

  Swal.fire({
    title: "Delete User Account",
    text: "Are you sure you want to delete this user?",
    icon: "warning",
    iconColor: "#D15B47",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Yes, delete it!",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../../modules/user/delete_user.php",
        type: "POST",
        dataType: "json",
        data: { user_id: userId },
        success: function (response) {
          if (response.success) {
            toastr.success(response.message, "Success");
            populateTable(
              "../../modules/user/get_all_user.php",
              userTable
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
