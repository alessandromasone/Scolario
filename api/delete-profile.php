<?php

use includes\php\AccessControl;
use includes\php\AjaxResponse;
use includes\php\User;

AccessControl::requireRoles(["studente"]);
AccessControl::requireStatus(["attivo", "da verificare", "bloccato", "da validare"]);

try {
    $result = User::deleteAccountOnSession();
    if ($result) {
        User::logout();
        $response = new AjaxResponse(0, "Eliminazione del profilo eseguita con successo", 'redirect', PATH . '/login');
        $response->toJson();
    }
    $response = new AjaxResponse(-1, "Errore durante l'eliminazione dell'account", 'alert');
    $response->toJson();

} catch (Error $exception) {
    $response = new AjaxResponse(-1, "Errore durante la fase di eliminazione dell'account", 'alert');
    $response->toJson();
}
