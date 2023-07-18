<?php

use includes\php\AccessControl;
use includes\php\Database;


AccessControl::requireRoles(["studente"]);
AccessControl::requireStatus(["attivo"]);

if (isset($_POST['src'])) {
    $stringa = $_POST['src'];
    parse_str(parse_url($stringa, PHP_URL_QUERY), $params);
    $hash = $params['hash'];
} elseif (isset($_POST['hash'])) {
    $hash = $_POST['hash'];
} else {
    echo 1;
    die();
}



$sql = "SELECT * FROM media WHERE hash = ? AND user = ?";

$result = (new Database())->query($sql, [$hash, $_SESSION['id']]);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $file_path = 'media-folder/'.$row['user'].'/' . $name;
    if (unlink($file_path)) {
        // Elimina la riga dal database
        $sql = "DELETE FROM media WHERE hash=?";
        (new Database())->query($sql, [$hash]);
        echo 0;
        die();
    }
}
echo 1;
die();