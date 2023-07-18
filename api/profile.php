<?php

use includes\php\AccessControl;
use includes\php\AjaxResponse;
use includes\php\User;

AccessControl::requireRoles(["studente"]);
AccessControl::requireStatus(["attivo"]);

try {

    if ($_SESSION['name'] != $_POST['name']) {

        if (User::changeNameOnId($_POST['name'], $_SESSION['id'])) {
            $_SESSION['name'] = $_POST['name'];
        } else {
            $response = new AjaxResponse(1, "Errore durante l'aggiornamento dei dati, ricarica la pagina", 'alert');
            $response->toJson();
        }
    }

    if ($_SESSION['surname'] != $_POST['surname']) {
        if (User::changeSurnameOnId($_POST['surname'], $_SESSION['id'])) {
            $_SESSION['surname'] = $_POST['surname'];
        } else {
            $response = new AjaxResponse(1, "Errore durante l'aggiornamento dei dati, ricarica la pagina", 'alert');
            $response->toJson();
        }
    }

    if ($_POST['password'] != '' && $_POST['password-new'] != '') {
        if (!User::changePasswordOnId($_POST['password'], $_POST['password-new'], $_SESSION['id'])) {
            $response = new AjaxResponse(1, "Errore durante l'aggiornamento della password, controlla i dati", 'alert');
            $response->toJson();
        }
    }

    $response = new AjaxResponse(0, "Dati aggiornati con successo", 'alert');
    $response->toJson();

} catch (Error $exception) {
    $response = new AjaxResponse(-1, "Errore durante l'aggiornamento dei dati", 'alert');
    $response->toJson();
}