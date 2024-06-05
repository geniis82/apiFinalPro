<?php
include_once '../../config/config.php';
// $db = Database::getConnection();

$data = getTidyJSONInput();
try {
    $input = validate($data, [
        'dni' => 'required|string|min:9|max:9',
    ]);
    if (!file_exists(Constants::API_URL . "helpers/tokens/$input->dni.txt")) {
        createException('User not exist', 501);
    }
    file_put_contents(Constants::API_URL . "helpers/tokens/$input->dni.txt", "");
    Response::sendResponse([
        "logout" => true,
    ]);
} catch (Exception $e) {
    Response::sendError($e->getMessage(), $e->getCode());
}