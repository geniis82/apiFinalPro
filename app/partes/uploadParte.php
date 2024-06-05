<?php
include_once '../../config/config.php';
$db = Database::getConnection();
$data = $_FILES['file'];
// logAPI($data);

try {
    if ($data['error'] === UPLOAD_ERR_OK) {
        $file_name = $data['name'];
        $file_tmp = $data['tmp_name'];
        $file_type = $data['type'];
        $destination_path = __DIR__ . '../../helpers/images/';
        if (move_uploaded_file($file_tmp, "images/$file_name")) {
            Response::sendResponse(['image_url' => "images/$file_name"]);
        } else {
            Response::sendError('Error al mover el archivo', 500);
        }
    } else {
        Response::sendError('Error al subir el archivo', 400);
    }
} catch (Exception $e) {
    Response::sendError('Error interno del servidor', 500);
}