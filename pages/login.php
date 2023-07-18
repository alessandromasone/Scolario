<?php

use includes\php\AccessControl;

$page_name = "Accedi";

AccessControl::requireRoles(["ospite"]);
AccessControl::requireStatus(["non trovato"]);

init_head($page_name);
get_header($page_name, true);

?>

    <main class="form-global text-center">
        <form method="POST" action="<?php echo PATH; ?>/login" class="to-ajax">
            <h1 class="fs-3 mb-4"><?php echo $page_name; ?></h1>
            <div class="form-floating mb-3">
                <input type="email" class="form-control" name="email" id="floatingInput">
                <label for="floatingInput">Indirizzo Email</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" name="password" class="form-control" id="floatingPassword">
                <label for="floatingPassword">Password</label>
            </div>
            <button class="w-100 btn btn-lg blue-fb mb-3" type="submit">Accedi</button>
            <a href="<?php echo PATH; ?>/password/lost" class="text-primary mb-3 text-decoration-none"><p>Password dimenticata?</p></a>
            <a href="<?php echo PATH; ?>/register" class="ps-3 pe-3 btn btn-lg green-fb">Crea nuovo account</a>
        </form>
    </main>

<?php

include_js('includes/js/dynamic-form.js');

get_footer();
init_foot();

