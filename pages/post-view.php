<?php

use includes\php\AccessControl;
use includes\php\Post;
use includes\php\School;
use includes\php\User;

AccessControl::requireRoles(["ospite", "studente"]);
AccessControl::requireStatus(["attivo", "non trovato"]);

$post = Post::getForView($_GET['id']);

if (!$post) {
    header("Location: " . PATH . '/not-found');
    die();
}

$page_name = $post['title'];

init_head($page_name);
get_header($page_name);

?>

    <main class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-3 mb-3">
                <div class="border rounded mb-3 p-3">
                    <h6 class="mb-0">Autore</h6>
                    <p><?php echo User::getFullNameById($post['author']); ?></p>
                    <h6 class="mb-0">Visibilità</h6>
                    <p><?php echo Post::getVisibilityNameById($post['visibility']); ?></p>
                    <h6 class="mb-0">Scuola</h6>
                    <p class="mb-0"><?php echo School::getNameById(User::getSchoolIdById($post['author'])); ?></p>
                </div>
                <div class="border rounded mb-3 p-3 d-flex align-items-center flex-row">
                    <h6 class="red-fb p-2 rounded icon-post-custom d-flex justify-content-center align-items-center flex-column">
                        <i class="bi bi-heart-fill"></i><span
                                id="update-like-number"><?php echo Post::getLikes($post['id']); ?></span></h6>
                    <?php if (User::hasLikedPost($post['id']) && isset($_SESSION['id'])): ?>
                        <a href="javascript: void(0)" onclick="updateLike(<?php echo $post['id'] ?>)"
                           class="mb-2 ms-2 text-decoration-none" id="update-like-text">Rimuovi il mi piace</a>
                    <?php elseif (isset($_SESSION['id'])) : ?>
                        <a href="javascript: void(0)" onclick="updateLike(<?php echo $post['id'] ?>)"
                           class="mb-2 ms-2 text-decoration-none" id="update-like-text">Lascia un mi piace</a>
                    <?php else: ?>
                        <a href="<?php echo PATH; ?>/login" class="mb-2 ms-2 text-decoration-none">Accedi per lasciare un
                            mi piace</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-12 col-lg-6 mb-3 p-lg-0" id="content-post">
                <h1 class="text-center"><?php echo $post['title'] ?></h1>
                <div><?php echo $post['content'] ?></div>
            </div>
            <div class="col-12 col-lg-3 mb-3">
                <div class="border rounded mb-3 p-3">
                    <?php get_account_area(); ?>
                </div>
            </div>
        </div>
    </main>

<?php

include_js('includes/js/post-view.js');

get_footer();
init_foot();