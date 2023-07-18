<?php


use includes\php\AccessControl;
use includes\php\Database;
use includes\php\Post;

AccessControl::requireRoles(["studente"]);
AccessControl::requireStatus(["attivo"]);

$limit = '10';
$page = 1;
if (isset($_POST['page'])) {
    if ($_POST['page'] > 1) {
        $start = (($_POST['page'] - 1) * $limit);
        $page = $_POST['page'];
    } else {
        $start = 0;
    }
} else {
    $start = 0;
}

$query = '

SELECT
    p.id AS id,
    p.title AS title,
    p.content AS content,
    p.create_at AS time,
    p.visibility AS visibility,
    s.name AS school,
    c.name AS category
FROM
    posts p 
LEFT JOIN users u ON
    p.author = u.id
LEFT JOIN categories c ON
    p.category = c.id
LEFT JOIN schools s ON 
    u.school = s.id
WHERE
    u.id = ? ';

if (isset($_SESSION['id'])) {

    if ($_POST['view'] != '') {

        if ($_POST['view'] == 'privato') {
            $query .= '
    AND (p.visibility = ? AND p.author = ?)
    ';
        } else if ($_POST['view'] == 'scuola') {
            $query .= '
    AND (p.visibility = ? AND u.school = ?)
    ';
        } else {
            $query .= ' AND p.visibility = ? ';
        }

    } else {
        $query .= ' AND ((p.visibility = ? AND u.school = ?) OR p.visibility = ? OR (p.visibility = ? AND p.author = ?)) ';
    }


} else {
    $query .= ' AND p.visibility = ? ';
}

if ($_POST['query'] != '') {
    $query .= ' AND (p.title LIKE ? OR p.content LIKE ?) ';
}


$query .= '
ORDER BY
    p.create_at DESC 
';

$params = [];


$params[] = $_SESSION['id'];
if ($_POST['category'] != '') {
    $params[] = Post::getCategoryIdByName($_POST['category']);
}

if (isset($_SESSION['id'])) {

    if ($_POST['view'] != '') {

        if ($_POST['view'] == 'privato') {
            $params[] = Post::getVisibilityIdFromName($_POST['view']);
            $params[] = $_SESSION['id'];
        } else if ($_POST['view'] == 'scuola') {
            $params[] = Post::getVisibilityIdFromName($_POST['view']);
            $params[] = $_SESSION['school'];
        } else {
            $params[] = Post::getVisibilityIdFromName('pubblico');
        }

    } else {
        $params[] = Post::getVisibilityIdFromName('scuola');
        $params[] = $_SESSION['school'];
        $params[] = Post::getVisibilityIdFromName('pubblico');
        $params[] = Post::getVisibilityIdFromName('privato');
        $params[] = $_SESSION['id'];
    }


} else {
    $params[] = Post::getVisibilityIdFromName('pubblico');
}


if ($_POST['query'] != '') {
    $params[] = '%' . $_POST['query'] . '%';
    $params[] = '%' . $_POST['query'] . '%';
}


$filter_query = $query . 'LIMIT ' . $start . ', ' . $limit;

$result = (new Database())->query($query, $params);
$filter_result = (new Database())->query($filter_query, $params);

if ($result) {
    $posts = $filter_result->fetch_all(MYSQLI_ASSOC);

    $html = '';

    if ($result->num_rows > 0) {


        foreach ($posts as $post) {

            $html .= '<div class="border rounded mb-3 p-3">';
            $html .= '<p class="text-muted mb-0 h6"><small>' . formatDateTime($post['time']) . '</small></p>';
            $html .= '<span class="h5 text-decoration-none text-primary">' . $post['title'] . '</span>  <small class="text-muted">' . $post['category'] . '</small>';
            $html .= '<p class="text-muted mb-2">' . Post::getVisibilityNameById($post['visibility']) .'</p>';
            $html .= '<button type="button" class="btn red-fb btn-sm me-1" data-bs-toggle="modal" data-bs-target="#deletePost-' . $post['id'] . '">Elimina <i class="bi bi-trash"></i></button>';
            $html .= '<a href="'.PATH.'/post/edit?id='.$post['id'].'" type="button" class="btn green-fb btn-sm">Modifica <i class="bi bi-pencil-square"></i></a>';
            //$html .= '<p class="mb-0">' . generateSummary($post['content'], 100) . '</p>';
            //$html .= '<small><p class="text-muted mb-0">' . $post['school'] .'</p></small>';
            $html .= '</div>';

            $html .= '
            
            <!-- Modal -->
<div class="modal fade" id="deletePost-' . $post['id'] . '" tabindex="-1" aria-labelledby="deletePostLabel-' . $post['id'] . '" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="deletePostLabel-' . $post['id'] . '">Eliminare ' . $post['title'] . '?</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
     <form class="to-ajax modal-footer" action="' . PATH . '/delete/post" method="post">
     <input type="hidden" name="id" value="' . $post['id'] . '" />
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                    <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Conferma</button>
                </form>
  </div>
</div>
</div>
            
            ';
            $html .= '';
            $html .= '';

        }


        $total_data = $result->num_rows;

        $output = '<ul class="pagination d-flex justify-content-center mt-3">';
        $total_links = ceil($total_data / $limit);
        $previous_link = '';
        $next_link = '';
        $page_link = '';
        if ($total_links > 4) {
            if ($page < 5) {
                for ($count = 1; $count <= 5; $count++) {
                    $page_array[] = $count;
                }
                $page_array[] = '...';
                $page_array[] = $total_links;
            } else {
                $end_limit = $total_links - 5;
                if ($page > $end_limit) {
                    $page_array[] = 1;
                    $page_array[] = '...';
                    for ($count = $end_limit; $count <= $total_links; $count++) {
                        $page_array[] = $count;
                    }
                } else {
                    $page_array[] = 1;
                    $page_array[] = '...';
                    for ($count = $page - 1; $count <= $page + 1; $count++) {
                        $page_array[] = $count;
                    }
                    $page_array[] = '...';
                    $page_array[] = $total_links;
                }
            }
        } else {
            for ($count = 1; $count <= $total_links; $count++) {
                $page_array[] = $count;
            }
        }
        for ($count = 0; $count < count($page_array); $count++) {
            if ($page == $page_array[$count]) {
                $page_link .= '
                    <li class="page-item active">
                        <a class="page-link" href="javascript: void(0)">' . $page_array[$count] . ' <span class="sr-only"></span></a>
                    </li>
                ';
                $previous_id = $page_array[$count] - 1;
                if ($previous_id > 0) {
                    $previous_link = '
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" data-page_number="' . $previous_id . '">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    ';
                } else {
                    $previous_link = '
                        <li class="page-item disabled">
                            <a class="page-link" href="javascript: void(0)">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    ';
                }
                $next_id = $page_array[$count] + 1;
                if ($next_id > $total_links) {
                    $next_link = '
                        <li class="page-item disabled">
                            <a class="page-link" href="javascript: void(0)">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    ';
                } else {
                    $next_link = '
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" data-page_number="' . $next_id . '">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    ';
                }
            } else {
                if ($page_array[$count] == '...') {
                    $page_link .= '
                        <li class="page-item disabled">
                            <a class="page-link" href="javascript: void(0)">...</a>
                        </li>
                    ';
                } else {
                    $page_link .= '
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" data-page_number="' . $page_array[$count] . '">' . $page_array[$count] . '</a>
                        </li>
                    ';
                }
            }
        }
        $output .= $previous_link . $page_link . $next_link;
        $output .= '</ul>';


        $html .= $output;
    } else {
        $html = "<p class='text-center'>Nessun post trovato</p>";
    }


    echo $html;
    exit();

} else {
    echo "Errore durante l'esecuzione della query";
}

function generateSummary($text, $words = 50): string
{
    // Rimuovi i tag HTML e le entità
    $text = html_entity_decode(strip_tags($text), ENT_QUOTES, 'UTF-8');

    // Conta il numero di parole nel testo
    $wordCount = str_word_count($text);

    // Tronca il testo alla lunghezza desiderata solo se ci sono abbastanza parole
    if ($wordCount > $words) {
        $text = trim(substr($text, 0, strpos($text, ' ', $words) ?: strlen($text)));
        $text .= '...';
    }

    return $text;
}


function formatDateTime($dateString)
{
    $date = DateTime::createFromFormat('Y-m-d H:i:s', $dateString);
    return $date ? $date->format('d M Y') : '';
}

