<?php

use includes\php\AccessControl;
use includes\php\Post;

$page_name = "Nuovo post";

AccessControl::requireRoles(["studente"]);
AccessControl::requireStatus(["attivo"]);

init_head($page_name, "froala");
get_header($page_name);

?>
    <main class="container text-center">
        <form method="POST" action="<?php echo PATH; ?>/post/add" id="to-replace" class="to-ajax">
            <h1 class="fs-3 mb-4"><?php echo $page_name; ?></h1>
            <div class="row">
                <div class="col-12 col-md-8 mb-3">
                    <textarea name="content" id="edit"></textarea>
                </div>
                <div class="col-12 col-md-4">
                    <div class="input-group input-group-lg">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="title" id="floatingTitle"
                                   aria-describedby="inputGroup-sizing-lg">
                            <label for="floatingTitle">Titolo</label>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="visibility" id="floatingSelectVisibility">
                            <?php echo get_visibility_list_for_post(); ?>
                        </select>
                        <label for="floatingSelectVisibility">Visibilità</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="category" id="floatingSelectCategory">
                            <?php echo get_category_list_for_post(); ?>
                        </select>
                        <label for="floatingSelectVisibility">Categoria</label>
                    </div>
                    <button class="w-100 btn btn-lg green-fb mb-2" type="submit">Crea nuovo post</button>
                </div>
            </div>
        </form>
    </main>

<?php

include_js('includes/js/froala-editor.js');
include_js('includes/js/dynamic-form.js');

get_footer();
init_foot();