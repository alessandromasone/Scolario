<?php

use includes\php\AjaxResponse;
use includes\php\User;

$check = User::checkDynamicSession();

switch ($check->getCode()) {
    case 1:
        $action_type = 'redirect';
        $location = PATH . "/";
        $response = new AjaxResponse($check->getCode(), $check->getMessage(), $action_type, $location);
        break;
    default:
        $action_type = '';
        $response = new AjaxResponse($check->getCode(), $check->getMessage(), $action_type);

        break;
}

$response->toJson();

