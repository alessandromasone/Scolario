<?php

$page_name = "Pagina non trovata";

init_head($page_name);

get_header($page_name, true);

?>

    <main class="text-center">
        <p>Pagina non trovata. Torna alla <a href="<?php echo PATH; ?>">home</a></p>
    </main>

<?php

get_footer();
init_foot();