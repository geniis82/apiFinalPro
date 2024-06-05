<?php
include_once '../../config/config.php';
$db = Database::getConnection();

$data = getTidyJSONInput();