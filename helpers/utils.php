<?php

use Objects\AdminSession;

if (!function_exists('logAPI')) {
	function logAPI($content)
	{
		$content = json_encode($content);
		$date = new DateTime();
		$strDate = $date->format("y:m:d h:i:s");
		file_put_contents(Constants::LOG_FILE_PATH, $strDate . PHP_EOL . str_repeat('-', strlen(36)) . PHP_EOL . $content . PHP_EOL . str_repeat('-', strlen(36)) . PHP_EOL . PHP_EOL, FILE_APPEND | LOCK_EX);
	}
}

//POST
if (!function_exists('getTidyJSONInput')) {
	function getTidyJSONInput()
	{
		$body = trim(file_get_contents('php://input'));
		return json_decode(html_entity_decode($body), true);
	}
}


if (!function_exists('createGUID')) {
	function createGUID()
	{
		return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
	}
}


if (!function_exists('createToken')) {
	function createToken()
	{
		$token = openssl_random_pseudo_bytes(32);
		//Convert the binary data into hexadecimal representation.
		$token = bin2hex($token);
		return $token;
	}
}




if (!function_exists('getTodayDate')) {
	function getTodayDate()
	{
		$today = new DateTime('now');
		return $today->format('Y-m-d H:i:s');
	}
}




// if (!function_exists('validate')) {
// 	function validate($data, $rules = [])
// 	{
// 		$newValidator = new Validator();
// 		$newValidator->validation_rules = $rules;
// 		return $newValidator->to_array($data);
// 	}
// }



if (!function_exists('check_if_token_exist')) {
	function check_if_token_exist($headers)
	{
		return $headers['Authorization'] ?? ($headers['authorization'] ?? false);
	}
}

//GET
if (!function_exists('getInput')) {
	function getInput(): array
	{
		$array_inputs = array();
		foreach ($_GET as $key => $value) {
			$array_inputs[$key] = $value;
		}
		return $array_inputs;
	}
}

if (!function_exists('createPassword')) {
	function createPassword(string $password): string
	{
		return password_hash($password, PASSWORD_DEFAULT);
	}
}

if (!function_exists('createScanBundleGUID')) {
	function createScanBundleGUID(): string
	{
		return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
	}
}

if (!function_exists('validate')) {
	function validate($data, $rules = [])
	{
		$newValidator = new Validator();
		$newValidator->validation_rules = $rules;
		return $newValidator->to_array($data);
	}
}

if (!function_exists('build_condition')) {
	function build_condition(string $column, string $conditional, string $value): array
	{
		return [[$column, $conditional, $value]];
	}
}

if (!function_exists('createException')) {
	function createException($message = "Internal Server Error", $code = 500)
	{
		$error = new CustomException();
		// logError($message);
		$error->setMessage($message, $code);
		throw $error;
	}
}


if (!function_exists('format_credentials_path')) {
	function format_credentials_path(string $dni): string
	{
		return Constants::API_URL . "/helpers/tokens/" . $dni . ".txt";
	}
}

if (!function_exists('check_token')) {
	function check_token(array $data)
	{
		if (isset($data['dni'])) {
			$token_file = format_credentials_path($data['dni']);
			if (isset($data['token'])) {
				if (file_exists($token_file)) {
					$content = file_get_contents($token_file);
					if ($content === $data['token']) {
						return;
					}
				}
			}
		}
		createException('Unauthorized', 401);
	}
}

