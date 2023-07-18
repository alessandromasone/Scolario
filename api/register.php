<?php

use includes\php\AccessControl;
use includes\php\AjaxResponse;
use includes\php\User;
use includes\php\School;

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

    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $school = $_POST['school'];

    if ($name == '' || $surname == '' || $email == '' || $password == '' || $role == '' || $school == '') {
        $response = new AjaxResponse(1, "Inserisci i dati", 'alert');
        $response->toJson();
    }

    try {
        $result = User::register($name, $surname, $email, $password, $role, AccessControl::getStatusIdByName('da verificare'), School::getIdByTaxCode($school));
    } catch (Error $exception) {
        $response = new AjaxResponse(1, "Errore ruolo o scuola non validi", 'alert');
        $response->toJson();
    }

    if ($result->getCode() == 0) {
        $response = new AjaxResponse($result->getCode(), $result->getMessage(), 'replace', '<p>Operazione effettua con successo. Vai al <a href="' . PATH . '/login">login</a></p>');
        $response->toJson();
    }
    $response = new AjaxResponse($result->getCode(), $result->getMessage(), 'alert');
    $response->toJson();

} catch (Error $exception) {
    $response = new AjaxResponse(1, "Errore durante la fase di registrazione", 'alert');
    $response->toJson();
}