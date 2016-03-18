<?php

include_once "classes/Methods.php";

if ($_POST['data']){

    $methods = new Methods();
    $data = $_POST['data'];

    //сперва проверяем наличие id клиента
    if (!checkIdClient($data['id_client'])){
        $list = array('error' => 'User is not identifity');
    } else {
        $list = $methods->getListImages($data['id_client']);
        if (!$list) $list = array('massage'=>'User have not images');
    }

    echo json_encode($list);
}