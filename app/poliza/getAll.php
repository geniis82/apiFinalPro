<?php
include_once '../../config/config.php';
$db = Database::getConnection();

$data = getInput();

try {
    // check_token($data);
    // $input = validate($data, [
    //     'dni' => 'required|string',
    // ]);

    $resp = Poliza::getAll($db);
    // logAPI($resp);

    Response::sendResponse([
        "polizas"=>$resp,
    ]);

} catch (Exception $e) {
    Response::sendError($e->getMessage(), $e->getCode());
}