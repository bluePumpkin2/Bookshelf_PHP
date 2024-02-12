<?php
    function es(array|string $data, string $charset='UTF-8'):mixed{
        if(is_array($data)){
            return array_map(__METHOD__, $data);
        }else{
            return htmlspecialchars(string:$data, flags:ENT_QUOTES, encoding:$charset);
        }
    }

    function cken(array $data):bool{
        $result = true;
        foreach($data as $key => $value){
            if(is_array($value)){
                $value = implode("", $value);
            }
            if(!mb_check_encoding($value)){
                $result = false;
                break;
            }
        }
        return $result;
    }

    function ImageResize($image_type, $before_image, $maxWidth, $maxHeight, $quality){
            if($image_type == 'image/jpeg' || $image_type == 'image/pjpeg'){
                $ext = '.jpg';
            } elseif($image_type == 'image/png' || $image_type == 'image/x-png'){
                $ext = '.png';
            } elseif($image_type == 'image/gif'){
                $ext = '.gif';
            } else {
                print 'ファイル形式が正しくありません。<br>';
                print '<input type="button" onclick="history.back()" value="戻る">';
                exit();
            }

            list($width, $height) = getimagesize($before_image);
            
            //maxWidthとmaxHeightがリサイズ後の最大サイズ
            if($width <= $maxWidth && $height <= $maxHeight){
                $scale = 1.0;
            } else {
                $scale = min($maxWidth / $width, $maxHeight / $height);
            }
         
            $newWidth = $width * $scale;
            $newHeight = $height * $scale;
            
            switch($ext){
                case '.jpg':
                    $baseImage = imagecreatefromjpeg($before_image);
                    break;
                
                case '.png':
                    $baseImage = imagecreatefrompng($before_image);
                    break;

                case '.gif':
                    $baseImage = imagecreatefromgif($before_image);
                    break;
            }

            $newImage = imagecreatetruecolor($newWidth, $newHeight); // サイズを指定して新しい画像のキャンバスを作成
            // 画像のコピーと伸縮
            imagecopyresampled($newImage, $baseImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            
            // コピーした画像を元の画像に上書き
            imagejpeg($newImage , $before_image, $quality);

            imagedestroy($baseImage);
            imagedestroy($newImage);
    }
?>