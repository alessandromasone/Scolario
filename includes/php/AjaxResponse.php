<?php

namespace includes\php;

use JetBrains\PhpStorm\NoReturn;

/**
 * La classe AjaxResponse rappresenta una risposta AJAX standard.
 */
class AjaxResponse
{
    private int $statusCode; // Il codice di stato HTTP della risposta.
    private string $message; // Il messaggio di risposta.
    private string $actionType; // Il tipo di azione che deve essere eseguita dalla parte client.
    private string $action; // L'azione che deve essere eseguita dalla parte client (se necessaria).

    /**
     * Costruisce un nuovo oggetto AjaxResponse con i parametri passati.
     *
     * @param int $statusCode Il codice di stato HTTP della risposta.
     * @param string $message Il messaggio di risposta.
     * @param string $actionType Il tipo di azione che deve essere eseguita dalla parte client.
     * @param string $action L'azione che deve essere eseguita dalla parte client (se necessaria).
     */
    public function __construct(int $statusCode, string $message, string $actionType, string $action = "")
    {
        $this->statusCode = $statusCode;
        $this->message = $message;
        $this->actionType = $actionType;
        $this->action = $action;
    }

    /**
     * Converte la risposta in formato JSON e la invia al client, terminando l'esecuzione dello script.
     *
     * @return void
     */
    #[NoReturn] public function toJson(): void
    {
        $data = [
            'statusCode' => $this->statusCode,
            'message' => $this->message,
            'actionType' => $this->actionType,
            'action' => $this->action,
        ];

        echo json_encode($data);
        die();
    }
}
