<?php

namespace includes\php;

require_once('includes/php/Database.php');
require_once('includes/php/User.php');

use Error;

/**
 * La classe AccessControl fornisce funzioni per controllare i ruoli e gli stati dell'account dell'utente.
 */
class AccessControl
{
    /**
     * Array di stati dell'account con ID, nome e URL di redirect.
     */
    public const ACCOUNT_STATUSES = [0 => ['id' => 0, 'name' => 'non trovato', 'redirect' => '/not-found'],
        1 => ['id' => 1, 'name' => 'attivo', 'redirect' => '/access-restricted'],
        2 => ['id' => 2, 'name' => 'da verificare', 'redirect' => '/verify'],
        3 => ['id' => 3, 'name' => 'bloccato', 'redirect' => '/blocked'],
        4 => ['id' => 4, 'name' => 'da validare', 'redirect' => '/to-check'],
    ];

    /**
     * Array di ruoli con ID, nome e URL di redirect.
     */
    public const ROLES = [0 => ['id' => 0, 'name' => 'ospite', 'redirect' => '/access-restricted'],
        1 => ['id' => 1, 'name' => 'studente', 'redirect' => '/access-restricted'],
    ];

    /**
     * Restituisce un array di nomi di ruoli esclusi quelli nascosti.
     *
     * @param array $hiddenRoles Array di nomi di ruoli nascosti.
     * @return array Array di nomi di ruoli.
     */
    public static function getRoleNames(array $hiddenRoles = []): array
    {
        $roleNames = [];
        foreach (self::ROLES as $role) {
            if (!in_array($role['name'], $hiddenRoles)) {
                $roleNames[] = $role['name'];
            }
        }
        return $roleNames;
    }

    /**
     * Restituisce l'ID dello stato dell'account per il nome passato come parametro.
     *
     * @param string $statusName Nome dello stato dell'account.
     * @return int ID dello stato dell'account.
     * @throws Error Se lo stato dell'account non è valido.
     */
    public static function getStatusIdByName(string $statusName): int
    {
        foreach (self::ACCOUNT_STATUSES as $id => $status) {
            if ($status['name'] === $statusName) {
                return $id;
            }
        }
        throw new Error('Stato non valido: ' . $statusName);
    }

    /**
     * Restituisce l'ID del ruolo per il nome passato come parametro.
     *
     * @param string $roleName Nome del ruolo.
     * @return int ID del ruolo.
     * @throws Error Se il ruolo non è valido.
     */
    public static function getRoleIdByName(string $roleName): int
    {
        foreach (self::ROLES as $role) {
            if ($role['name'] === $roleName) {
                return $role['id'];
            }
        }
        throw new Error('Ruolo non valido: ' . $roleName);
    }

    /**
     * Verifica se i nomi di ruoli passati come parametro sono validi.
     *
     * @param array $roleNames Array contenente i nomi dei ruoli da verificare
     * @return bool True se i nomi dei ruoli sono validi, false altrimenti
     */
    public static function checkRoleNames(array $roleNames): bool
    {
        foreach ($roleNames as $name) {
            $found = false;
            foreach (self::ROLES as $role) {
                if ($role['name'] === $name) {
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                return false;
            }
        }
        return true;
    }

    /**
     * Verifica se i nomi di stati dell'account passati come parametro sono validi.
     *
     * @param array $statusNames Array contenente i nomi degli stati dell'account da verificare
     * @return bool True se i nomi degli stati dell'account sono validi, false altrimenti
     */
    public static function checkStatusNames(array $statusNames): bool
    {
        foreach ($statusNames as $name) {
            $found = false;
            foreach (self::ACCOUNT_STATUSES as $status) {
                if ($status['name'] === $name) {
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                return false;
            }
        }
        return true;
    }


    /**
     * Restituisce il ruolo con l'ID corrispondente.
     *
     * @param int $id L'ID del ruolo da cercare
     * @return array|null Array contenente i dati del ruolo corrispondente all'ID cercato, oppure null se non esiste
     */
    public static function getRoleById(int $id): ?array
    {
        return self::ROLES[$id] ?? null;
    }

    /**
     * Restituisce lo stato dell'account con l'ID corrispondente.
     *
     * @param int $id L'ID dello stato dell'account da cercare
     * @return array|null Array contenente i dati dello stato dell'account corrispondente all'ID cercato, oppure null se non esiste
     */
    public static function getStatusById(int $id): ?array
    {
        return self::ACCOUNT_STATUSES[$id] ?? null;
    }

    /**
     * Verifica se l'utente ha almeno uno dei ruoli richiesti.
     * Se l'utente non ha i permessi necessari, viene rediretto alla pagina di errore corrispondente.
     *
     * @param array $requiredRoles Array contenente i nomi dei ruoli richiesti
     * @return bool True se l'utente ha almeno uno dei ruoli richiesti, false altrimenti
     */
    public static function requireRoles(array $requiredRoles): bool
    {

        User::checkSessionCookie();

        if (!self::checkRoleNames($requiredRoles)) {
            return false;
        }

        foreach ($requiredRoles as $roleName) {
            if (self::getRoleIdByName($roleName) == User::getRoleOnSession()) {
                return true;
            }
        }
        header('Location: ' . PATH . self::getRoleById(User::getRoleOnSession())['redirect']);
        die();
    }

    /**
     * Verifica se lo stato dell'account dell'utente è almeno uno di quelli richiesti.
     * Se lo stato dell'account non è uno di quelli richiesti, l'utente viene reindirizzato alla pagina di errore corrispondente.
     *
     * @param array $requiredStatus Array contenente i nomi degli stati richiesti.
     * @return bool True se lo stato dell'account dell'utente è uno di quelli richiesti, false altrimenti.
     */
    public static function requireStatus(array $requiredStatus): bool
    {

        User::checkSessionCookie();

        if (!self::checkStatusNames($requiredStatus)) {
            return false;
        }

        foreach ($requiredStatus as $statusName) {
            if (self::getStatusIdByName($statusName) == User::getStatusOnSession()) {
                return true;
            }
        }

        header('Location: ' . PATH . self::getStatusById(User::getStatusOnSession())['redirect']);
        die();
    }
}