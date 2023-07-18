<?php

use includes\php\AccessControl;
use includes\php\AjaxResponse;
use includes\php\Token;

AccessControl::requireRoles(["studente"]);
AccessControl::requireStatus(["da verificare"]);

try {
    $email = $_SESSION['email'];
    $result = Token::generate($email, Token::EMAIL_VERIFICATION_TOKEN);

    if ($result->getCode() == 0) {
        $response = new AjaxResponse(0, "Azione eseguita con successo", 'alert', '<p>Operazione effettua con successo. Controlla la tua email</p>');
        $response->toJson();
    }
    $response = new AjaxResponse($result->getCode(), $result->getMessage(), 'alert');
    $response->toJson();

} catch (Error $exception) {
    $response = new AjaxResponse(1, "Errore durante la fase di verifica dell'account", 'alert');
    $response->toJson();
}
