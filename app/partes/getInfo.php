<?php
include_once '../../config/config.php';
$db = Database::getConnection();

$data = getInput();
// logAPI($data);

try {
    // check_token($data);
    $input = validate($data, [
        'id' => 'required|string',
    ]);
    $resp = Partes::getById($db, $input->id);
    $user1 = User::getUserById($db, $resp['client1'][0]);
    $user2 = User::getUserById($db, $resp['client2'][0]);
    $vehi1 = Vehicle::getVehiclesByID($db, $resp['vehiculo'][0]);
    $vehi2 = Vehicle::getVehiclesByID($db, $resp['vehiculo2'][0]);
    $pol1 = Poliza::getByVehiculoID($db, $resp['vehiculo'][0]);
    $pol2 = Poliza::getByVehiculoID($db, $resp['vehiculo2'][0]);
    // logAPI($pol2);
    //mount json to return 

    $vehi1[0]["poliza_ids"] = $pol1[0];
    if (!empty($pol2)) {
        $vehi2[0]["poliza_ids"] = $pol2[0];
    }

    $resp['client1'] = $user1[0];
    $resp['client2'] = $user2[0];
    $resp['vehiculo'] = $vehi1[0];
    $resp['vehiculo2'] = $vehi2[0];
    logAPI($resp);
    Response::sendResponse([
        'parte' => $resp
    ]);


} catch (Exception $e) {
    Response::sendError($e->getMessage(), $e->getCode());
}