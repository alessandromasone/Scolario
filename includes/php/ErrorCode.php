<?php

namespace includes\php;

/**
 * Classe che rappresenta un codice di errore personalizzato.
 */
class ErrorCode
{
    private int $code; // codice numerico dell'errore
    private string $message; // messaggio descrittivo dell'errore

    /**
     * Costruttore della classe ErrorCode.
     * @param int $code Codice numerico dell'errore
     * @param string $message Messaggio descrittivo dell'errore
     */
    public function __construct(int $code, string $message)
    {
        $this->code = $code;
        $this->message = $message;
    }

    /**
     * Metodo che restituisce il codice numerico dell'errore.
     * @return int Codice numerico dell'errore
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * Metodo che restituisce il messaggio descrittivo dell'errore.
     * @return string Messaggio descrittivo dell'errore
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
