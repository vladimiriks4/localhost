<?php

include($_SERVER['DOCUMENT_ROOT'] . '/include/functions.php');

if ($_FILES['myFile']['name']['0'] !== '') {
    $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/upload/';
    $countFiles = count($_FILES['myFile']['name']);
    if ($countFiles <= 5) {
        $uploadArrays= formatArrayFiles();
        $messages = [];
        foreach ($uploadArrays as $key => $uploadArray) {
            $message = uploadImageFile($uploadArray, $uploadPath);
            $messages[] = $message;
        }
    } else {
        $messages[] = 'Вы выбрали: ' . $countFiles . ' шт. Количество файлов должно быть не более 5 шт.';
    }
} else {
    $messages[] = 'Вы не выбрали файл.';
}
$req = arrayToString($messages);
echo json_encode($req);
exit;
