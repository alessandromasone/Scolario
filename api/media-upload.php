<?php

use includes\php\Database;
use includes\php\AccessControl;

AccessControl::requireRoles(["studente"]);
AccessControl::requireStatus(["attivo"]);


try {
    // File Route.

    $fileRoute = "media-folder/".$_SESSION['id']."/";


    // Get filename.

    $filename = explode(".", $_FILES['file']["name"]);
    // Validate uploaded files.
    // Do not use $_FILES["file"]["type"] as it can be easily forged.
    $finfo = finfo_open(FILEINFO_MIME_TYPE);

    // Get temp file name.
    $tmpName = $_FILES['file']["tmp_name"];

    // Get mime type.
    $mimeType = finfo_file($finfo, $tmpName);

    // Get extension. You must include fileinfo PHP extension.
    $extension = end($filename);

    // Allowed extensions.
    $allowedExts = array("bmp", "doc", "docx", "flac", "gif", "jpeg", "jpg", "mkv", "mov", "mp3", "mp4", "ogg", "pdf", "png", "ppt", "pptx", "rar", "rtf", "svg", "tif", "tiff", "txt", "wav", "wma", "wmv", "xls", "xlsx", "zip");

// Allowed mime types.
    $allowedMimeTypes = array("image/bmp", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "audio/flac", "image/gif", "image/jpeg", "image/pjpeg", "video/x-matroska", "video/quicktime", "audio/mpeg", "video/mp4", "audio/ogg", "application/pdf", "image/png", "application/vnd.ms-powerpoint", "application/vnd.openxmlformats-officedocument.presentationml.presentation", "application/x-rar-compressed", "application/rtf", "image/svg+xml", "image/tiff", "image/tiff", "text/plain", "audio/wav", "audio/x-ms-wma", "video/x-msvideo", "application/vnd.ms-excel", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "application/zip");

    // Validate image.
    if (!in_array(strtolower($mimeType), $allowedMimeTypes) || !in_array(strtolower($extension), $allowedExts)) {
        throw new \Exception("File does not meet the validation.");
    }

    // Generate new random name.
    $name = sha1(microtime()) . sha1(sha1(microtime())) . "." . $extension;

    $name_hash = hash('sha256', $name);

    $sql = "INSERT INTO media (hash, name, user, slang) VALUES (?, ?, ?, ?)";
    $result = (new Database())->query($sql, [$name_hash, $name, $_SESSION['id'], $_FILES['file']["name"]]);





    if (!file_exists($fileRoute)) {
        mkdir($fileRoute, 0777, true);
    }

    $fullNamePath = $fileRoute . $name;

    // Check server protocol and load resources accordingly.
    if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] != "off") {
        $protocol = "https://";
    } else {
        $protocol = "http://";
    }

    // Save file in the uploads folder.
    $v = move_uploaded_file($tmpName, $fullNamePath);


    // Generate response.
    $response = new \StdClass;
    $response->link = PATH .'/media?hash=' . $name_hash;
    //$response->link = $protocol . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . $fileRoute . $name;
    //$response->link = $v;

    // Send response.
    echo stripslashes(json_encode($response));
} catch (Error $exception) {
    // Send error response.

    $status = 404;
    $message = $exception->getMessage();

    header("HTTP/1.1 $status $message");
    header("Content-type: text/plain");
    //echo $exception->getMessage();
    //echo "Oops! $message - the requested resource was not found.";
}


