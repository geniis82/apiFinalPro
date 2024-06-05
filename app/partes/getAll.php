<?php
include_once '../../config/config.php';
$db = Database::getConnection();

$data = getInput();

try {
    // check_token($data);
    $input = validate($data, [
        'idUser' => 'required|string',
    ]);

    $resp = Partes::getAllbyUser($db, $input->idUser);
    // logAPI($resp);

    Response::sendResponse([
        "partes"=>$resp,
    ]);

} catch (Exception $e) {
    Response::sendError($e->getMessage(), $e->getCode());
}