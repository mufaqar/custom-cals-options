jQuery(document).ready(function ($) {
    $("#custom-registration-form").on("submit", function (e) {
        e.preventDefault(); // Prevent default form submission

        let formData = {
            action: "custom_user_registration_process",
            security: custom_ajax.nonce,
            custom_user_name: $("#custom-user-name").val(),
            custom_user_email: $("#custom-user-email").val(),
            custom_user_phone: $("#custom-user-phone").val(),
            custom_user_address: $("#custom-user-address").val(),
        };

        $("#register-button").prop("disabled", true).text("Registering...");

        $.ajax({
            url: custom_ajax.ajax_url,
            type: "POST",
            data: formData,
            dataType: "json",
            success: function (response) {
                $("#register-button").prop("disabled", false).text("Register");

                if (response.success) {
                    $("#alert-message")
                        .html(response.message)
                        .css("color", "green")
                        .show();
                    $("#custom-registration-form")[0].reset(); // Reset form
                } else {
                    $("#alert-message")
                        .html(response.message)
                        .css("color", "red")
                        .show();
                }
            },
            error: function () {
                $("#register-button").prop("disabled", false).text("Register");
                $("#alert-message")
                    .html("An error occurred. Please try again.")
                    .css("color", "red")
                    .show();
            },
        });
    });
});
