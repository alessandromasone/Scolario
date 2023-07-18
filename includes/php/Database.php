<?php

namespace includes\php;

use mysqli;
use mysqli_result;

class Database
{

    // Proprietà per la connessione al database
    private string $servername;
    private string $username;
    private string $password;
    private string $dbname;
    private mysqli $conn;

    /**
     * Costruttore della classe, inizializza le proprietà della connessione al database e chiama il metodo connect().
     */
    public function __construct()
    {
        $this->servername = DB_SERVER;
        $this->username = DB_USERNAME;
        $this->password = DB_PASSWORD;
        $this->dbname = DB_NAME;
        $this->connect();
    }

    /**
     * Metodo privato per la connessione al database, utilizzando le proprietà della classe.
     * Se la connessione fallisce, viene interrotto il processo e viene mostrato un messaggio di errore.
     */
    private function connect(): void
    {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("Connessione al database fallita: " . $this->conn->connect_error);
        }
    }

    /**
     * Metodo per l'esecuzione di una query al database.
     * @param string $sql La query da eseguire.
     * @param array $params I parametri per la query, opzionale.
     * @return string|bool|mysqli_result Se la query è di tipo SELECT, viene restituito un oggetto mysqli_result contenente i risultati.
     *               Altrimenti, se la query è di tipo INSERT, UPDATE o DELETE e va a buon fine, viene restituito true.
     *               In caso di errore, viene restituito il messaggio di errore.
     */
    public function query(string $sql, array $params = []): string|bool|mysqli_result
    {
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Errore nella preparazione della query: " . $this->conn->error);
        }
        if (!empty($params)) {
            $types = '';
            foreach ($params as $param) {
                if (is_int($param)) {
                    $types .= 'i';
                } elseif (is_float($param)) {
                    $types .= 'd';
                } elseif (is_string($param)) {
                    $types .= 's';
                } else {
                    $types .= 'b';
                }
            }
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        if ($stmt->errno) {
            die("Errore nell'esecuzione della query: " . $stmt->error);
        }
        $query_type = strtoupper(substr(trim($sql), 0, 6));
        if ($query_type === 'SELECT') {
            $result = $stmt->get_result();
            $stmt->close();
            return $result;
        } else {
            if ($this->conn->affected_rows >= 0) {
                $stmt->close();
                return true;
            } else {
                $error = mysqli_error($this->conn);
                $stmt->close();
                return $error;
            }
        }
    }
}
