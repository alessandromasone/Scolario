<?php

namespace includes\php;

class School
{

    /**
     * Restituisce l'ID della scuola associato al codice fiscale dato.
     *
     * @param string $tax_code Il codice fiscale della scuola.
     *
     * @return int|bool L'id della scuola se trovata, altrimenti false.
     */
    public static function getIdByTaxCode(string $tax_code): bool|int
    {
        $db = new Database();
        $sql = "SELECT id FROM schools WHERE tax_code = ?";

        $result = $db->query($sql, [$tax_code]);

        if ($result->num_rows == 0) {
            return false;
        }

        $row = $result->fetch_assoc();
        return $row['id'];
    }

    /**
     * Restituisce un array contenente i nomi di tutte le scuole ordinate in ordine alfabetico.
     *
     * @return array Array contenente i nomi delle scuole.
     */
    public static function getNames(): array
    {
        $sql = "SELECT * FROM schools ORDER BY name";
        $result = (new Database())->query($sql);

        $schoolNames = [];
        while ($row = $result->fetch_assoc()) {
            $schoolNames[] = $row;
        }

        return $schoolNames;
    }

    /**
     * Restituisce il nome della scuola associata all'ID dato.
     *
     * @param int $school_id L'id della scuola.
     *
     * @return string|false Il nome della scuola se trovata, altrimenti false.
     */
    public static function getNameById(int $school_id): false|string
    {
        $sql = "SELECT name FROM schools WHERE id = ?";

        $result = (new Database())->query($sql, [$school_id]);

        if ($result->num_rows == 0) {
            return false;
        }

        $row = $result->fetch_assoc();
        return htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8');
    }

}