<?php

use includes\php\AccessControl;

$page_name = "Stato account";

AccessControl::requireRoles(["ospite", "studente"]);
AccessControl::requireStatus(["bloccato", "da validare",]);

init_head($page_name);
get_header($page_name, true);


?>

    <main class="text-center">
        <p>Il tuo account deve essere cambiato di stato contatta l'amministrazione o effettua il <a
                    href="<?php echo PATH; ?>/logout">logout</a>. Se vuoi puoi eliminare il tuo account
            <a href="#" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">qui</a>
        </p>
    </main>
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

get_footer();
init_foot();