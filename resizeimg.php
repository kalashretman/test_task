<?php

header('Access-Control-Allow-Origin: *');
include_once "classes/Methods.php";

$status = 'OK';
$response = null;
$error = 0;

if ($_FILES['uploadname'] && $_POST['userID']){

    //сперва проверяем наличие id клиента
    if (!Methods::checkUser($_POST['userID'])){
        $status = 'ERROR';
        $error = 'User is not identity';

    } else $response = Methods::saveResizeImages($_POST);

}else{
    $status = 'ERROR';
    $error = "File not found!";
}

// array for answer
$result = array(
    'status' => $status,
    'response' => $response,
    'error' => $error,
);
echo json_encode($result); // answer by json's format