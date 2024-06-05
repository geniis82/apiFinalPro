<?php
include_once '../../config/config.php';
$db = Database::getConnection();

$data = getTidyJSONInput();
// logAPI($data);
try {
    check_token($data);
    $input = validate($data, [
        'id' => 'required|string',
        'email' => 'required|string',
        'phone' => 'required|string',
    ]);

    $userUpdate = User::setEmailPhone($db, $input->id, $input->email, $input->phone);
    // logAPI($userUpdate);
    Response::sendResponse([
        "user" => $userUpdate,
    ]);

} catch (Exception $e) {
    Response::sendError($e->getMessage(), $e->getCode());
}