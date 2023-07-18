<?php

use includes\php\AccessControl;
use includes\php\AjaxResponse;
use includes\php\User;

AccessControl::requireRoles(["ospite"]);
AccessControl::requireStatus(["non trovato"]);

try {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if ($email == '' || $password == '') {
        $response = new AjaxResponse(1, "Inserisci i dati", 'alert');
        $response->toJson();
    }
    $result = User::login($email, $password);
    if ($result->getCode() == 0) {
        $response = new AjaxResponse(0, "Accesso eseguito con successo", 'redirect', PATH . '/');
        $response->toJson();
    }
    $response = new AjaxResponse(2, "Credenziali non valide", 'alert');
    $response->toJson();

} catch (Error $exception) {
    $response = new AjaxResponse(-1, "Errore durante la fase di accesso", 'alert');
    $response->toJson();
}
