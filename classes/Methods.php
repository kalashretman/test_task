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
        $sql = Db::pdo()->prepare("SELECT resize_img_url, height, width FROM images WHERE userID = :userID");
        $sql->execute(array(':userID'=>$userID));

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    function recordImg($img_data)
    {
        $sql = Db::pdo()->prepare("INSERT INTO (id, userID, original_img_url, resize_img_url, height, width)
                                   VALUES ('', :userID, :original_img_url, :resize_img_url, :height, :width)");
        $sql->execute(array(
            ':userID' => $img_data['userID'],
            ':original_img_url' => $img_data['original_img_url'],
            ':resize_img_url' => $img_data['resize_img_url'],
            ':height' => $img_data['height'],
            ':width' => $img_data['width'],
        ));
    }

    function resizeImages(array $data){

        $uploaddir = 'images/tmp/';
        $uploadfile = $uploaddir.basename($_FILES['uploadname']['name']);

        if (!copy($_FILES['uploadname']['tmp_name'], $uploadfile)){
            echo 'Error with images!';
            exit();
        }

        list($width, $height, $type, $attr) = getimagesize('images/tmp/'.basename($_FILES['uploadname']['name']));
        $nameFile = rand(0, 10000000).".".substr($_FILES['uploadname']['type'], 8);

        $savePath = 'images/resize/'.$nameFile;
        $filePath = 'images/tmp/'.basename($_FILES['uploadname']['name']);

        $image = AcImage::createImage($filePath);
        $image
            ->thumbnail($width, $height)
            ->save($savePath);

        return $nameFile;
    }


    function saveResizeImages($data){

        $imgurl= NULL;
        $imgresizeurl = NULL;

        if ($_FILES['uploadfile']['name']){

            $nameFile = $this->resizeImages('uploadfile');
            $imgurl = "http://".$_SERVER['SERVER_NAME']."/images/".$nameFile;
            $imgresizeurl = "http://".$_SERVER['SERVER_NAME']."/images/resize/".$nameFile;
        }

        $img_data = array(':userID' => $data['userID'],
            ':original_img_url' => $imgurl,
            ':resize_img_url' => $imgresizeurl,
            ':height' => $data['height'],
            ':width' => $data['width']);

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