<?php

use includes\php\AccessControl;
use includes\php\School;

$page_name = "Gestisci profilo";

AccessControl::requireRoles(["studente"]);
AccessControl::requireStatus(["attivo"]);

init_head($page_name);
get_header($page_name);

?>

    <main class="form-global text-center">
        <form method="POST" action="<?php echo PATH; ?>/profile" id="to-replace" class="to-ajax">
            <h1 class="fs-3 mb-4"><?php echo $page_name; ?></h1>
            <div class="row g-2">
                <div class="col-md m-0">
                    <div class="form-floating mb-2">
                        <input type="text" class="form-control on-listen" name="name" id="floatingName"
                               value="<?php echo $_SESSION['name']; ?>">
                        <label for="floatingName">Nome</label>
                    </div>
                </div>
                <div class="col-md m-0">
                    <div class="form-floating mb-2">
                        <input type="text" class="form-control on-listen" name="surname" id="floatingSurname"
                               value="<?php echo $_SESSION['surname']; ?>">
                        <label for="floatingSurname">Cognome</label>
                    </div>
                </div>
            </div>
            <div class="form-floating mb-3 opacity-layer">
                <input type="email" class="form-control" name="email" id="floatingInput"
                       value="<?php echo $_SESSION['email']; ?>" readonly>
                <label for="floatingInput">Indirizzo Email</label>
            </div>
            <div class="row g-2">
                <div class="col-md m-0">
                    <div class="form-floating mb-2">
                        <input type="text" class="form-control on-listen" name="password" id="floatingPassword">
                        <label for="floatingPassword">Password</label>
                    </div>
                </div>
                <div class="col-md m-0">
                    <div class="form-floating mb-2">
                        <input type="text" class="form-control on-listen" name="password-new" id="floatingPasswordNew">
                        <label for="floatingPasswordNew">Nuova password</label>
                    </div>
                </div>
            </div>
            <div class="form-floating mb-2 opacity-layer">
                <input type="text" class="form-control" name="school" id="floatingSchool"
                       value="<?php echo School::getNameById($_SESSION['school']); ?>" readonly>
                <label for="floatingSchool">Scuola</label>
            </div>
            <div class="d-flex justify-content-start mb-3">
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                    <i class="bi bi-trash"></i> Elimina profilo
                </button>
            </div>
        </form>
    </main>

    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
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

include_js('includes/js/dynamic-form.js');
include_js('includes/js/profile-data.js');

get_footer();
init_foot();