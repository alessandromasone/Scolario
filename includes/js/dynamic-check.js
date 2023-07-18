$(document).ready(function() {
    // Funzione per eseguire la chiamata AJAX ogni 5 secondi
    setInterval(function() {
        $.ajax({
            url: PATH + '/dynamic-check', // Indirizzo del file PHP che effettua il controllo della sessione
            method: 'POST',
    // Tipo di dati restituiti dalla chiamata AJAX
            success: function(response) {
                // Se la variabile di sessione è cambiata, aggiorna il valore nel client

                handleResponse(response);
            }
        });
    }, 5000); // Intervallo di tempo in millisecondi tra una chiamata AJAX e l'altra
});