<?php

use includes\php\Database;

function getList()
{

    $response = array();
    $sql = "SELECT * FROM media WHERE user = ?";
    $result = (new Database())->query($sql, [$_SESSION['id']]);

    if ($result) {
        if ($result->num_rows > 0) {
            $media = $result->fetch_all(MYSQLI_ASSOC);
            foreach ($media as $row) {

                $img = new \StdClass;
                $img->url = PATH . '/media?hash=' . $row['hash'];
                $img->thumb = PATH . '/media?hash=' . $row['hash'];
                $img->name = $row['slang'];

                // Add to the array of image.
                array_push($response, $img);

            }
        }

    }

    return $response;
}

try {
    $response = getList();
    echo stripslashes(json_encode($response));
} catch (Error $exception) {
    $status = 404;
    $message = $exception->getMessage();

    header("HTTP/1.1 $status $message");
    header("Content-type: text/plain");
}