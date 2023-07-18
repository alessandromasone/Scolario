<?php

use includes\php\AccessControl;
use includes\php\School;

$page_name = "Registrati";

AccessControl::requireRoles(["ospite"]);
AccessControl::requireStatus(["non trovato"]);

init_head($page_name);
get_header($page_name, true);

?>

    <main class="form-global text-center">
        <form method="POST" action="<?php echo PATH; ?>/register" id="to-replace" class="to-ajax">
            <h1 class="fs-3"><?php echo $page_name; ?></h1>
            <p class="text-muted mb-4">È veloce e semplice.</p>
            <div class="row g-2">
                <div class="col-md m-0">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="name" id="floatingName">
                        <label for="floatingName">Nome</label>
                    </div>
                </div>
                <div class="col-md m-0">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="surname" id="floatingSurname">
                        <label for="floatingSurname">Cognome</label>
                    </div>
                </div>
            </div>
            <div class="form-floating mb-3">
                <input type="email" class="form-control" name="email" id="floatingInput">
                <label for="floatingInput">Indirizzo Email</label>
            </div>
            <div class="form-floating mb-4">
                <input type="password" name="password" class="form-control" id="floatingPassword">
                <label for="floatingPassword">Password</label>
            </div>
            <div class="row g-2">
                <div class="col-md m-0">
                    <div class="form-floating mb-3">
                        <select class="form-select" name="role" id="floatingSelectRole">
                            <?php echo role_list_register(); ?>
                        </select>
                        <label for="floatingSelectRole">Ruolo</label>
                    </div>
                </div>
                <div class="col-md m-0">
                    <div class="form-floating mb-3">
                        <select class="form-select" name="school" id="floatingSelectSchool">
                            <?php echo school_list_register(); ?>
                        </select>
                        <label for="floatingSelectSchool">Scuola</label>
                    </div>
                </div>
            </div>

            <?php

            if (RECAPTCHA_SITE !== null) {
                echo '<div class="mb-2 g-recaptcha" data-sitekey="'.RECAPTCHA_SITE.'"></div>';
            }

            ?>


            <button class="w-100 btn btn-lg green-fb mb-2" type="submit">Registrati</button>
            <a href="<?php echo PATH; ?>/login" class="text-primary text-decoration-none"><p>Hai già un account?</p></a>
        </form>
    </main>

<?php

include_js('includes/js/dynamic-form.js');

get_footer();

init_foot();


