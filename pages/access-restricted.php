<?php

$page_name = "Accesso riservato";

init_head($page_name);

get_header($page_name, true);
?>

    <main class="text-center">
        <p>Non hai accesso a questa pagina. Torna alla <a href="<?php echo get_url_site(); ?>">home</a></p>
    </main>

<?php

get_footer();
init_foot();