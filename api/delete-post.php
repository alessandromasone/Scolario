<?php

use includes\php\AccessControl;
use includes\php\AjaxResponse;
use includes\php\Post;

AccessControl::requireRoles(["studente"]);
AccessControl::requireStatus(["attivo"]);

try {

    $check = Post::checkPermissionOnPost($_SESSION['id'], $_POST['id']);

    if ($check) {


        if (Post::deletePostById($_POST['id'])) {

            $response = new AjaxResponse(0, "Eliminazione avvenuta con successo", 'redirect', PATH . '/profile/post');
            $response->toJson();
        }

    }
    $response = new AjaxResponse(1, "Errore durante l'eliminazione del post", 'alert');
    $response->toJson();

} catch (Error $exception) {
    $response = new AjaxResponse(-1, "Errore durante la fase di eliminazione del post", 'alert');
    $response->toJson();
}
