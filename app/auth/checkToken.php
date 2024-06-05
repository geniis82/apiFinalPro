<?php
include_once '../../config/config.php';
$db = Database::getConnection();

$data = getTidyJSONInput();
try {
    check_token($data);

    Response::sendResponse([]);

} catch (Exception $e) {
    Response::sendError($e->getMessage(), $e->getCode());
}