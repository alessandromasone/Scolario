<?php

use includes\php\AccessControl;
use includes\php\Database;
use includes\php\Footer;
use includes\php\Header;
use includes\php\School;

require_once "includes/php/AccessControl.php";
require_once "includes/php/AjaxResponse.php";
require_once "includes/php/User.php";
require_once "includes/php/School.php";
require_once "includes/php/Header.php";
require_once "includes/php/Token.php";
require_once "includes/php/Post.php";
require_once "includes/php/Footer.php";


/**
 * Inizializza la sezione head HTML per una pagina Web, impostando il titolo della pagina e includendo tutti i file CSS e JS necessari.
 *
 * @param string $page_name Il titolo della pagina web.
 * @param string $other Un parametro stringa facoltativo utilizzato per specificare risorse aggiuntive da includere nella sezione head. Se il valore è "froala", verranno incluse le risorse dell'editor Froala WYSIWYG.
 * @return void
 */
function init_head(string $page_name, string $other = ""): void
{
    ?>

    <!DOCTYPE html>
    <html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $page_name; ?></title>

        <?php if ($other == "froala") {

            $resources_froala = [
                'css' => [
                    'includes/css/froala/froala_editor.css',
                    'includes/css/froala/froala_editor.css',
                    'includes/css/froala/plugins/code_view.css',
                    'includes/css/froala/plugins/draggable.css',
                    'includes/css/froala/plugins/colors.css',
                    'includes/css/froala/plugins/emoticons.css',
                    'includes/css/froala/plugins/image_manager.css',
                    'includes/css/froala/plugins/image.css',
                    'includes/css/froala/plugins/line_breaker.css',
                    'includes/css/froala/plugins/table.css',
                    'includes/css/froala/plugins/char_counter.css',
                    'includes/css/froala/plugins/video.css',
                    'includes/css/froala/plugins/fullscreen.css',
                    'includes/css/froala/plugins/file.css',
                    'includes/css/froala/plugins/quick_insert.css',
                    'includes/css/froala/plugins/help.css',
                    'includes/css/froala/third_party/spell_checker.css',
                    'includes/css/froala/plugins/special_characters.css'
                ],
                'js' => [
                    'includes/js/froala/froala_editor.min.js',
                    'includes/js/froala/plugins/align.min.js',
                    'includes/js/froala/plugins/char_counter.min.js',
                    'includes/js/froala/plugins/code_beautifier.min.js',
                    'includes/js/froala/plugins/code_view.min.js',
                    'includes/js/froala/plugins/colors.min.js',
                    'includes/js/froala/plugins/draggable.min.js',
                    'includes/js/froala/plugins/emoticons.min.js',
                    'includes/js/froala/plugins/entities.min.js',
                    'includes/js/froala/plugins/file.min.js',
                    'includes/js/froala/plugins/font_size.min.js',
                    'includes/js/froala/plugins/font_family.min.js',
                    'includes/js/froala/plugins/fullscreen.min.js',
                    'includes/js/froala/plugins/image.min.js',
                    'includes/js/froala/plugins/image_manager.min.js',
                    'includes/js/froala/plugins/line_breaker.min.js',
                    'includes/js/froala/plugins/inline_style.min.js',
                    'includes/js/froala/plugins/link.min.js',
                    'includes/js/froala/plugins/lists.min.js',
                    'includes/js/froala/plugins/paragraph_format.min.js',
                    'includes/js/froala/plugins/paragraph_style.min.js',
                    'includes/js/froala/plugins/quick_insert.min.js',
                    'includes/js/froala/plugins/quote.min.js',
                    'includes/js/froala/plugins/table.min.js',
                    'includes/js/froala/plugins/save.min.js',
                    'includes/js/froala/plugins/url.min.js',
                    'includes/js/froala/plugins/video.min.js',
                    'includes/js/froala/plugins/help.min.js',
                    'includes/js/froala/plugins/print.min.js',
                    'includes/js/froala/third_party/spell_checker.min.js',
                    'includes/js/froala/plugins/special_characters.min.js',
                    'includes/js/froala/plugins/word_paste.min.js'
                ],
                'external_css' => [
                    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css',
                    'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css'
                ],
                'external_js' => [
                    'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js',
                    'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js',
                    'https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.2.7/purify.min.js'
                ]
            ];

            foreach ($resources_froala as $type => $files) {
                foreach ($files as $file) {
                    switch ($type) {
                        case 'css':
                            include_css($file);
                            break;
                        case 'js':
                            include_js($file);
                            break;
                        case 'external_css':
                            echo '<link rel="stylesheet" href="' . $file . '">';
                            break;
                        case 'external_js':
                            echo '<script type="text/javascript" src="' . $file . '"></script>';
                            break;

                    }
                }
            }
        } ?>

        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ"
              crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
                crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <link rel="shortcut icon" href="<?php echo Header::LOGO; ?>" type="image/x-icon">
        <script type="text/javascript"> <?php echo "const PATH = " . json_encode(PATH) . ";"; ?></script>

        <?php

        include_js("includes/js/functions.js");
        include_css("includes/css/style.css");
        include_js("includes/js/dynamic-check.js");

        ?>

    </head>
    <body data-bs-theme="light">

    <?php
}

/**
 * Funzione che stampa il tag di chiusura del body e della pagina HTML.
 */
function init_foot(): void
{
    ?>

    </body>
    </html>

    <?php
}

/**
 * Funzione che stampa il tag di apertura di uno script JavaScript.
 *
 * @param string $file_name Il nome del file JavaScript da includere.
 */
function include_js(string $file_name): void
{
    echo '<script type="text/javascript" src="' . PATH . '/' . $file_name . '"></script>';
}

/**
 * Funzione che stampa il tag di apertura di un foglio di stile CSS.
 *
 * @param string $file_name Il nome del file CSS da includere.
 */
function include_css(string $file_name): void
{
    echo '<link rel="stylesheet" href="' . PATH . '/' . $file_name . '">';
}

/**
 * Funzione che restituisce l'URL del sito.
 *
 * @return string L'URL del sito.
 */
function get_url_site(): string
{
    return (empty($_SERVER["HTTPS"]) ? "http" : "https") . "://$_SERVER[HTTP_HOST]" . PATH;
}

/**
 * Funzione che stampa l'header del sito.
 *
 * @param string $page_name Il nome della pagina corrente.
 * @param bool $only_logo Se true, stampa solo il logo dell'headr.
 */
function get_header(string $page_name, bool $only_logo = false): void
{
    $header = new includes\php\Header($page_name);
    if ($only_logo) {
        $header->renderOnlyLogo();
    } else {
        $header->render();
    }
}

/**
 * Funzione che stampa il footer del sito.
 */
function get_footer(): void
{
    $footer = new Footer();
    $footer->render();
}

/**
 * Funzione che restituisce una stringa con i tag HTML per la lista di categorie come radio button.
 *
 * @return string La lista di categorie come radio button.
 */
function get_categories_radio_button(): string
{
    $list_categories_html = "";
    foreach (includes\php\Post::getCategories() as $category) {
        $list_categories_html .=
            ' <div class="form-check form-check-inline">
                    <input value="' . $category["name"] . '" class="form-check-input" type="radio" name="category" id="Radio-' . $category["name"] . '">
                    <label class="form-check-label" for="Radio-' . $category["name"] . '">
                        ' . ucfirst($category["name"]) . '
                    </label>
                </div>
            ';
    }
    return $list_categories_html;
}

/**
 * Funzione che stampa l'area personale dell'utente (login, logout, accesso ai propri contenuti, etc.).
 */
function get_account_area(): void
{

    if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]): ?>

        <h6 class="mb-1">Bentrovato <?php echo $_SESSION["name"]; ?></h6>
        <a class="text-decoration-none" href="<?php echo PATH; ?>/profile">Profilo</a><br>
        <a class="text-decoration-none" href="<?php echo PATH; ?>/profile/post">Contenuti</a><br>
        <a class="text-decoration-none" href="<?php echo PATH; ?>/post/add">Nuovo contenuto</a><br>
        <a class="text-decoration-none" href="javascript:void(0)" onclick="logout_account()">Logout</a>

    <?php else: ?>

        <form method="POST" action="<?php echo PATH; ?>/login" class="text-center to-ajax">
            <h6 class="mb-1 ms-1 text-start">Accedi</h6>
            <div class="form-floating mb-3">
                <input type="email" class="form-control" name="email" id="floatingInput">
                <label for="floatingInput">Indirizzo Email</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" name="password" class="form-control" id="floatingPassword">
                <label for="floatingPassword">Password</label>
            </div>

            <button class="w-100 btn blue-fb mb-3" type="submit">Accedi</button>
            <a href="<?php echo PATH; ?>/password/lost" class="text-primary mb-3 text-decoration-none"><p>Password
                    dimenticata?</p></a>

            <a href="<?php echo PATH; ?>/register" class="ps-3 pe-3 btn green-fb">Crea nuovo account</a>
        </form>

    <?php endif;

}

/**
 * Restituisce una stringa contenente l'HTML per una lista di opzioni di visibilità del post,
 * con l'opzione selezionata se specificata.
 *
 * @param string $selected Visibilità selezionata (opzionale).
 *
 * @return string HTML per la lista di opzioni di visibilità del post.
 */
function get_visibility_list_for_post(string $selected = ""): string
{
    $list_visibility_html = "";
    foreach (includes\php\Post::getVisibilityNames() as $visibilityName) {
        if ($selected == $visibilityName) {
            $list_visibility_html .=
                '<option value="' . $visibilityName . '" selected>' . ucfirst($visibilityName) . "</option>";
        } else {
            $list_visibility_html .= '<option value="' . $visibilityName . '">' . ucfirst($visibilityName) . "</option>";
        }
    }
    return $list_visibility_html;
}

/**
 * Restituisce una stringa contenente l'HTML per una lista di opzioni di categoria del post,
 * con l'opzione selezionata se specificata.
 *
 * @param string $selected Categoria selezionata (opzionale).
 *
 * @return string HTML per la lista di opzioni di categoria del post.
 */
function get_category_list_for_post(string $selected = ""): string
{
    $list_category_html = "<option></option>";
    foreach (includes\php\Post::getCategoriesNames() as $categoryName) {
        if ($selected == $categoryName) {
            $list_category_html .= '<option value="' . $categoryName . '" selected>' . ucfirst($categoryName) . "</option>";
        } else {
            $list_category_html .= '<option value="' . $categoryName . '">' . ucfirst($categoryName) . "</option>";
        }
    }
    return $list_category_html;
}

/**
 *
 * Funzione che recupera tutti i media caricati dall'utente corrente
 * e li presenta in una lista con la possibilità di eliminarli
 *
 * @return string L'HTML che rappresenta la lista di tutti i media dell'utente corrente
 */
function get_all_media(): string
{

    $html = '';

    $sql = "SELECT * FROM media WHERE user = ?";
    $result = (new Database())->query($sql, [$_SESSION['id']]);

    if ($result) {
        if ($result->num_rows > 0) {
            $media = $result->fetch_all(MYSQLI_ASSOC);
            foreach ($media as $row) {

                $html .= '<p id="media-' . $row['id'] . '" class="p-2"><a href="' . PATH . '/media?hash=' . $row['hash'] . '" target="_blank" class="text-decoration-none">' . $row['slang'] . '</a><i onclick="delete_media(' . $row['id'] . ', \'' . $row['hash'] . '\')" class="bi bi-trash red-color-fb"></i></p>';

            }
        } else {
            $html .= "Non ci sono media disponibili";
        }

    }

    return $html;

}

/**
 * Crea una lista HTML di ruoli per la pagina di registrazione
 *
 * @return string Lista HTML di ruoli
 */
function role_list_register(): string
{
    $list_role_html = "";
    $hiddenRoles = ['ospite', 'amministratore'];
    foreach (AccessControl::getRoleNames($hiddenRoles) as $roleName) {
        $list_role_html .= '<option value="' . $roleName . '">' . ucfirst($roleName) . '</option>';
    }
    return $list_role_html;
}

/**
 * Crea una lista HTML di scuole per la pagina di registrazione
 *
 * @return string Lista HTML di scuole
 */
function school_list_register(): string
{
    $list_school_html = "<option></option>";
    foreach (School::getNames() as $schoolName) {
        $list_school_html .= '<option value="' . $schoolName['tax_code'] . '">' . ucfirst($schoolName['name']) . '</option>';
    }
    return $list_school_html;
}

function get_visibility_radio_button(): string
{
    $list_view_html = "";
    foreach (includes\php\Post::getVisibilityNames() as $view_type) {

        $list_view_html .=
            ' <div class="form-check form-check-inline">
                    <input value="' . $view_type . '" class="form-check-input" type="radio" name="view" id="Radio-' . $view_type . '">
                    <label class="form-check-label" for="Radio-' . $view_type . '">
                        ' . ucfirst($view_type) . '
                    </label>
                </div>
            ';


    }
    return $list_view_html;
}