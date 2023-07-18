function send_verify_email() {
    $.ajax({
        url: PATH + "/verify",
        type: 'POST',
        dataType: 'html',
        success: function (response) {
            handleResponse(response);
        },
        error: function (xhr, status, error) {
            console.error('Errore durante il logout:', error);
        }
    });
}