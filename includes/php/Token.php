<?php

namespace includes\php;

require_once('includes/php/ErrorCode.php');

use Error;

/**
 * Classe Token
 *
 * La classe Token si occupa di generare e gestire i token utilizzati per le operazioni
 * di verifica email e ripristino password.
 */
class Token
{
    /**
     * Costanti utilizzate per indicare il tipo di token da generare.
     */
    const EMAIL_VERIFICATION_TOKEN = "email-verification";
    const PASSWORD_LOST_TOKEN = "password-lost";

    /**
     * Metodo statico per generare un token.
     *
     * @param string $email L'email dell'utente per cui generare il token.
     * @param string $type Il tipo di token da generare, deve essere una delle costanti
     *                      definite in questa classe.
     * @return ErrorCode Restituisce un oggetto ErrorCode che contiene il codice dell'errore
     *                    (zero se l'operazione è andata a buon fine) e un messaggio di testo
     *                    che descrive l'errore.
     */
    public static function generate(string $email, string $type): ErrorCode
    {
        $db = new Database();
        $last_request_time = $_SESSION['last_request_time'] ?? 0;
        $current_time = time();

        $token = bin2hex(openssl_random_pseudo_bytes(64));
        $user_id = User::getIdByEmail($email);

        if (!$user_id) {
            return new ErrorCode(1, "Utente non trovato");
        }

        if ($current_time - $last_request_time < 60) {
            return new ErrorCode(3, "Attendi prima di richiedere una nuova richiesta");
        }

        $_SESSION['last_request_time'] = $current_time;

        $query = "SELECT * FROM tokens WHERE user_id = ?";
        $result = $db->query($query, [$user_id]);

        if ($result->num_rows == 0) {

            $query = "INSERT INTO tokens (user_id, token, type) VALUES (?, ?, ?)";
            $result = $db->query($query, [$user_id, $token, $type]);
        } else {

            $row = $result->fetch_assoc();
            $existing_token = $row['token'];
            $query = "UPDATE tokens SET token = ?, type = ? WHERE user_id = ?";

            if ($existing_token === $token) {
                $query = "DELETE FROM tokens WHERE user_id = ?";
                $result = $db->query($query, [$user_id]);
            } else {
                $result = $db->query($query, [$token, $type, $user_id]);
            }
        }
        if ($result) {
            self::send($email, $type, $token);
            return new ErrorCode(0, "Operazione eseguita con successo");
        } else {
            return new ErrorCode(2, "Errore durante la generazione del token");
        }
    }

    /**
     * Restituisce l'ID dell'utente associato al token e al tipo specificati.
     *
     * @param string $token Il token da cercare nel database.
     * @param string $type Il tipo di token da cercare nel database.
     * @return int|bool L'ID dell'utente associato al token e al tipo specificati se trovato nel database, altrimenti false.
     */
    public static function getUserId(string $token, string $type): bool|int
    {
        $query = "SELECT user_id FROM tokens WHERE token = ? AND type = ?";
        $result = (new Database())->query($query, [$token, $type]);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return $row['user_id'];
        } else {
            return false;
        }
    }

    /**
     * Funzione che valida un token e restituisce un oggetto ErrorCode.
     *
     * @param string $token Il token da validare.
     * @param string $token_type Il tipo di token da validare.
     * @return ErrorCode L'oggetto ErrorCode che indica il successo o l'errore dell'operazione.
     */
    public static function validate(string $token, string $token_type): ErrorCode
    {

        $db = new Database();
        $query = "SELECT * FROM tokens WHERE token = ? AND type = ? LIMIT 1";
        $result = $db->query($query, [$token, $token_type]);


        if ($result->num_rows == 1) {
            $user_id = self::getUserId($token, $token_type);
            $query = "DELETE FROM tokens WHERE token = ? AND type = ?";
            $db->query($query, [$token, $token_type]);

            if ($token_type === self::EMAIL_VERIFICATION_TOKEN) {
                try {
                    $query = "UPDATE users SET status = " . AccessControl::getStatusIdByName('attivo') . " WHERE id = $user_id";
                    $db->query($query);

                    if (isset($_SESSION['id'])) {
                        $_SESSION['status'] = AccessControl::getStatusIdByName('attivo');
                    }

                } catch (Error) {
                    return new ErrorCode(2, "Errore durante l'analisi del ruolo");
                }

            }

            return new ErrorCode(0, "Operazione eseguita con successo");
        } else {
            return new ErrorCode(1, "Errore durante la validazione del token");
        }
    }

    /**
     * Invia un'email all'indirizzo specificato con il tipo di token e il token generato.
     *
     * @param string $email L'indirizzo email del destinatario
     * @param string $type Il tipo di token da inviare (EMAIL_VERIFICATION_TOKEN o PASSWORD_LOST_TOKEN)
     * @param string $token Il token generato da associare all'email
     * @return void
     */
    private static function send(string $email, string $type, string $token): void
    {
        if (empty($email) || empty($token)) {
            return;
        }

        $to = $email;

        switch ($type) {
            case self::EMAIL_VERIFICATION_TOKEN:
                $subject = 'Token di verifica email';
                $message = 'Gentile utente,<br><br>';
                $message .= sprintf('Clicca <a href="%s/verify?token=%s">qui</a> per verificare l\'email.<br>', get_url_site(), $token);
                $message .= 'Cordiali saluti.';
                break;
            case self::PASSWORD_LOST_TOKEN:
                $subject = 'Token di password dimenticata';
                $message = 'Gentile utente,<br><br>';
                $message .= sprintf('Clicca <a href="%s/password/reset?token=%s">qui</a> per reimpostare la password.<br>', get_url_site(), $token);
                $message .= 'Cordiali saluti.';
                break;
            default:
                return;
        }

        $headers = "From: info@scolario.altervista.org\r\n";
        $headers .= "Reply-To: info@scolario.altervista.org\r\n";
        $headers .= "Content-type: text/html\r\n";

        mail($to, $subject, $message, $headers);
    }

}