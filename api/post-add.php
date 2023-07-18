<?php

use includes\php\AccessControl;
use includes\php\AjaxResponse;
use includes\php\Post;

AccessControl::requireRoles(["studente"]);
AccessControl::requireStatus(["attivo"]);

try {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_SESSION['id'];
    $visibility = $_POST['visibility'];
    $category = $_POST['category'];

    if ($title == '' || $content == '' || $author == '' || $visibility == '' || $category == '') {
        $response = new AjaxResponse(1, "Inserisci i dati", 'alert');
        $response->toJson();
    }

    $result = Post::add($title, $content, $author, Post::getVisibilityIdFromName($visibility), Post::getCategoryIdByName($category));

    if ($result->getCode() == 0) {
        $response = new AjaxResponse($result->getCode(), $result->getMessage(), 'replace', '<p>Operazione effettua con successo. Vai alla <a href="' . PATH . '/">home</a></p>');
        $response->toJson();
    }
    $response = new AjaxResponse($result->getCode(), $result->getMessage(), 'alert');
    $response->toJson();

} catch (Error $exception) {
    $response = new AjaxResponse(1, "Errore durante la registrazione del post", 'alert');
    $response->toJson();
}


