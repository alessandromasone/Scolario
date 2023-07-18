<?php

use includes\php\AccessControl;

$page_name = "Mie post";

AccessControl::requireRoles(["studente"]);
AccessControl::requireStatus(["attivo"]);

init_head($page_name);
get_header($page_name);

?>

    <main class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-3 mb-3">
                <div class="border rounded mb-3 p-3">
                    <h6 class="ps-2 mb-1">Categorie</h6>
                    <div class="d-flex flex-column" id="area-radio-category">
                        <?php echo get_categories_radio_button(); ?>
                    </div>
                </div>
                <div class="border rounded mb-3 p-3">
                    <h6 class="mb-1">Visibilità</h6>
                    <div class="d-flex flex-column" id="area-radio-view">
                        <?php echo get_visibility_radio_button(); ?>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6 mb-3 p-lg-0" id="content-post">
            </div>
            <div class="col-12 col-lg-3 mb-3">
                <div class="mb-3">
                    <input type="search" class="form-control" placeholder="Cerca..." id="search-box" aria-label="Cerca">
                </div>
                <div class="border rounded mb-3 p-3">
                    <?php get_account_area(); ?>
                </div>
            </div>
        </div>
    </main>
    <script>
        $(document).ready(function () {
            dynamic_field('post', '#search-box', '#area-radio-category input[type="radio"]', 'input[name="category"]', '#area-radio-view input[type="radio"]', 'input[name="view"]');
        });
    </script>

<?php


include_js('includes/js/dynamic-form.js');
include_js('includes/js/load-post.js');

get_footer();
init_foot();


