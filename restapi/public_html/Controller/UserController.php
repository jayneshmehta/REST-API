<?php
// require_once "../Model/UserModel.php";
require_once "BaseController.php";


// "/user/list" Endpoint - Get list of users 
class UserController extends BaseController
{

    public function userAction($table)
    {
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $url = $_SERVER['REQUEST_URI'];
        $strErrorDesc = '';
        $arrQueryStringParams = $this->getQueryStringParams();
        $userModel = new UserModel('192.168.101.102:3306', 'root', 'deep70', 'Property_DBMS');
        switch ($requestMethod) {

            case 'GET':

                if ($arrQueryStringParams) {
                    try {
                        $userId = (int)10;
                        if (isset($arrQueryStringParams['user_id']) && $arrQueryStringParams['user_id']) {
                            $userId = (int)$arrQueryStringParams['user_id'];
                        }
                        $arrUsers = $userModel->getUsers($table, "*", null, null, "user_id", $userId, null, null);
                        $responseData = json_encode($arrUsers, JSON_PRETTY_PRINT);
                    } catch (Error $e) {
                        $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                        $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                    }
                } else {
                    try {
                        $userId = (int)10;
                        if (isset($arrQueryStringParams['user_id']) && $arrQueryStringParams['user_id']) {
                            $userId = (int)$arrQueryStringParams['user_id'];
                        }
                        $arrUsers = $userModel->getUsers($table, "*", null, null, null, null, null, null);
                        $responseData = json_encode($arrUsers, JSON_PRETTY_PRINT);
                    } catch (Error $e) {
                        $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                        $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                    }
                }

                if ($strErrorDesc == '') {
                    $this->sendOutput(
                        $responseData,
                        array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                    );
                } else {
                    $this->sendOutput(
                        json_encode(array('error' => $strErrorDesc)),
                        array('Content-Type: application/json', $strErrorHeader)
                    );
                }
                break;

            case 'POST':

                if ($url === "/index.php/Users") {
                    header('Content-Type: application/json');
                    $requestBody = json_decode(file_get_contents('php://input'), true);
                    try {
                        $responseData = $userModel->addUsers($table,array_keys($requestBody[0]), array_values($requestBody[0]));
                    } catch (Error $e) {
                        $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                        $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                    }
                } else {
                    echo "Please provide proper request";
                }
                if ($strErrorDesc == '') {
                    $this->sendOutput(
                        $responseData,
                        array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                    );
                } else {
                    $this->sendOutput(
                        json_encode(array('error' => $strErrorDesc)),
                        array('Content-Type: application/json', $strErrorHeader)
                    );
                }

                break;

            case 'PUT':

                if ((isset($arrQueryStringParams['user_id']) && $arrQueryStringParams['user_id'])|| $url !== "/index.php/user") {
                    $requestBody = json_decode(file_get_contents('php://input'), true);
                    $requestBody = $requestBody[0];
                    if(!empty($requestBody)){

                    try {
                        if ($arrQueryStringParams['user_id'] == $requestBody['user_id']) {
                            $responseData = $userModel->updateUsers($table,array_keys($requestBody), array_values($requestBody), "user_id", $requestBody['user_id']);
                        } else {
                            echo "QueryString(url) and user_id should be same...";
                        }
                    } catch (Error $e) {
                        $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                        $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                    }

                }else{
                    echo "Please provide proper data";
                }
                } else {
                    echo "Please provide proper request";
                }
                if ($strErrorDesc == '') {
                    $this->sendOutput(
                        $responseData,
                        array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                    );
                } else {
                    $this->sendOutput(
                        json_encode(array('error' => $strErrorDesc)),
                        array('Content-Type: application/json', $strErrorHeader)
                    );
                }

                break;

            case "DELETE":

                if (isset($arrQueryStringParams['user_id']) && $arrQueryStringParams['user_id']) {
                    try{
                        $responseData = $userModel->deleteUsers($table,"user_id",$arrQueryStringParams['user_id']);
                    } catch (Error $e) {
                        $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                        $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                    }
                } else {
                    echo "Please provide proper request";
                }
                if ($strErrorDesc == '') {
                    $this->sendOutput(
                        $responseData,
                        array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                    );
                } else {
                    $this->sendOutput(
                        json_encode(array('error' => $strErrorDesc)),
                        array('Content-Type: application/json', $strErrorHeader)
                    );
                break;
                }
        }
    }
}