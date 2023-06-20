<?php
require_once "Model/UserModel.php";
require_once "inc/config.php";
try {
    $obj = new  UserModel(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);
} catch (Exception $e) {
    echo "Error in connection to Db";
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );
if (!(isset($uri[2])) || isset($uri[3])) {
    header("HTTP/1.1 404 Not Found");
    exit();
}

$table_name = $uri[2];
require_once "Controller/UserController.php";
$objFeedController = new UserController();
$objFeedController->userAction($table_name);
?>