<?php

use includes\php\AccessControl;
use includes\php\Post;
use includes\php\User;


AccessControl::requireRoles(["studente"]);
AccessControl::requireStatus(["attivo"]);


$post = Post::getForView($_POST['id']);

if ($post) {
    echo User::updateLike($_POST['id']);
}
die();