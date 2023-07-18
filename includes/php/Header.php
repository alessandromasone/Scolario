<?php

namespace includes\php;

/**
 * La classe Header è responsabile del rendering della sezione header del sito web.
 */
class Header
{

    // Definizione delle voci di menu nella costante MENU_ITEMS
    const MENU_ITEMS = array(
        PATH . '/' => 'Home',
        PATH . '/project' => 'Progetto'
    );

    // Definizione del percorso del logo nella costante LOGO
    public const LOGO = PATH . "/media-folder/site/logo.svg";

    // Nome della pagina
    private string $page_name;

    /**
     * Costruttore della classe Header.
     *
     * @param string $page_name Nome della pagina (default = "")
     */
    public function __construct(string $page_name = "")
    {
        $this->page_name = $page_name;
    }

    /**
     * Costruisce la lista delle voci di menu.
     *
     * @return string La lista delle voci di menu.
     */
    private function buildListMenu(): string
    {
        $list_menu = "";

        foreach (self::MENU_ITEMS as $link => $label) {
            $active_class = ($this->page_name ?? '') == $label ? '' : 'link-dark';
            $active_page = ($this->page_name ?? '') == $label ? 'aria-current="page"' : '';
            $list_menu .= '<li class="nav-item"><a href="' . $link . '" class="nav-link  px-3 ps-0 ' . $active_class . '" ' . $active_page . '>' . $label . '</a></li>';
        }
        return $list_menu;
    }

    /**
     * Renderizza l'header con logo e menu.
     *
     * @return void
     */
    public function render(): void
    {

        ?>

        <header class="py-3 pb-0">
            <div class="container d-flex flex-wrap justify-content-center">
                <a href="<?php echo get_url_site(); ?>"
                   class="d-flex align-items-center mb-lg-0 justify-content-center link-body-emphasis text-decoration-none ps-lg-2">
                    <img src="<?php echo self::LOGO; ?>" width="28" height="28" class="zoom-in" alt="Logo">
                    <span class="fs-4 ms-1">Scolario</span>
                </a>
            </div>
        </header>
        <nav class="border-bottom mb-3">
            <div class="container d-flex flex-wrap">
                <ul class="nav me-auto">
                    <?php echo $this->buildListMenu(); ?>
                </ul>

                <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>

                    <div class="nav-item dropdown d-flex align-items-center">
                        <a class="nav-link pe-1" href="<?php echo PATH; ?>/profile" aria-expanded="false">
                            Profilo
                        </a>
                        <a class="nav-link dropdown-toggle pe-2" role="button" data-bs-toggle="dropdown"
                           aria-expanded="false">
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?php echo PATH; ?>/profile/post">Contenuti</a></li>
                            <li><a class="dropdown-item" href="<?php echo PATH; ?>/post/media">Media</a></li>
                            <li><a class="dropdown-item" href="<?php echo PATH; ?>/post/add">Nuovo contenuto</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)"
                                   onclick="logout_account()">Logout</a></li>
                        </ul>
                    </div>

                <?php else: ?>

                    <div class="nav-item dropdown d-flex align-items-center">
                        <a class="nav-link pe-1" href="<?php echo PATH; ?>/login" aria-expanded="false">
                            Accedi
                        </a>
                        <a class="nav-link dropdown-toggle pe-2" role="button" data-bs-toggle="dropdown"
                           aria-expanded="false">
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?php echo PATH; ?>/login">Accedi</a></li>
                            <li><a class="dropdown-item" href="<?php echo PATH; ?>/password/lost">Password
                                    dimenticata</a></li>
                            <li><a class="dropdown-item" href="<?php echo PATH; ?>/register">Registrati</a></li>
                        </ul>
                    </div>

                <?php endif; ?>

            </div>
        </nav>

        <?php

    }

    /**
     * Questo metodo rende solo il logo e il nome del sito Web, senza alcun menu di navigazione o informazioni di accesso dell'utente.
     *
     * @return void
     */
    public function renderOnlyLogo(): void
    {

        ?>

        <header class="py-3 pb-0 mb-3">
            <div class="container d-flex flex-wrap justify-content-center">
                <a href="<?php echo get_url_site(); ?>"
                   class="d-flex align-items-center  mb-lg-0 justify-content-center link-body-emphasis text-decoration-none ps-lg-2">
                    <img src="<?php echo self::LOGO; ?>" width="28" height="28" class="zoom-in" alt="Logo">
                    <span class="fs-4 ms-1">Scolario</span>
                </a>
            </div>
        </header>

        <?php
    }


}