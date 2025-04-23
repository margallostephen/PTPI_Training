$(document).on("click", ".statusBtn", function () {
    let userId = $(this).data("id");
  
    Swal.fire({
      title: "Change User Status",
      text: "Are you sure you want to change the status of this user?",
      icon: "warning",
      iconColor: "#D15B47",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Yes, change it!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "../../modules/user/change_user_status.php",
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
  