<?php

use includes\php\AccessControl;
use includes\php\AjaxResponse;
use includes\php\Token;

AccessControl::requireRoles(["ospite"]);

try {
    $secret = RECAPTCHA_SECRET;
    $response = $_POST["g-recaptcha-response"];
    $remoteip = $_SERVER["REMOTE_ADDR"];

    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteip";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $verify = curl_exec($ch);

    $result = json_decode($verify);

    if (!$result->success) {
        $response = new AjaxResponse(-1, "Captcha non valido", 'alert');
        $response->toJson();
    }

    $email = $_POST['email'];
    if ($email == '') {
        $response = new AjaxResponse(1, "Inserisci i dati", 'alert');
        $response->toJson();
    }
    $result = Token::generate($email, Token::PASSWORD_LOST_TOKEN);
    if ($result->getCode() == 0) {
        $response = new AjaxResponse(0, "Azione eseguita con successo", 'replace', '<p>Operazione effettua con successo. Controlla la tua email</p>');
        $response->toJson();
    }
    $response = new AjaxResponse($result->getCode(), $result->getMessage(), 'alert');
    $response->toJson();

} catch (Error $exception) {
    $response = new AjaxResponse(-1, "Errore durante la fase di richiesta di reset password", 'alert');
    $response->toJson();
}
