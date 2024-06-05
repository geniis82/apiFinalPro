<?php
include_once '../../config/config.php';
$db = Database::getConnection();

$data = getInput();

try {
    check_token($data);
    $input = validate($data, [
        'dni' => 'required|string',
    ]);

    $user = User::getByDNI($db, $input->dni);
    $resp = Poliza::getVehiculosWithPoliByIdUser($db, $user['id']);
    // $resp = Vehicle::getVehiclesByUser($db, $user['id']);

    Response::sendResponse([
        "poliza" => $resp,
    ]);

} catch (Exception $e) {
    Response::sendError($e->getMessage(), $e->getCode());
}