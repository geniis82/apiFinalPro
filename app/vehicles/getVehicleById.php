<?php
include_once '../../config/config.php';
$db = Database::getConnection();

$data = getInput();

try {
    check_token($data);
    $input = validate($data, [
        'id' => 'required|string',
    ]);

    $resp = Vehicle::getVehiclesByID($db, $input-> id);
    // $resp = Vehicle::getVehiclesByUser($db, $user['id']);
    $arrayToReturn = [];

    foreach ($resp as $vehicle) {
        $arrayToReturn[] = array(
            "value" => $vehicle['id'],
            "label" => $vehicle["name"],
            "options" => array(
                "marca" => $vehicle["marca"],
                "modelo" => $vehicle["modelo"]
            )
        );

    }

    Response::sendResponse([
        "vehicles" => $arrayToReturn[0],
    ]);

} catch (Exception $e) {
    Response::sendError($e->getMessage(), $e->getCode());
}