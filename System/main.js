function populateSelect(url, select2) {
  $.ajax({
    url: url,
    type: "POST",
    dataType: "json",
    success: function (response) {
      let options = response.data || [];

      select2.empty();

      if (options.length) {
        select2.append(`<option value="">Select</option>`);

        options.forEach((data) => {
          let keys = Object.keys(data);
          let value = data[keys[1]];
          select2.append(`<option value="${data.RID}">
            ${
              !select2.attr("id").toLowerCase().includes("employee")
                ? value
                : `${data.RID} - ${data.LASTNAME}, ${data.FIRSTNAME} ${
                    data.MIDDLENAME ?? ""
                  }`
            }</option>`);
        });
      } else {
        select2.append(
          `<option value="">No ${select2
            .attr("id")
            .replace(/edit/i, "")
            .toLowerCase()}s available</option>`
        );
      }
      select2.trigger("change");
    },
    error: function (error) {
      toastr.error("Something went wrong.", "Error");
      console.error("AJAX request failed:", error);
    },
  });
}

function initializeTable(name, columns, data) {
  const withActions = [
    ...columns,
    {
      title: "ACTIONS",
      field: "RID",
      hozAlign: "center",
      headerSort: false,
      cssClass: "action-column",
      formatter: function (cell) {
        const data = cell.getData();
        const isUserTable = data.IS_DISABLED !== undefined;

        return `
          ${
            isUserTable
              ? `<button class="btn btn-md btn-default statusBtn" data-id="${
                  data.RID
                }"><i class="menu-icon fa fa-${
                  data.IS_DISABLED == "Active" ? "lock" : "unlock"
                }"></i></button>
                <button class="btn btn-md btn-primary resetPassBtn" data-id="${
                  data.RID
                }"><i class="menu-icon fa fa-key"></i></button>`
              : ""
          }
          <button class="btn btn-md btn-warning editModalBtn" data-id="${
            data.RID
          }"><i class="menu-icon fa fa-pencil"></i></button>
          <button class="btn btn-md btn-danger deleteBtn" data-id="${
            data.RID
          }"><i class="menu-icon fa fa-trash"></i></button>
        `;
      },
    },
  ];

  return new Tabulator(`#${name}-table`, {
    layout: "fitColumns",
    pagination: "local",
    paginationSize: 10,
    placeholder: "No records available",
    columns: withActions,
    data: data,
  });
}

function populateTable(url, table, data = {}) {
  $.ajax({
    url: url,
    type: "POST",
    dataType: "json",
    data: data,
    success: function (response) {
      if (!response.success) return table.setData([]);

      const tableId = $(table.element).attr("id").split("-")[0];
      const listKey = `${tableId}List`;
      const isUserTable = tableId.includes("user");
      const dataList = loadDataFromLocalStorage(tableId);

      const formatEmployeeName = (emp) => {
        if (!emp) return "N/A";
        const { FIRSTNAME, MIDDLENAME, LASTNAME } = emp;
        return `${FIRSTNAME} ${MIDDLENAME ?? "N/A"} ${LASTNAME}`;
      };

      let formattedData = response.data.map((obj) => {
        let matchRole, matchDepartment;
        let employeeCreateDetails, employeeEditDetails, employeeDeleteDetails;

        if (isUserTable) {
          matchRole = dataList.roleList.find(
            (item) => item.RID == obj.USER_ROLE
          );
        }

        if (tableId.includes("employee")) {
          matchDepartment = dataList.departmentList.find(
            (item) => item.RID == obj.DEPARTMENT
          );

          const matchCreated = dataList.userList.find(
            (item) => item.RID == obj.CREATED_BY
          );
          const matchUpdated = dataList.userList.find(
            (item) => item.RID == obj.UPDATED_BY
          );
          const matchDeleted = dataList.userList.find(
            (item) => item.RID == obj.DELETED_BY
          );

          employeeCreateDetails = dataList.employeeList.find(
            (emp) => emp.RID == matchCreated?.EMPLOYEE_ID
          );
          employeeEditDetails = dataList.employeeList.find(
            (emp) => emp.RID == matchUpdated?.EMPLOYEE_ID
          );
          employeeDeleteDetails = dataList.employeeList.find(
            (emp) => emp.RID == matchDeleted?.EMPLOYEE_ID
          );
        }

        return {
          ...obj,
          ...(isUserTable && {
            IS_DISABLED: obj.IS_DISABLED == 0 ? "Active" : "Disabled",
            USER_ROLE: matchRole?.ROLE_NAME ?? "",
          }),
          ...(tableId.includes("employee") && {
            MIDDLENAME: obj.MIDDLENAME ?? "N/A",
            DEPARTMENT: matchDepartment?.DEPT_DESC || "",
          }),
          // ...{
          //   UPDATED_AT: obj.UPDATED_AT ?? "N/A",
          //   DELETED_AT: obj.DELETED_AT ?? "N/A",
          //   CREATED_BY: formatEmployeeName(employeeCreateDetails),
          //   UPDATED_BY: formatEmployeeName(employeeEditDetails),
          //   DELETED_BY: formatEmployeeName(employeeDeleteDetails),
          // },
        };
      });

      table.replaceData(formattedData);

      if (localStorage.getItem("selectedStatus") == null)
        localStorage.setItem("selectedStatus", "");

      if (isUserTable && localStorage.getItem("selectedStatus") !== "") return;

      localStorage.setItem(listKey, JSON.stringify(formattedData));
    },
    error: function (error) {
      toastr.error("Something went wrong.", "Error");
      console.error("AJAX request failed:", error);
    },
  });
}

function loadDataFromLocalStorage(tableId) {
  const dataList = {};
  switch (tableId) {
    case "user":
      dataList.roleList = JSON.parse(localStorage.getItem("roleList")) || [];
      break;
    case "employee":
      dataList.departmentList =
        JSON.parse(localStorage.getItem("departmentList")) || [];
      dataList.userList = JSON.parse(localStorage.getItem("userList")) || [];
      dataList.employeeList =
        JSON.parse(localStorage.getItem("employeeList")) || [];
      break;
  }
  return dataList;
}
