<?php

header('Access-Control-Allow-Origin: *');
include_once "classes/Methods.php";

$status = 'OK';
$response = null;
$error = 0;

if ($_POST['userID']){

    //сперва проверяем наличие id клиента
    if (!Methods::checkUser($_POST['userID'])){
        $status = 'ERROR';
        $error = 'User is not identity';
    } else {
        $response = Methods::getListImages($_POST['userID']);
        if (!$response) $response = 'User have not images';
    }
}else{
    $status = 'ERROR';
    $error = "Request's error";
}

// array for answer
$result = array(
    'status' => $status,
    'response' => $response,
    'error' => $error,
);

header('Content-type: application/json');
echo json_encode($result); // answer by json's format