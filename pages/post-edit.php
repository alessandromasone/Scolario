<?php

$page_name = 'Modifica';

use includes\php\AccessControl;
use includes\php\Post;

AccessControl::requireRoles(["studente"]);
AccessControl::requireStatus(["attivo"]);

$check = Post::checkPermissionOnPost($_SESSION['id'], $_GET['id']);

if ($check) {

    init_head($page_name, "froala");
    get_header($page_name);

    $post = Post::get($_GET['id']);

    ?>

    <main class="container text-center">
        <form method="POST" action="<?php echo PATH; ?>/post/edit" id="to-replace" class="to-ajax">
            <input type="hidden" name="id" value="<?php echo $post['id'] ?>" />
            <h1 class="fs-3 mb-4"><?php echo $page_name; ?></h1>
            <div class="row">
                <div class="col-12 col-md-8 mb-3">
                    <textarea name="content" id="edit"><?php echo $post['content'] ?></textarea>
                </div>
                <div class="col-12 col-md-4 mb-3">
                    <div class="input-group input-group-lg">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="title" id="floatingTitle"
                                   aria-describedby="inputGroup-sizing-lg" value="<?php echo $post['title'] ?>">
                            <label for="floatingTitle">Titolo</label>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="visibility" id="floatingSelectVisibility">
                            <?php echo get_visibility_list_for_post(Post::getVisibilityNameById($post['visibility'])); ?>
                        </select>
                        <label for="floatingSelectVisibility">Visibilità</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="category" id="floatingSelectCategory">
                            <?php echo get_category_list_for_post(Post::getCategoryNameById($post['category'])); ?>
                        </select>
                        <label for="floatingSelectVisibility">Categoria</label>
                    </div>
                    <button class="w-100 btn btn-lg blue-fb mb-2" type="submit">Aggiorna</button>
                </div>
            </div>
        </form>
    </main>

    <?php

    include_js('includes/js/froala-editor.js');
    include_js('includes/js/dynamic-form.js');

    get_footer();
    init_foot();


} else {

    header('Location: ' . PATH . '/access-restricted');
    die();

}