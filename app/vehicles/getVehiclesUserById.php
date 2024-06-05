<?php
include_once '../../config/config.php';
$db = Database::getConnection();

$data = getInput();

try {
    check_token($data);
    $input = validate($data, [
        'id' => 'required|string',
    ]);

    $resp = Vehicle::getVehiclesByUser($db, $input->id);
    // $resp = Vehicle::getVehiclesByUser($db, $user['id']);
    $arrayToReturn = [];

    foreach ($resp as $vehicle) {
        $arrayToReturn[] = array(
            "value" => $vehicle['id'],
            "label" => $vehicle["name"],
            "options" => array(
                "marca" => $vehicle["marca"],
                "modelo" => $vehicle["modelo"], 
                "poliza_ids"=>$vehicle["poliza_ids"]
            )
        );

    }

    Response::sendResponse([
        "vehicles" => $arrayToReturn,
    ]);

} catch (Exception $e) {
    Response::sendError($e->getMessage(), $e->getCode());
}