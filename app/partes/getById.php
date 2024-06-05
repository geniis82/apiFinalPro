<?php
include_once '../../config/config.php';
$db = Database::getConnection();

$data = getInput();

try {
    check_token($data);
    $input = validate($data, [
        'id' => 'required|string',
    ]);
    $resp = Partes::getById($db, $input->id);
    // logAPI($resp);
    Response::sendResponse([
        "parte" => $resp[0],
        
    ]);
    // logAPI($user1);

} catch (Exception $e) {
    Response::sendError($e->getMessage(), $e->getCode());
}