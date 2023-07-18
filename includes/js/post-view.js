function updateLike(id) {
    $.ajax({
        url: PATH + "/post/like",
        type: "POST",
        data: {id: id},
        success: function (response) {

            if (response === '0') {
                changeDivContent('update-like-text', 'Lascia un mi piace');
                decreaseNumber('update-like-number');
            } else if (response === '1') {
                changeDivContent('update-like-text', 'Rimuovi il mi piace');
                increaseNumber('update-like-number');
            } else {

            }
        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
}

function changeDivContent(id, newContent) {
    var element = document.getElementById(id);
    if (element) {
        element.innerHTML = newContent;
    }
}

function decreaseNumber(id) {
    var element = document.getElementById(id);
    if (element) {
        var currentNumber = parseInt(element.innerHTML);
        if (!isNaN(currentNumber)) {
            element.innerHTML = currentNumber - 1;
        }
    }
}

function increaseNumber(id) {
    var element = document.getElementById(id);
    if (element) {
        var currentNumber = parseInt(element.innerHTML);
        if (!isNaN(currentNumber)) {
            element.innerHTML = currentNumber + 1;
        }
    }
}