<?php

use includes\php\AltoRouter;
use JetBrains\PhpStorm\NoReturn;

#[NoReturn] function include_file($file_path, $vars = []): void
{
    extract($vars);
    include($file_path);
    die();
}

require 'includes/php/AltoRouter.php';
require 'config.php';

$router = new AltoRouter();
$router->setBasePath(PATH);

// Route per la visualizzazione
$router->map('GET', '/', function () {
    include_file('pages/home.php');
}); // HomePage
$router->map('GET', '/login', function () {
    include_file('pages/login.php');
}); // Accedi
$router->map('GET', '/register', function () {
    include_file('pages/register.php');
}); // Registrati
$router->map('GET', '/password/lost', function () {
    include_file('pages/password-lost.php');
}); // Recupera password
$router->map('GET', '/password/reset', function () {
    include_file('pages/password-reset.php');
}); // Resetta password
{
    $router->map('GET', '/verify', function () {
        include_file('pages/verify.php');
    }); // Stato dell'account
    $router->map('GET', '/blocked', function () {
        include_file('pages/status.php');
    }); // Stato dell'account
    $router->map('GET', '/to-check', function () {
        include_file('pages/status.php');
    }); // Stato dell'account
}

$router->map('GET', '/profile', function () {
    include_file('pages/profile.php');
}); // Profilo

$router->map('GET', '/profile/post', function () {
    include_file('pages/profile-post.php');
}); // Visualizzare i post del proprio profilo

$router->map('GET', '/access-restricted', function () {
    include_file('pages/access-restricted.php');
}); // Profilo
$router->map('GET', '/post/add', function () {
    include_file('pages/post-add.php');
}); // Aggiunta di un post
$router->map('GET', '/post/edit', function () {
    include_file('pages/post-edit.php');
}); //Modifica di un post
$router->map('GET', '/post/view', function () {
    include_file('pages/post-view.php');
}); //Visualizzazione di un post
$router->map('GET', '/media', function () {
    include_file('api/media.php');
}); //Visualizzazione dei contenuti per view o download
$router->map('GET', '/post/media', function () {
    include_file('pages/post-media.php');
}); //Visualizzazione dei contenuti per view o download
$router->map('GET', '/project', function () {
    include_file('pages/project.php');
}); //Pagina del progetto


// Route per la precessione dei dati
$router->map('POST', '/login', function () {
    include_file('api/login.php');
}); // Accedi
$router->map('POST', '/register', function () {
    include_file('api/register.php');
}); // Registrati
$router->map('POST', '/password/lost', function () {
    include_file('api/password-lost.php');
}); // Recupera password
$router->map('POST', '/password/reset', function () {
    include_file('api/password-reset.php');
}); // Resetta password
{
    $router->map('POST', '/verify', function () {
        include_file('api/verify.php');
    }); // Stato dell'account
}
$router->map('POST', '/logout', function () {
    include_file('api/logout.php');
}); // Logout
$router->map('POST', '/profile', function () {
    include_file('api/profile.php');
}); // Profilo
$router->map('POST', '/profile/post', function () {
    include_file('api/profile-post.php');
}); // Visualizzare i post del proprio profilo
$router->map('POST', '/delete/profile', function () {
    include_file('api/delete-profile.php');
}); // Eliminazione account
$router->map('POST', '/delete/post', function () {
    include_file('api/delete-post.php');
}); // Eliminazione post
$router->map('POST', '/post/add', function () {
    include_file('api/post-add.php');
}); //Aggiunta di un post
$router->map('POST', '/post/edit', function () {
    include_file('api/post-edit.php');
}); //Modifica di un post
$router->map('POST', '/post/like', function () {
    include_file('api/post-like.php');
}); //Like ad un post
$router->map('POST', '/home', function () {
    include_file('api/home.php');
}); //Get di tutti i post per la home
$router->map('POST', '/post/media/upload', function () {
    include_file('api/media-upload.php');
}); //Get di tutti i post per la home
$router->map('POST', '/post/media/delete', function () {
    include_file('api/media-delete.php');
}); //Get di tutti i post per la home
$router->map('POST', '/post/media/list', function () {
    include_file('api/media-list.php');
}); //Lista dei media di un utente per l'editor
$router->map('POST', '/dynamic-check', function () {
    include_file('api/dynamic-check.php');
}); //Lista dei media di un utente per l'editor


// Corrispondi la route alla richiesta
$match = $router->match();

// Esegui la funzione associata alla route
if ($match && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    // La route richiesta non esiste
    //header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    include_file('pages/not-found.php');
}
