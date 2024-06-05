<?php
include_once '../../config/config.php';
$db = Database::getConnection();

$data = getInput();
// logAPI($data);

try {
    // check_token($data);
    $input = validate($data, [
        'name' => 'required|string',
    ]);
    $resp = Asegurance::getByName($db, $input->name);

    // logAPI($resp);
    Response::sendResponse([
        'asegurnace' => $resp
    ]);


} catch (Exception $e) {
    Response::sendError($e->getMessage(), $e->getCode());
}