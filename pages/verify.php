<?php

use includes\php\AccessControl;
use includes\php\Token;

$page_name = "Verifica account";

if (isset($_GET['token']) && Token::getUserId($_GET['token'], Token::EMAIL_VERIFICATION_TOKEN) && Token::validate($_GET['token'], Token::EMAIL_VERIFICATION_TOKEN)->getCode() == 0) {

    AccessControl::requireRoles(["studente", "ospite"]);
    AccessControl::requireStatus(["da verificare", "non trovato"]);

    init_head($page_name);
    get_header($page_name, true);

    echo '<main class="text-center">';
    echo '<p>Account verificato, vai al tuo <a href="' . PATH . '/profile">account</a></p>';
} else {

    AccessControl::requireRoles(["studente"]);
    AccessControl::requireStatus(["da verificare"]);

    init_head($page_name);
    get_header($page_name, true);

    echo '<main class="text-center">';
    echo '<p>Richiedi l\'email di verifica <a href="#" onclick="send_verify_email()">qui</a> o effettua il <a href="#" onclick="logout_account()">logout</a></p>';
    echo '<p>Se vuoi puoi eliminare il tuo account <a href="#" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">qui</a></p>';

    ?>

    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAccountModalLabel">Elimina profilo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Sei sicuro di voler eliminare il tuo profilo?
                </div>
                <form class="modal-footer to-ajax" action="<?php echo PATH; ?>/delete/profile" method="post">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                    <button type="submit" class="btn btn-danger">Conferma</button>
                </form>
            </div>
        </div>
    </div>

    <?php

    include_js('includes/js/verify.js');
    include_js('includes/js/dynamic-form.js');

}

echo '</main>';

get_footer();
init_foot();