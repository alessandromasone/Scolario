$(document).ready(function () {
    $(document).on("submit", ".to-ajax", function(event) {
        blurActiveElement();
        var done = false;
        setTimeout(function() {
            if (!done) {
                addSpinner();
            }
        }, 500);
        event.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: $(this).attr("action"),
            type: $(this).attr("method"),
            data: formData,
            success: function (response) {
                console.log(response);
                done = true;
                removeSpinner();
                handleResponse(response);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    });
});
