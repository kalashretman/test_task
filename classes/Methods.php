<?php

/**
 * Created by PhpStorm.
 * User: Эд
 * Date: 17.03.2016
 * Time: 22:05
 */
class Methods
{
    function getListImages($userID)
    {
        $sql = Db::pdo()->prepare("SELECT resize_img_url, height, width FROM images WHERE client_id = :client_id");
        $sql->execute(array(':client_id'=>$userID));

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    function recordImg($img_data)
    {
        $sql = Db::pdo()->prepare("INSERT INTO (id, client_id, original_img_url, resize_img_url, height, width)
                                   VALUES ('', :client_id, :original_img_url, :resize_img_url, :height, :width)");
        $sql->execute(array(
            ':client_id' => $img_data['client_id'],
            ':original_img_url' => $img_data['original_img_url'],
            ':resize_img_url' => $img_data['resize_img_url'],
            ':height' => $img_data['height'],
            ':width' => $img_data['width'],
        ));
    }

    function resizeImages($name, $width, $height){

        $uploaddir = 'tmp/';
        $uploadfile = $uploaddir.basename($_FILES[$name]['name']);

        if (!copy($_FILES[$name]['tmp_name'], $uploadfile)){
            echo 'Error with images!';
            exit();
        }

        list($width, $height, $type, $attr) = getimagesize('tmp/'.basename($_FILES[$name]['name']));
        $nameFile = rand(0, 100000).".".substr($_FILES[$name]['type'], 6);

        $savePath = 'images/resize/'.$nameFile;
        $filePath = 'tmp/'.basename($_FILES[$name]['name']);

        $image = AcImage::createImage($filePath);
        $image
            ->thumbnail($width, $height)
            ->save($savePath);

        return	$nameFile;
    }


    function saveResizeImages(){

        $imgurl= NULL;
        $imgresizeurl = NULL;

        if ($_FILES['uploadfile']['name']){

            $nameFile = $this->resizeImages('uploadfile');
            $imgurl = "http://".$_SERVER['SERVER_NAME']."/images/".$nameFile;
            $imgsmallurl = "http://".$_SERVER['SERVER_NAME']."/images/resize/".$nameFile;
        }

        $this->recordImg($img_data);

    }

    public function checkUser($userID)
    {
        $sql = Db::pdo()->prepare("SELECT COUNT(*) as count FROM users WHERE userID = :userID");
        $sql->execute(array(':userID'=>$userID));
        $result = $sql->fetch(PDO::FETCH_ASSOC);

        if (!$result['count']) return false;
        else return true;
    }
}