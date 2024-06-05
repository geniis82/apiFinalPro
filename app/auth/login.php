<?php
include_once '../../config/config.php';
$db = Database::getConnection();

$data = getTidyJSONInput();
logAPI($data);
try {
    $input = validate($data, [
        'email' => 'required|string|min:9|max:9',
        'password' => 'required|string|min:6|max:12'
    ]);

    $user = User::getByDNI($db, $input->email);
    // logAPI($user);
    if ($input->password !== $user['password'] || $user['isClient'] === false) {
        createException('Invalid Credentials', 500);
    }

    file_put_contents(Constants::API_URL . "helpers/tokens/$input->email.txt", createToken());
    $token = file_get_contents(Constants::API_URL . "helpers/tokens/$input->email.txt");
    $user = User::getByDNI($db, $input->email);
    // logAPI($user);

    Response::sendResponse([
        "token" => $token,
        'id' => $user['id']
    ]);

} catch (Exception $e) {
    Response::sendError($e->getMessage(), $e->getCode());
}