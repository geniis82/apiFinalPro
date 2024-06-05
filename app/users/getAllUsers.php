<?php
include_once '../../config/config.php';
$db = Database::getConnection();

$data = getInput();

try {
    // check_token($data); 
    // $input = validate($data, [
    //     'dni' => 'required|string',
    // ]);

    $resp = User::getUsers($db);
    foreach ($resp as $user) {
        $arrayToReturn[] = array(
            "value" => $user['id'],
            "label" => $user["name"] . " " . $user["surname"],
            "options" => array(
                "dni" => $user["dni"],
                "tlf" => $user["tlf"],
                "dateBirth" => $user["dateBirth"],
                "email" => $user["email"],
                "name"=> $user["name"],
                "surname"=>$user["surname"],
                "isClient"=>$user["isClient"]

            )
        );
    }
    Response::sendResponse([
        "users" => $arrayToReturn,
    ]);

} catch (Exception $e) {
    Response::sendError($e->getMessage(), $e->getCode());
}