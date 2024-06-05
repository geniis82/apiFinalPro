<?php
include_once '../../config/config.php';
$db = Database::getConnection();

$data = getTidyJSONInput();
// logAPI($data);
try {
    check_token($data);
    $input = validate($data, [
        'id' => 'required|string',
        'name' => 'required|string',
        'surname' => 'required|string',
    ]);

    $userUpdate = User::setNameSurname($db, $input->id, $input->name, $input->surname);
    // logAPI($userUpdate);
    Response::sendResponse([
        "user" => $userUpdate,
    ]);

} catch (Exception $e) {
    Response::sendError($e->getMessage(), $e->getCode());
}