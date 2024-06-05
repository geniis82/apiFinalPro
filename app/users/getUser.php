<?php
include_once '../../config/config.php';
$db = Database::getConnection();

$data = getInput();

try {
    check_token($data);
    $input = validate($data, [
        'dni' => 'required|string',
    ]);
    $resp = User::getUser($db, $input->dni);

    logAPI($resp);
    Response::sendResponse([
        "user" => $resp[0],
    ]);

} catch (Exception $e) {
    Response::sendError($e->getMessage(), $e->getCode());
}