<?php

namespace includes\php;

require_once('includes/php/Database.php');

use Error;

/**
 * La classe Post fornisce i metodi per la gestione dei post sul database.
 */
class Post
{
    /**
     * Definisce i nomi e gli identificatori dei tipi di visibilità dei post.
     *
     * @var array Array associativo con gli identificatori e i nomi dei tipi di visibilità.
     */
    public const VISIBILITY = [0 => ['id' => 0, 'name' => 'pubblico'],
        1 => ['id' => 1, 'name' => 'scuola'],
        2 => ['id' => 2, 'name' => 'privato'],
    ];

    /**
     * Restituisce i nomi dei tipi di visibilità dei post.
     *
     * @return array Array contenente i nomi dei tipi di visibilità.
     */
    public static function getVisibilityNames(): array
    {
        $visibilityNames = [];
        foreach (self::VISIBILITY as $visibility) {
            $visibilityNames[] = $visibility['name'];
        }
        return $visibilityNames;
    }

    /**
     * Restituisce l'identificatore di un tipo di visibilità a partire dal suo nome.
     *
     * @param string $name Il nome del tipo di visibilità.
     *
     * @return int|null L'identificatore del tipo di visibilità o null se non trovato.
     */
    public static function getVisibilityIdFromName(string $name): ?int
    {
        foreach (self::VISIBILITY as $visibility) {
            if ($visibility['name'] === $name) {
                return $visibility['id'];
            }
        }
        return null;
    }

    /**
     * Aggiunge un nuovo post al database.
     *
     * @param string $title Il titolo del post.
     * @param string $content Il contenuto del post.
     * @param int $author L'identificatore dell'autore del post.
     * @param int $visibility L'identificatore del tipo di visibilità del post.
     * @param int $category L'identificatore della categoria del post.
     *
     * @return ErrorCode Un oggetto che rappresenta lo stato dell'operazione di aggiunta.
     */
    public static function add(string $title, string $content, int $author, int $visibility, int $category): ErrorCode
    {

        try {
            $query = "INSERT INTO posts (title, content, author, visibility, category) VALUES (?, ?, ?, ?, ?)";

            $result = (new Database())->query($query, [$title, $content, $author, $visibility, $category]);
            if ($result) {
                return new ErrorCode(0, "Operazione eseguita con successo");
            } else {
                return new ErrorCode(1, "Errore durante il salvataggio del post");
            }
        } catch (Error $exception) {
            echo $exception;
            return new ErrorCode(2, "Errore durante il salvataggio del post");
        }
    }

    /**
     * Modifica un post esistente nel database.
     *
     * @param string $title Il nuovo titolo del post.
     * @param string $content Il nuovo contenuto del post.
     * @param int $author L'ID dell'autore del post.
     * @param string $visibility La visibilità del post.
     * @param int $category L'ID della categoria del post.
     * @param int $id L'ID del post da modificare.
     *
     * @return ErrorCode Un oggetto ErrorCode che rappresenta l'esito positivo o negativo dell'operazione.
     */
    public static function edit(string $title, string $content, int $author, string $visibility, int $category, int $id): ErrorCode
    {
        try {
            $query = "UPDATE posts SET title=?, content=?, author=?, visibility=?, category=? WHERE id=?";

            $result = (new Database())->query($query, [$title, $content, $author, $visibility, $category, $id]);
            if ($result) {
                return new ErrorCode(0, "Operazione eseguita con successo");
            } else {
                return new ErrorCode(1, "Errore durante la modifica del post");
            }
        } catch (Error $exception) {
            echo $exception;
            return new ErrorCode(2, "Errore durante la modifica del post");
        }
    }

    /**
     * Controlla se l'utente ha il permesso di modificare o eliminare un post.
     *
     * @param int $id_user L'ID dell'utente.
     * @param int $id_post L'ID del post.
     *
     * @return false|array Restituisce false se l'utente non ha il permesso, o un array associativo che rappresenta il post se l'utente ha il permesso.
     */
    public static function checkPermissionOnPost(int $id_user, int $id_post): false|array
    {
        $post = self::exist($id_post);

        if ($post && $post['author'] == $id_user) {
            return $post;
        }
        return false;

    }

    /**
     * Controlla se esiste un post con l'ID specificato nel database.
     *
     * @param int $id_post L'ID del post.
     *
     * @return false|array Restituisce false se il post non esiste, o un array associativo che rappresenta il post se il post esiste.
     */
    public static function exist(int $id_post): false|array
    {
        $query = "SELECT id, author, title FROM posts WHERE id = ?";
        $result = (new Database())->query($query, [$id_post]);
        if ($result->num_rows == 1) {
            return $result->fetch_assoc();
        }
        return false;
    }

    /**
     * Retrieves a post from the database by ID.
     *
     * @param int $id The ID of the post to retrieve.
     *
     * @return false|array Returns false if the post does not exist, or an associative array representing the post if the post exists.
     */
    public static function get(int $id): false|array
    {

        $query = "SELECT * FROM posts WHERE id = ?";
        $result = (new Database())->query($query, [$id]);
        if ($result->num_rows == 1) {
            return $result->fetch_assoc();
        }
        return false;
    }
    /**
     * Metodo che restituisce i dettagli di un post per la visualizzazione pubblica.
     * Restituisce un array con le informazioni del post se il post è pubblico o se l'utente autenticato appartiene alla stessa scuola del post.
     * In caso contrario, reindirizza l'utente alla pagina di accesso limitato e restituisce false.
     *
     * @param int $id_post l'id del post da recuperare
     * @return array|false Un array contenente le informazioni del post o false se l'accesso è limitato
     */
    public static function getForView(int $id_post): false|array
    {

        $query = "SELECT * FROM posts WHERE id = ?";
        $result = (new Database())->query($query, [$id_post]);
        if ($result->num_rows == 1) {
            $post = $result->fetch_assoc();
            if ($post['visibility'] == Post::getVisibilityIdFromName('pubblico')) {
                return $post;
            } elseif ($post['visibility'] == Post::getVisibilityIdFromName('scuola')) {
                if (isset($_SESSION['id']) && User::getSchoolIdById($_SESSION['id']) == User::getSchoolIdById($post['author'])) {
                    return $post;
                } else {
                    header("Location: " . PATH . '/access-restricted');
                    die();
                }
            } elseif ($post['visibility'] == Post::getVisibilityIdFromName('privato')) {
                if ($_SESSION['id'] != $post['author']) {
                    header("Location: " . PATH . '/access-restricted');
                    die();
                }
            }
        }
        return false;
    }

    /**
     * Metodo che restituisce un array contenente tutte le categorie dal database.
     *
     * @return array Un array contenente tutte le categorie dal database
     */
    public static function getCategories(): array
    {
        $sql = "SELECT * FROM categories";
        $result = (new Database())->query($sql);

        $categoriesNames = [];
        while ($row = $result->fetch_assoc()) {
            $categoriesNames[] = $row;
        }

        return $categoriesNames;
    }

    /**
     * Metodo che restituisce un array contenente tutti i nomi delle categorie dal database, ordinati per nome.
     *
     * @return array Un array contenente tutti i nomi delle categorie dal database, ordinati per nome
     */
    public static function getCategoriesNames(): array
    {
        $sql = "SELECT * FROM categories ORDER BY name";
        $result = (new Database())->query($sql);

        $categoriesNames = [];
        while ($row = $result->fetch_assoc()) {
            $categoriesNames[] = $row['name'];
        }

        return $categoriesNames;
    }

    /**
     * Dato un nome di categoria, restituisce l'ID della categoria corrispondente nel database.
     *
     * @param string $name Il nome della categoria da cercare.
     *
     * @return mixed L'ID della categoria o false se non è stato trovato.
     */
    public static function getCategoryIdByName(string $name): mixed
    {
        $db = new Database();
        $sql = "SELECT id FROM categories WHERE name = ?";

        $result = $db->query($sql, [$name]);

        if ($result->num_rows == 0) {
            return false;
        }

        $row = $result->fetch_assoc();
        return $row['id'];
    }

    /**
     * Dato un ID di categoria, restituisce il nome della categoria corrispondente nel database.
     *
     * @param int $id L'ID della categoria da cercare.
     * @return mixed Il nome della categoria o false se non è stato trovato.
     */
    public static function getCategoryNameById(int $id): mixed
    {
        $db = new Database();
        $sql = "SELECT name FROM categories WHERE id = ?";

        $result = $db->query($sql, [$id]);

        if ($result->num_rows == 0) {
            return false;
        }

        $row = $result->fetch_assoc();
        return $row['name'];
    }

    /**
     * Dato un ID di visibilità, restituisce il nome di visibilità corrispondente.
     *
     * @param int $id L'id della visibilità da cercare.
     * @return mixed Il nome della visibilità o false se non è stato trovato.
     */
    public static function getVisibilityNameById(int $id): mixed
    {
        return self::VISIBILITY[$id]['name'] ?? false;
    }

    /**
     * Elimina il post con l'ID specificato dal database.
     *
     * @param int $id L'ID del post da eliminare.
     * @return bool True se il post è stato eliminato correttamente, false in caso contrario.
     */
    public static function deletePostById(int $id): bool
    {
        $query = "DELETE FROM posts WHERE id = ?";

        //Esecuzione della query
        $result = (new Database())->query($query, [$id]);

        //Controllo se la query è stata eseguita con successo
        if ($result) {
            //Account eliminato con successo
            return true;
        } else {
            //Errore nell'eliminazione dell'account
            return false;
        }
    }

    /**
     * Dato un ID post, restituisce il numero di Mi piace che il post ha ricevuto.
     *
     * @param int $id L'ID del post per cui ottenere i Mi piace.
     * @return int Il numero di Mi piace ricevuti dal post o zero se si è verificato un errore.
     */
    public static function getLikes(int $id): int
    {

        $query = "SELECT COUNT(*) as count FROM likes WHERE post = ?";
        $result = (new Database())->query($query, [$id]);
        if ($result && $result->num_rows > 0) {
            $likes = $result->fetch_assoc();
            return $likes['count'];
        } else {
            //Errore nell'eliminazione dell'account
            return 0;
        }
    }

}