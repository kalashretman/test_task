<?php

include_once "classes/Methods.php";

$status = 'OK';
$response = null;
$error = 0;

if ($_POST['data']){
    //сперва проверяем наличие id клиента
    if (!checkIdClient($data['userID'])){
        $status = 'ERROR';
        $error = 'User is not identifity';

    } else {
        $response = $methods->resizeImages($data['id_client']);
        if (!$response){
            $status = 'ERROR';
            $error = 'User have not images';
        }
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
echo json_encode($result); // answer by json's format