<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: Subscriber, Token, X-Api-Key, Authorization, content-type");
header("Content-Type: application/json");
?>
<?php
// $document_root = $_SERVER['DOCUMENT_ROOT']. "/projecteFinal/api";
$document_root = $_SERVER['DOCUMENT_ROOT']. "/api";
require __DIR__ . '/../vendor/autoload.php';

// #Database
include_once $document_root . '/config/Constants.php';
include_once $document_root . '/config/database.php';
//Helpers
include_once $document_root . '/helpers/utils.php';



/**
 * Function to include all .php files inside the app automatically.
 * Be sure to call that function under that one passing the folder route as eg: include_dir_r($document_root . '/objects');
 * The function gets all files recursively.
 *
 * @param [string] $dir_path
 */
function include_dir_r($dir_path): void
{
    $path = realpath($dir_path);
    $objects = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path), \RecursiveIteratorIterator::SELF_FIRST);
    foreach ($objects as $name => $object) if ($object->getFilename() !== "." && $object->getFilename() !== "..") if (!is_dir($name)) include_once $name;
}

include_dir_r($document_root . '/objects');
include_dir_r($document_root . '/Controllers');
include_dir_r($document_root . '/Resources');
include_dir_r($document_root . '/helpers/handler');


?>