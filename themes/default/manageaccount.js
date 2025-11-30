$(document).on("submit", ".add_account_form", function (e) {
  e.preventDefault();
  e.stopImmediatePropagation();

  let form = $(this);
  let actionUrl = form.attr("action");
  let formData = new FormData(this);
  let current_login = formData.get("current_login");
  let login_d = formData.get("login_d");

  if (localStorage.getItem("users"))
    {
      let users = JSON.parse(localStorage.getItem("users"));
      const found = users.some((el) => el.login === current_login);
      if (!found) {
        formData.append("current_token", 1);
      }
      const alreadyAdded = users.some((el) => el.login === login_d);
      if (alreadyAdded) {
        $(".add-account-error-msg").html("This account is already added!");
        $(".add-account-error-msg").show();
        return false;
      }
    }
  else {
    formData.append("current_token", 1);
  }

  $(".add-account-error-msg").hide();
  let submitButton = $(this).find(":input[type=submit]");
  submitButton.prop("disabled", true);
  $.ajax({
    type: "POST",
    url: actionUrl + "&theonepage=1",
    data: formData, // serializes the form's elements.
    dataType: "json",
    processData: false,
    contentType: false,
    success: function (res) {
      if (res.status == "success") {
        let users = [];
        if (localStorage.getItem("users")) {
          users = JSON.parse(localStorage.getItem("users"));
        }
        let newUser = { login: res.login, name: res.name, token: res.token };
        const found = users.some((el) => el.login === res.login);
        if (!found) users.push(newUser);

        if (res.currentToken !== undefined) {
          const checkexist = users.some(
            (el) => el.login === res.currentToken.login
          );
          if (!checkexist) users.push(res.currentToken);
        }
        localStorage.setItem("users", JSON.stringify(users));
        document.location.href =
          "./index.php?m=manageaccount&d=switchaccount&token=" + res.token;
      } else {
        submitButton.prop("disabled", false);
        $(".add-account-error-msg").text(res.error_message);
        $(".add-account-error-msg").show();
      }
    },
  });
});

$(document).ready(function () {
  showAccountList();
  getCurrentAccountToken();
});

function getCurrentAccountToken() {
  let getcurrentusertoken = false;
  if ($(".switch-current-account-a").length > 0) {
    let current_login = $(".switch-current-account-a").data("current-login");
    if (localStorage.getItem("users")) {
      let usersacc = JSON.parse(localStorage.getItem("users"));
      const existcheck = usersacc.some((el) => el.login === current_login);
      if (!existcheck) {
        getcurrentusertoken = true;
      }
    } else {
      getcurrentusertoken = true;
    }
  }
  if (getcurrentusertoken) {
    $.ajax({
      type: "GET",
      url: "index.php?m=manageaccount&d=currentaccounttoken&theonepage=1",
      dataType: "json",
      processData: false,
      contentType: false,
      success: function (res) {
        if (res.status == "success") {
          let users = [];
          if (localStorage.getItem("users")) {
            users = JSON.parse(localStorage.getItem("users"));
          }
          let newUser = { login: res.login, name: res.name, token: res.token };
          const found = users.some((el) => el.login === res.login);
          if (!found) users.push(newUser);

          localStorage.setItem("users", JSON.stringify(users));
          showAccountList();
        }
      },
    });
  }
}

function showAccountList() {
  $(".switch-account-a").closest("li").remove();
  let accounts = localStorage.getItem("users");
  let currentUser = $(".switch-current-account-a").data("current-login");
  if (accounts) {
    let accountsArr = JSON.parse(accounts);
    let html = "";
    accountsArr.forEach((element) => {
      if (element.login != currentUser) {
        html +=
          "<li class='bg-light-gray'><a href='javascript:void(0)' class='switch-account-a'><div class='flex'><div class='account-switcher'><span class='main-text'>" +
          element.name +
          "</span><span class='account-login-email'>" +
          element.login +
          "</span></div><i class='fa fa-thin fa-angle-down sa-font-icon'></i></div></a><div class=' switch-account-d'><a href='index.php?m=manageaccount&d=switchaccount&token=" +
          element.token +
          "' class='btn btn-primary'>Sign In</a><a href='javascript:void(0)' data-login='" +
          element.login +
          "' class='btn btn-danger switch-remove-account'>Remove</a></div></li>";
      }
    });
    $(".switch-current-account-a").closest("li").after(html);
  }
}

$(document).on(
  "click",
  ".switch-account-a , .switch-current-account-a",
  function (e) {
    e.stopPropagation();
    e.stopImmediatePropagation();
    let manageEleD = $(this).closest("li").find(".switch-account-d");

    manageEleD.toggle();
    if (manageEleD.is(":visible")) {
      $(this).closest("li").find(".sa-font-icon").removeClass("fa-angle-down");
      $(this).closest("li").find(".sa-font-icon").addClass("fa-angle-up");
    } else {
      $(this).closest("li").find(".sa-font-icon").addClass("fa-angle-down");
      $(this).closest("li").find(".sa-font-icon").removeClass("fa-angle-up");
    }
  }
);

$(document).on("click", ".switch-remove-account", function (e) {
  let isCurrentLogin = $(this).data("current-login");
  e.stopPropagation();
  let login = $(this).data("login");
  if (localStorage.getItem("users")) {
    accounts = JSON.parse(localStorage.getItem("users"));
  }
  let accountlistArr = accounts.filter(function (obj) {
    return obj.login != login;
  });
  localStorage.setItem("users", JSON.stringify(accountlistArr));
  if (isCurrentLogin != "undefined" && isCurrentLogin == 1) {
    window.location.href = "index.php?m=account&d=logout";
  }
  showAccountList();
});

$(document).on("click", ".user-choose-account-another", function (e) {
  $(".view-choose-account-block").hide();
  $(".view-login-block").show();
});

$(document).ready(function () {
  if ($(".user-choose-account-another").length > 0) {
    let accounts = localStorage.getItem("users");
    if (accounts) {
      let accountsArr = JSON.parse(accounts);
      if (accountsArr.length == 0) {
        $(".view-choose-account-block").hide();
        $(".view-login-block").show();
        return;
      }
      let html = "";
      accountsArr.forEach((element) => {
        html +=
          "<div class='user-choose-account row'> <a  href='index.php?m=manageaccount&d=switchaccount&token=" +
          element.token +
          "'><div class='col-xs-2 letter-badge-circle' data-letters-account='" +
          element.name.charAt(0) +
          "'></div><div class='col-xs-10' > <h5 >" +
          element.name +
          "</h5> <p>" +
          element.login +
          "</p></div></a></div>";
      });
      $(".user-choose-account-another").before(html);
    } else {
      $(".view-choose-account-block").hide();
      $(".view-login-block").show();
    }
  }
});
