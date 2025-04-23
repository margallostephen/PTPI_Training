$("#generateExcelTemplateBtn").on("click", function () {
  const data = {
    headers: ["RID", "LASTNAME", "FIRSTNAME", "MIDDLENAME", "DEPARTMENT"],
  };

  fetch("../../modules/excel/generate_template.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  })
    .then((response) => response.blob())
    .then((blob) => {
      const url = URL.createObjectURL(blob);
      const link = document.createElement("a");
      link.href = url;
      link.download = "employee_data_template.xlsx";
      document.body.appendChild(link);
      link.click();
      URL.revokeObjectURL(url);
      toastr.success("Template generated.", "Success");
    })
    .catch((error) => {
      toastr.error("Something went wrong.", "Error");
      console.error("AJAX request failed:", error);
    });
});
