<?php

namespace includes\php;

require_once('includes/php/Database.php');
require_once('includes/php/ErrorCode.php');

use Error;

class User
{

    /**
     * Restituisce il ruolo dell'utente attualmente loggato in sessione.
     * Se il ruolo non è presente in sessione, viene restituito il primo ruolo dell'array di ruoli di default.
     *
     * @return int L'ID del ruolo dell'utente in sessione o il primo ruolo di default se non presente in sessione.
     */
    public static function getRoleOnSession(): int
    {
        return $_SESSION['role'] ?? AccessControl::ROLES[0]['id'];
    }

    /**
     * Restituisce lo stato dell'account dell'utente attualmente loggato in sessione.
     * Se lo stato non è presente in sessione, viene restituito il primo stato dell'array di stati di default.
     *
     * @return int L'ID dello stato dell'account dell'utente in sessione o il primo stato di default se non presente in sessione.
     */
    public static function getStatusOnSession(): int
    {
        return $_SESSION['status'] ?? AccessControl::ACCOUNT_STATUSES[0]['id'];
    }

    /**
     *
     * Effettua il login dell'utente con l'email e la password specificate
     *
     * @param string $email L'email dell'utente
     * @param string $password La password dell'utente
     * @return ErrorCode Un oggetto ErrorCode che rappresenta l'esito dell'operazione
     */
    public static function login(string $email, string $password): ErrorCode
    {
        try {
            /**
             * Carica i dati dell'utente nella sessione corrente
             * @param array $user L'array associativo che contiene i dati dell'utente
             * @return void
             */
            function loadData(array $user): void
            {
                $_SESSION['id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['surname'] = $user['surname'];
                $_SESSION['school'] = $user['school'];
                $_SESSION['status'] = $user['status'];
                $_SESSION['logged_in'] = true;
            }

            $query = "SELECT * FROM users WHERE email = ?";
            $result = (new Database())->query($query, [$email]);
            if ($result->num_rows == 1) {
                $user = $result->fetch_assoc();
                if (password_verify($password, $user['password'])) {
                    session_regenerate_id();
                    loadData($user);

                    $query = "DELETE FROM sessions WHERE  user_id = ?";
                    (new Database())->query($query, [$_SESSION['id']]);

                    $session_id = session_id();
                    $query = "INSERT INTO sessions (session_id, user_id) VALUES (?, ?)";
                    (new Database())->query($query, [$session_id, $_SESSION['id']]);

                    $cookie_duration = 60 * 60 * 24 * 30; // 30 giorno
                    setcookie('session_id', $session_id, time() + $cookie_duration, "/");

                    return new ErrorCode(0, "Operazione eseguita con successo");
                } else {
                    return new ErrorCode(2, "Password non valida");
                }
            } else {
                return new ErrorCode(1, "Email non registrata");
            }
        } catch (Error) {
            return new ErrorCode(3, "Errore durante l'operazione di accesso");
        }

    }

    /**
     * Registra un nuovo utente nel database.
     *
     * @param string $name Il nome dell'utente.
     * @param string $surname Il cognome dell'utente.
     * @param string $email L'email dell'utente.
     * @param string $password La password dell'utente.
     * @param string $role Il ruolo dell'utente.
     * @param string $status Lo stato dell'account dell'utente.
     * @param string $school La scuola dell'utente.
     * @return ErrorCode Un oggetto ErrorCode che rappresenta l'esito dell'operazione.
     * Il codice di errore ZERO indica che l'operazione è stata eseguita con successo.
     * Il codice di errore UNO indica che l'utente è già presente nel database.
     * Il codice di errore DUE indica che c'è stato un errore nell'analisi del ruolo dell'utente.
     * Il codice di errore TRE indica che c'è stato un errore durante il salvataggio dei dati dell'utente nel database.
     * Il codice di errore QUATTRO indica che c'è stato un errore durante l'operazione di registrazione.
     */
    public static function register(string $name, string $surname, string $email, string $password, string $role, string $status, string $school): ErrorCode
    {
        try {
            $sql = "SELECT * FROM users WHERE email = ?";
            $params = [$email];
            $result = (new Database())->query($sql, $params);
            if ($result->num_rows > 0) {
                return new ErrorCode(1, "Utente già presente, accedi");
            }
            try {
                $role_id = AccessControl::getRoleIdByName($role);
            } catch (Error) {
                return new ErrorCode(2, "Errore nell'analisi del ruolo");
            }
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (name, surname, email, password, role, status, school) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $params = [$name, $surname, $email, $password_hash, $role_id, $status, $school];
            $result = (new Database())->query($sql, $params);
            if ($result) {
                Token::generate($email, Token::EMAIL_VERIFICATION_TOKEN);
                return new ErrorCode(0, "Operazione eseguita con successo");
            }
            return new ErrorCode(3, "Errore salvataggio nel Database");
        } catch (Error) {
            return new ErrorCode(4, "Errore durante l'operazione di registrazione");
        }
    }

    /**
     * Effettua il logout dell'utente, cancellando la sessione corrente ed eliminando il cookie di sessione.
     *
     * @return ErrorCode Un oggetto ErrorCode contenente il codice e il messaggio di errore, in caso di problemi, oppure una notifica di successo in caso di logout avvenuto correttamente.
     */
    public static function logout(): ErrorCode
    {
        try {
            setcookie('session_id', '', time() - 3600, '/');
            $query = "DELETE FROM sessions WHERE user_id = ?";
            (new Database())->query($query, [$_SESSION['id']]);
            unset($_SESSION);
            session_destroy();
            return new ErrorCode(0, "Logout eseguito con successo");
        } catch (Error) {
            return new ErrorCode(4, "Errore durante l'operazione di logout");
        }
    }

    /**
     * Restituisce l'ID dell'utente corrispondente all'indirizzo email fornito.
     *
     * @param string $email L'indirizzo email dell'utente di cui si vuole conoscere l'ID.
     * @return mixed L'ID dell'utente, se presente nel database, oppure false in caso contrario.
     */
    public static function getIdByEmail(string $email): mixed
    {
        $query = "SELECT id FROM users WHERE email = ?";
        $result = (new Database())->query($query, [$email]);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return $row['id'];
        } else {
            return false;
        }
    }

    /**
     * Reimposta la password dell'utente corrispondente all'ID fornito.
     *
     * @param int $user_id L'ID dell'utente di cui si vuole reimpostare la password.
     * @param string $password La nuova password da impostare.
     * @return bool True se l'operazione è avvenuta con successo, false altrimenti.
     */
    public static function resetPasswordOnId(int $user_id, string $password): bool
    {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE users SET password = ? WHERE id = ?";
        $result = (new Database())->query($query, [$password_hash, $user_id]);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Metodo statico che aggiorna il nome dell'utente corrispondente all'id fornito nel database.
     *
     * @param string $newName Il nuovo nome dell'utente.
     * @param int $userId L'id dell'utente da aggiornare.
     * @return bool Restituisce true se l'aggiornamento è avvenuto con successo, altrimenti false.
     */
    public static function changeNameOnId(string $newName, int $userId): bool
    {
        $sql = "UPDATE users SET name = ? WHERE id = ?";
        return (new Database())->query($sql, [$newName, $userId]);
    }

    /**
     * Metodo statico che aggiorna il cognome dell'utente corrispondente all'id fornito nel database.
     *
     * @param string $newSurname Il nuovo cognome dell'utente.
     * @param int $userId L'id dell'utente da aggiornare.
     * @return bool Restituisce true se l'aggiornamento è avvenuto con successo, altrimenti false.
     */
    public static function changeSurnameOnId(string $newSurname, int $userId): bool
    {
        $sql = "UPDATE users SET surname = ? WHERE id = ?";
        return (new Database())->query($sql, [$newSurname, $userId]);
    }

    /**
     * Metodo statico che aggiorna la password dell'utente corrispondente all'id fornito nel database.
     *
     * @param string $oldPassword La vecchia password dell'utente.
     * @param string $newPassword La nuova password dell'utente.
     * @param int $userId L'id dell'utente da aggiornare.
     * @return bool Restituisce true se l'aggiornamento è avvenuto con successo, altrimenti false.
     */
    public static function changePasswordOnId(string $oldPassword, string $newPassword, int $userId): bool
    {
        try {
            $query = "SELECT password FROM users WHERE id = ?";
            $result = (new Database())->query($query, [$userId]);
            if ($result->num_rows == 1) {
                // L'utente esiste, verifico la password utilizzando una costante di tempo sicura
                $user = $result->fetch_assoc();
                if (!hash_equals($user['password'], crypt($oldPassword, $user['password']))) {
                    return false;
                }
                $password_hash = password_hash($newPassword, PASSWORD_DEFAULT);
                $query = "UPDATE users SET password = ? WHERE id = ?";
                $result = (new Database())->query($query, [$password_hash, $userId]);
                if ($result) {
                    return true;
                }
                return false;
            }
            return false;
        } catch (Error) {
            return false;
        }
    }

    /**
     * Questa funzione elimina l'account dell'utente loggato distruggendo la sua sessione,
     * eliminando l'account dal database e cancellando la cartella contenente i file multimediali dell'utente.
     *
     * @return bool True se l'account è stato eliminato con successo, false altrimenti.
     */
    public static function deleteAccountOnSession(): bool
    {

        function deleteDirectory($dir): bool
        {
            if (!file_exists($dir)) {
                return true;
            }

            if (!is_dir($dir)) {
                return unlink($dir);
            }

            foreach (scandir($dir) as $item) {
                if ($item == '.' || $item == '..') {
                    continue;
                }

                if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                    return false;
                }
            }

            return rmdir($dir);
        }

        //Preparazione della query SQL per eliminare l'account con l'id specificato
        $query = "DELETE FROM users WHERE id = ?";

        //Esecuzione della query
        $result = (new Database())->query($query, [$_SESSION['id']]);

        //Controllo se la query è stata eseguita con successo
        if ($result) {

            $cartella_da_eliminare = PATH . '/media-folder/' . $_SESSION['id'];
            deleteDirectory($cartella_da_eliminare);


            //Account eliminato con successo
            return true;
        } else {
            //Errore nell'eliminazione dell'account
            return false;
        }
    }

    /**
     * Questa funzione restituisce il nome completo dell'utente con l'id specificato.
     *
     * @param int $id L'id dell'utente di cui si vuole conoscere il nome completo.
     * @return string|bool Il nome completo dell'utente, se l'operazione è andata a buon fine, false altrimenti.
     */
    public static function getFullNameById(int $id): false|string
    {
        $query = "SELECT name, surname FROM users WHERE id = ?";
        $result = (new Database())->query($query, [$id]);
        if ($result && ($result->num_rows > 0)) {
            //Account eliminato con successo
            $user = $result->fetch_assoc();
            return $user['name'] . ' ' . $user['surname'];
        } else {
            //Errore nell'eliminazione dell'account
            return false;
        }
    }

    /**
     * Questa funzione restituisce l'id della scuola di appartenenza dell'utente con l'id specificato.
     *
     * @param int $id L'id dell'utente di cui si vuole conoscere l'id della scuola di appartenenza.
     * @return int|bool L'id della scuola di appartenenza dell'utente, se l'operazione è andata a buon fine, false altrimenti.
     */
    public static function getSchoolIdById(int $id): bool|int
    {
        $query = "SELECT school FROM users WHERE id = ?";
        $result = (new Database())->query($query, [$id]);
        if ($result && ($result->num_rows > 0)) {
            //Account eliminato con successo
            $user = $result->fetch_assoc();
            return $user['school'];
        } else {
            //Errore nell'eliminazione dell'account
            return false;
        }
    }

    /**
     * Aggiorna il like dell'utente sul post specificato.
     *
     * @param int $id_post L'id del post su cui l'utente ha messo mi piace.
     * @return int Ritorna 0 se l'utente ha tolto il like, UNO se l'utente ha messo il like, -1 in caso di errore.
     */
    public static function updateLike(int $id_post): int
    {
        try {
            $query = "SELECT * FROM likes WHERE user=? AND post=?";
            $result = (new Database())->query($query, [$_SESSION['id'], $id_post]);
            if ($result) {
                if ($result->num_rows > 0) {
                    $query = "DELETE FROM likes WHERE user=? AND post=?";
                    $result = (new Database())->query($query, [$_SESSION['id'], $id_post]);
                    if ($result) {
                        return 0;
                    }
                } else {
                    $query = "INSERT INTO likes (user, post) VALUES (?, ?)";
                    $result = (new Database())->query($query, [$_SESSION['id'], $id_post]);
                    if ($result) {
                        return 1;
                    }
                }

            }
            return -1;
        } catch (Error) {
            return -1;
        }

    }

    /**
     * Verifica se l'utente ha messo mi piace sul post specificato.
     *
     * @param int $postId L'id del post su cui verificare se l'utente ha messo mi piace.
     * @return bool Ritorna true se l'utente ha messo mi piace sul post, false altrimenti.
     */
    public static function hasLikedPost(int $postId): bool
    {
        if (!isset($_SESSION['id'])) {
            return false;
        }
        // Eseguo la query per verificare se l'utente ha messo mi piace sul post
        $sql = "SELECT id FROM likes WHERE user = ? AND post = ?";
        $result = (new Database())->query($sql, [$_SESSION['id'], $postId]);

        // Se il conteggio è maggiore di ZERO, significa che l'utente ha messo mi piace
        if ($result->num_rows == 1) {
            return true;
        }

        return false;
    }


    /**
     * Verifica se la sessione dell'utente è ancora valida.
     *
     * @return ErrorCode Ritorna un oggetto ErrorCode con un codice di errore e un messaggio di errore.
     */
    public static function checkDynamicSession(): ErrorCode
    {

        try {
            if (!isset($_SESSION['id'])) {
                return new ErrorCode(0, "Accesso non effettuato");
            }

            $sql = "SELECT status FROM users WHERE id = ?";
            $result = (new Database())->query($sql, [$_SESSION['id']]);

            if ($result && ($result->num_rows == 1)) {
                $user = $result->fetch_assoc();
                $status = $user['status'];
                //echo "status: " . $status;
                //echo "session: " . $_SESSION['status'];
                if ($status != $_SESSION['status']) {
                    $_SESSION['status'] = $status;
                    return new ErrorCode(1, "Rilevato cambio nella sessione");
                }
            } else {
                return new ErrorCode(2, "Errore durante la ricerca");
            }
            return new ErrorCode(3, "Nessun azione");
        } catch (Error) {
            return new ErrorCode(4, "Errore durante la ricerca");
        }

    }

    /**
     * Controlla se esiste un cookie di sessione valido e, se sì, imposta la sessione corrispondente
     * Durata del cookie: 30 giorni
     *
     * @return void
     */
    public static function checkSessionCookie(): void
    {
        $cookie_duration = 60 * 60 * 24 * 30; // 30 giorni

        if (isset($_COOKIE["session_id"]) && !isset($_SESSION["id"])) {
            $session_id = $_COOKIE["session_id"];
            $query = "SELECT * FROM sessions WHERE session_id = ?";
            $result = (new Database())->query($query, [$session_id]);
            if ($result->num_rows == 1) {
                $fetch_id = $result->fetch_assoc();
                $id = $fetch_id["user_id"];

                $query = "SELECT * FROM users WHERE id = ?";
                $result = (new Database())->query($query, [$id]);

                if ($result->num_rows == 1) {
                    $user = $result->fetch_assoc();

                    $_SESSION["id"] = $user["id"];
                    $_SESSION["email"] = $user["email"];
                    $_SESSION["role"] = $user["role"];
                    $_SESSION["name"] = $user["name"];
                    $_SESSION["surname"] = $user["surname"];
                    $_SESSION["school"] = $user["school"];
                    $_SESSION["status"] = $user["status"];
                    $_SESSION["logged_in"] = true;

                    $query = "DELETE FROM sessions WHERE user_id = ?";
                    (new Database())->query($query, [$user["id"]]);

                    $session_id = session_id();
                    $query = "INSERT INTO sessions (session_id, user_id) VALUES (?, ?)";
                    (new Database())->query($query, [$session_id, $_SESSION["id"]]);

                    setcookie("session_id", $session_id, time() + $cookie_duration, "/");
                }
            }
        }
    }

}