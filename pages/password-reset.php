<?php

use includes\php\AccessControl;
use includes\php\Token;

$page_name = "Reimposta password";

AccessControl::requireRoles(["ospite"]);
AccessControl::requireStatus(["non trovato"]);

init_head($page_name);
get_header($page_name, true);

if (isset($_GET['token']) && $_GET['token'] != '' && Token::getUserId($_GET['token'], Token::PASSWORD_LOST_TOKEN)) {
    ?>
    <main class="form-global text-center" id="to-replace">
        <form method="POST" action="<?php echo PATH; ?>/password/reset" class="to-ajax">
            <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
            <h1 class="fs-3 mb-4"><?php echo $page_name; ?></h1>
            <div class="form-floating mb-3">
                <input type="password" name="password" class="form-control" id="floatingPassword">
                <label for="floatingPassword">Nuova password</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" name="confirm_password" class="form-control" id="floatingConfirm">
                <label for="floatingConfirm">Conferma password</label>
            </div>
            <button class="w-100 btn btn-lg blue-fb mb-3" type="submit">Conferma</button>
            <a href="<?php echo PATH; ?>/login" class="text-primary text-decoration-none"><p>Ritorna al login</p></a>
        </form>
    </main>
    <?php

    include_js('includes/js/dynamic-form.js');
    get_footer();
    init_foot();

} else {

    header('Location: ' . PATH . '/access-restricted');
    die();

}
