
function handleResponse(response) {
    response = JSON.parse(response);
    switch (response.actionType) {
        case 'redirect':
            window.location.href = response.action;
            break;
        case 'reload':
            location.reload();
            break;
        case 'alert':
            creteAlert(response.message, 'warning');
            break;
        case 'replace':
            document.getElementById("to-replace").innerHTML = response.action;
            break;

    }
}

function creteAlert(message, type) {

    const alert = document.createElement('div');
    alert.classList.add('alert', 'alert-' + type, 'position-fixed', 'end-0', 'top-0', 'm-3', 'alert-dismissible');
    alert.textContent = message;

    const closeButton = document.createElement('button');
    closeButton.type = "button";
    closeButton.classList.add('btn-close');
    closeButton.setAttribute('data-bs-dismiss', 'alert');
    closeButton.setAttribute('aria-label', 'Close');
    alert.appendChild(closeButton);

    document.body.appendChild(alert);

    setTimeout(function () {
        alert.remove();
    }, 5000);
}

function logout_account() {
    $.ajax({
        url: PATH + "/logout",
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

function addSpinner() {

    const spinnerHTML = `
    <div class="spinner" id="spinner">
      <div class="spinner-border text-light" style="width: 3rem; height: 3rem;" role="status">
      </div>
    </div>
  `;
    const body = document.querySelector('body');
    body.insertAdjacentHTML('afterbegin', spinnerHTML);
}

function removeSpinner() {
    try {
        const body = document.querySelector('body');
        const spinner = document.querySelector('#spinner');
        body.removeChild(spinner);
    }catch (ex) {

    }

}
function blurActiveElement() {
    // Verifica se c'è un elemento attualmente selezionato
    if (document.activeElement) {
        // Rimuovi il focus dall'elemento attualmente selezionato
        document.activeElement.blur();
    }
}
