function delete_media(id, hash) {
    $.ajax({
        url: PATH + "/post/media/delete",
        type: 'POST',
        data: {
            hash: hash
        },
        success: function (response) {
            if (response === '0') {
                const element = document.getElementById("media-" + id);
                element.remove();
            }
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });

}