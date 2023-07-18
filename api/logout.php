<?php

use includes\php\AccessControl;
use includes\php\AjaxResponse;
use includes\php\User;




AccessControl::requireRoles(["studente"]);
AccessControl::requireStatus(["attivo", "da verificare", "bloccato", "da validare"]);

try {
    $result = User::logout();
    if ($result->getCode() == 0) {
        $response = new AjaxResponse($result->getCode(), $result->getMessage(), 'redirect', PATH . '/login');
        $response->toJson();
    }
    $response = new AjaxResponse($result->getCode(), $result->getMessage(), 'alert');
    $response->toJson();

} catch (Error $exception) {
    $response = new AjaxResponse(-1, "Errore durante la fase di logout", 'alert');
    $response->toJson();
}
