<?php

use includes\php\AccessControl;

$page_name = "Password dimenticata";

AccessControl::requireRoles(["ospite"]);
AccessControl::requireStatus(["non trovato"]);

init_head($page_name);
get_header($page_name, true);

?>

    <main class="form-global text-center" id="to-replace">
        <form method="POST" action="<?php echo PATH; ?>/password/lost" class="to-ajax">
            <h1 class="fs-3 mb-4"><?php echo $page_name; ?></h1>
            <div class="form-floating mb-3">
                <input type="email" class="form-control" name="email" id="floatingInput">
                <label for="floatingInput">Indirizzo Email</label>
            </div>

            <?php

            if (RECAPTCHA_SITE !== null) {
                echo '<div class="mb-2 g-recaptcha" data-sitekey="'.RECAPTCHA_SITE.'"></div>';
            }

            ?>

            <button class="w-100 btn btn-lg blue-fb mb-3" type="submit">Invia richiesta</button>
            <a href="<?php echo PATH; ?>/login" class="text-primary text-decoration-none"><p>Ricordi la password?</p>
            </a>
        </form>
    </main>

<?php

include_js('includes/js/dynamic-form.js');

get_footer();
init_foot();