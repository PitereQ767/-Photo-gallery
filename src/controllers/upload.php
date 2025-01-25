<?php

include_once '../database.php';
function upload(&$model) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $allowed_extensions = ['png', 'jpg', 'jpeg'];
        $max_file_size = 1 * 1024 * 1024; 
        $model['error'] = [];

        if(!isset($_POST['watemark']) || trim($_POST['watemark']) === ''){
            $model['error'][] = "Błąd: Znak wodny jest wymagany.";
            
        }

        if(!isset($_POST['title']) || trim($_POST['title']) == '' || !isset($_POST['author']) || trim($_POST['author']) == ''){
            $model['error'][] = "Błąd: Tytuł i autor są wymagane.";
            
        }

        $watemark_text = $_POST['watemark'];
        $title = $_POST['title'];
        $author = $_POST['author'];
        if(isset($_POST['visibility'])){
            $visibility = $_POST['visibility'];
        }else{
            $visibility = 'public';
        }
        

        if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
            $file_tmp = $_FILES['file']['tmp_name'];
            $file_name = $_FILES['file']['name'];
            $file_size = $_FILES['file']['size'];
            $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            
            if ($file_size > $max_file_size) {
                $model['error'][] = "Błąd: Przesłany plik jest za duży. Maksymalny rozmiar to 1MB.";
            } 
            
            elseif (!in_array($file_extension, $allowed_extensions)) {
                $model['error'][] = "Błąd: Dozwolone są tylko pliki PNG lub JPG.";
            } 
            
            elseif (empty($model['error'])) {
                $target_dir = '../web/static/img/';
                $new_file_name = uniqid('image_') . '.' . $file_extension;
                $target_file = $target_dir . $new_file_name;

                if (move_uploaded_file($file_tmp, $target_file)) {
                    $model['success'] = "Plik został pomyślnie przesłany: " . $new_file_name;

                    $watermarked_file = $target_dir . uniqid('watermarked_') . '.' . $file_extension;
                    $watermarked_name = basename($watermarked_file);
                    if (add_watermark($target_file, $watermarked_file, $watemark_text)){
                        $model['success'] .= "<br> Znak wodny został dodany.";
                    }else{
                        $model['error'][] = "Błąd: Nie udało się dodać znaku wodnego.";
                    }

                    $thumbnail_file = $target_dir . uniqid('thumbnail_') . '.' . $file_extension;
                    $thumbnail_name = basename($thumbnail_file);
                    if(create_thumbnail($target_file, $thumbnail_file, 200, 125)){
                        $model['success'] .= "<br>Miniaturka została wygenerowana.";
                    }else{
                        $model['error'][] = "Błąd: Nie udało się wygenerować miniaturki.";
                    }
                    
                    add_document($model, $title, $author, $new_file_name, $watermarked_name, $thumbnail_name, $visibility);

                } else {
                    $model['error'][] = "Błąd: Nie udało się przesłać pliku.";
                }
            }
        } else {
            $model['error'][] = "Błąd: Nie wybrano pliku do przesłania lub wystąpił problem podczas przesyłania.";
        }
    }
    return 'upload_view'; 
}

function add_watermark($source_file, $destination_file, $watermark_text){
    $image = imagecreatefromstring(file_get_contents($source_file));

    if ($image === false){
        return false;
    }

    $font_color = imagecolorallocate($image, 255, 255, 255);
    $font_path = '../fonts/arial.ttf';
    $font_size = 10;
    $margin = 10;

    $image_width = imagesx($image);
    $image_height = imagesy($image);
    $text_box = imagettfbbox($font_size, 0, $font_path, $watermark_text);
    $text_width = $text_box[2] - $text_box[0];
    $text_height = $text_box[1] - $text_box[7];

    $x = $image_width - $text_width - $margin;
    $y = $image_height - $text_height - $margin;

    imagettftext($image, $font_size, 0, $x, $y, $font_color, $font_path, $watermark_text);
    $result = imagepng($image, $destination_file);
    imagedestroy($image);
    return $result;
}

function create_thumbnail($source_file, $destination_file, $thumb_width, $thumb_height){
    $image = imagecreatefromstring(file_get_contents($source_file));

    if ($image === false){
        return false;
    }

    $width = imagesx($image);
    $height = imagesy($image);

    $thumbnail = imagecreatetruecolor($thumb_width, $thumb_height);
    imagecopyresampled($thumbnail, $image, 0, 0, 0, 0, $thumb_width, $thumb_height, $width, $height);
    
    $result = imagepng($thumbnail, $destination_file);
    imagedestroy($image);
    imagedestroy($thumbnail);

    return $result;
}