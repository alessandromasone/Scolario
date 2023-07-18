<?php

use includes\php\AccessControl;
use includes\php\AjaxResponse;
use includes\php\User;
use includes\php\Token;

AccessControl::requireRoles(["ospite"]);

try {
    $token = $_POST['token'];
    $password = $_POST['password'];
    $password_check = $_POST['confirm_password'];

    $id_user = Token::getUserId($token, Token::PASSWORD_LOST_TOKEN);

    if (!$id_user) {
        $response = new AjaxResponse(1, "Errore durante l'analisi del token,  effettua una nuova richiesta", 'alert');
        $response->toJson();
    }

    if ($password == '' || $password_check == '') {
        $response = new AjaxResponse(1, "Inserisci i dati", 'alert');
        $response->toJson();
    }

    if ($password == !$password_check) {
        $response = new AjaxResponse(1, "Le password non corrispondono", 'alert');
        $response->toJson();
    }

    $result = Token::validate($token, Token::PASSWORD_LOST_TOKEN);
    if ($result->getCode() != 0) {
        $response = new AjaxResponse(1, "Errore durante l'analisi del token, effettua una nuova richiesta", 'alert');
        $response->toJson();
    }

    if (User::resetPasswordOnId($id_user, $password)) {
        $response = new AjaxResponse(0, "Azione eseguita con successo", 'replace', '<p>Operazione effettua con successo. Vai al <a href="' . PATH . '/login">login</a></p>');
        $response->toJson();
    }
    $response = new AjaxResponse(1, "Errore durante l'inserimento della nuova password", 'alert');
    $response->toJson();

} catch (Error $exception) {
    $response = new AjaxResponse(-1, "Errore durante la fase di reset della password", 'alert');
    $response->toJson();
}

