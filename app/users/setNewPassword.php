<?php
include_once '../../config/config.php';
$db = Database::getConnection();

$data = getTidyJSONInput();
try {
    check_token($data);
    $input = validate($data, [
        'id' => 'required|string',
        'dni' => 'required|string',
        'oldPassword' => 'required|string',
        'newPassword' => 'required|string',
    ]);

    $passUser = User::getUserPass($db, $input->dni);
    if ($input->oldPassword !== $passUser[0]['password']) {
        createException('La contraseña antigua no coincide con la actual');
    }
    if ($input->newPassword === $input->oldPassword) {
        createException('La contraseña nueva no puede ser la misma que la antigua');
    }
    $userUpdate = User::setNewPassword($db, $input->id, $input->newPassword);
    Response::sendResponse([
        "user" => $userUpdate,
    ]);

} catch (Exception $e) {
    Response::sendError($e->getMessage(), $e->getCode());
}