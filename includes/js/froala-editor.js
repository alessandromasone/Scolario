var up_url = PATH + "/post/media/upload";
var del_url = PATH + "/post/media/delete";
var list_url = PATH + "/post/media/list";

(function () {
    new FroalaEditor("#edit", {
        events: {
            'image.beforeRemove': function ($img) {
                var img_link = $img[0].src
                $.ajax({
                    url: del_url,
                    method: "POST",
                    data: {
                        src: img_link,
                    },
                    success: function (data) {

                    }
                });
            },
            'file.unlink': function ($img) {
                var img_link = $img.href;
                $.ajax({
                    url: del_url,
                    method: "POST",
                    data: {
                        src: img_link,
                    },
                    success: function (data) {

                    }

                });
            }
        },
        // Set the file upload parameter.
        fileUploadParam: 'file',
        // Set the file upload URL.
        fileUploadURL: up_url,
        // Additional upload params.
        fileUploadParams: {id: 'my_editor'},
        // Set request type.
        fileUploadMethod: 'POST',
        // Set max file size to 20MB.
        fileMaxSize: 20 * 1024 * 1024,
        // Allow to upload any file.
        fileAllowedTypes: ['*'],
        zIndex: 2501,
        imageManagerDeleteURL: del_url,
        imageManagerLoadURL: list_url,
        imageManagerLoadMethod: 'POST',
        codeMirror: true,
        imageUploadURL: up_url,
        imageUploadParams: {
            id: 'my_editor'
        },
        height: 600,
        attribution: false,
        key: "1C%kZV[IX)_SL}UJHAEFZMUJOYGYQE[\\ZJ]RAe(+%$==",
    })
})();