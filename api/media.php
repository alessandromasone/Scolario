<?php

use includes\php\AccessControl;
use includes\php\Database;

AccessControl::requireRoles(["ospite", "studente"]);
AccessControl::requireStatus(["non trovato", "attivo"]);

if (isset($_GET['hash'])) {
    $query = "SELECT * FROM media WHERE hash = ?";
    $result = (new Database())->query($query, [$_GET['hash']]);
    if ($result && $result->num_rows == 1) {
        $media = $result->fetch_assoc();
        $file_path = 'media-folder/'.$media['user'].'/' . $media['name'];
        $mime_type = mime_content_type($file_path);
        header('Content-type: ' . $mime_type);
        header('Content-disposition: inline; filename="' . $media['name'] . '"');
        header('Content-length: ' . filesize($file_path));
        readfile($file_path);
    }
}
die();