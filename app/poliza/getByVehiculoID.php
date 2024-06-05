<?php
include_once '../../config/config.php';
$db = Database::getConnection();

$data = getInput();

try {
    check_token($data);

    $input = validate($data, [
        
        'vehiculo_id' => 'required|string',
    ]);
    $resp = Poliza::getByVehiculoID($db, $input->vehiculo_id);
    // logAPI($resp);

    Response::sendResponse([
        "poliza" => $resp[0],
    ]);

} catch (Exception $e) {
    Response::sendError($e->getMessage(), $e->getCode());
}