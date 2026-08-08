window.addEventListener("load", function () {
    var edit_profile_form = document.getElementById("edit-profile-form");
    edit_profile_form.addEventListener("submit", function (event) {
        var XHR = new XMLHttpRequest();
        var form_data = new FormData(edit_profile_form);

        // On success
        XHR.addEventListener("load", edit_profile_success);

        // On error
        XHR.addEventListener("error", edit_profile_error);

        // Set up request
        XHR.open("POST", "api/update_profile.php");

        // Form data is sent with request
        XHR.send(form_data);

        event.preventDefault();
    });
});

var edit_profile_success = function (event) {
    var response = JSON.parse(event.target.responseText);
    if (response.success) {
        alert(response.message);
        window.location.href = "dashboard.php";
    } else {
        alert(response.message);
    }
};

var edit_profile_error = function (event) {
    alert('Oops! Something went wrong.');
};
