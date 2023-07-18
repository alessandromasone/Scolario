<?php

use includes\php\AccessControl;

$page_name = "Visualizza contenuti";

AccessControl::requireRoles(["studente"]);
AccessControl::requireStatus(["attivo"]);

init_head($page_name);
get_header($page_name);


?>

    <main class="container text-center">
        <h1 class="fs-3 mb-4"><?php echo $page_name; ?></h1>
        <div class="d-flex justify-content-start">
            <?php echo get_all_media(); ?>
        </div>
    </main>

<?php

include_js('includes/js/post-media.js');
include_js('includes/js/profile-data.js');

get_footer();
init_foot();