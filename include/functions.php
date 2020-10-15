<?php

//Функция удаления файлов
function deleteFile($uploadPath)
{
    if (!isset($_POST['checkImage']) || empty($_POST['checkImage'])) {
        $message[] = "Вы ничего не выбрали.";
    } else {
        $deleteImages = $_POST['checkImage'];
        $count = count($deleteImages);
        $message['count'] = "Вы выбрали $count файлов для удаления:";
        foreach ($deleteImages as $key => $deleteImage) {
            $delPath = $uploadPath . $deleteImage;
            $message[$key] = $deleteImage;
            if (is_file($delPath) && unlink($delPath)) {
                $message[$key] .= " удален.";
            } else {
                $message[$key] .= " не получилось удалить.";
            }
        }
    }
    return $message;
}

//Функция возвращает преобразованный размер файла
function showFileSize($path)
{
    $size = convertSize(filesize($path));
    return $size;
}

//Функция преобразования размера файла
function convertSize($size)
{
    $conversion = [
        'b' => [0, 10239, 0,],
        'kb' => [10240, 1048575, 1,],
        'Mb' => [1048576, 20971520, 2,],
    ];

    foreach ($conversion as $key => $value) {
        if ($size >= $value[0] && $size <= $value[1]) {
            $size = round($size / pow(1024, $value[2]), 2) . ' ' . $key;
            return $size;
        }
    }
}

//Функция вывода изображений с информацией в ячейках flex_element
function showFlexElement() {
    include($_SERVER['DOCUMENT_ROOT'] . '/template/flex_element.php');
}

//Функция возвращает дату и время загрузки файла
function dateUplaod($path)
{
    $unix = filectime($path);
    return date('d.m.Y', $unix);
}

//Функция распределения информации по каждому загружаемому файлу в отдельном подмассиве
function formatArrayFiles()
{
    $multiFile = [];
    foreach ($_FILES['myFile'] as $key => $value) {
        foreach ($value as $subKey => $subValue) {
            $multiFile[$subKey][$key] = $subValue;
        }
    }
    return $multiFile;
}

//Функция проверки mime-type
function checkMimeType($uploadArray)
{
    $fileTypes = ['image/jpeg', 'image/png',];
    $mimeType = '';
    if(function_exists('mime_content_type')){
            $mimeType = mime_content_type($uploadArray['tmp_name']);
    }elseif(function_exists('finfo_open')){
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $uploadArray['tmp_name']);
            finfo_close($finfo);
    }
    return in_array($mimeType, $fileTypes);
}

//Функция проверки типа файла
function checkTypeFile($uploadArray)
{
    $blacklist = ['php', 'phtml',];
    foreach ($blacklist as $item) {
        if(stripos($uploadArray['name'], $item) !== false) {
            return 2;
        }
    }
    if (checkMimeType($uploadArray)) {
        $extension = explode('.', $uploadArray['name']);
        $extension = array_pop($extension);
        $allowedExtensions = ['jpeg', 'JPEG', 'png', 'PNG', 'jpg', 'JPG',];
        if (in_array($extension, $allowedExtensions)) {
            return $extension;
        }
    }
    return 1;
}

//функция переименования загружаемого файла
function nameExists($uploadArray, $extension, $uploadPath)
{
    $subName = null;
    do {
        $nameCutExt = str_replace('.' . $extension, '', $uploadArray['name']);
        $safeName = $nameCutExt . $subName . '.' . $extension;
        $subName++;
    } while (file_exists($uploadPath . $safeName));
    return $safeName;
}

//Функция валидации файла
function checkErrors($uploadArray, $infoMessage = '')
{
    $size = filesize($uploadArray['tmp_name']);
    if ($size > 5242880) {
        $infoMessage = 'Вы пытаетесь загрузить файл размером: ' . convertSize($size);
        $infoMessage .= '(' . $size . 'b)' . '. Максимальный размер: 5Mb.';
        return $infoMessage;
    }
    if (!empty($uploadArray['error'])) {
        switch ($uploadArray['error']) {
            case '1':
            case '2':
                $infoMessage = 'Вы пытаетесь загрузить файл размером более 20Mb. Максимальный размер: 5Mb.';
                break;
            case '3':
                $infoMessage = 'Загружаемый файл был получен только частично.';
                break;
            case '4':
                $infoMessage = 'Файл не был выбран.';
                break;
            case '6':
                $infoMessage = 'Отсутствует временная папка.';
                break;
            case '7':
                $infoMessage = 'Не удалось записать файл на диск.';
                break;
            case '8':
                $infoMessage = 'PHP-расширение остановило загрузку файла.';
                break;
            default:
                $infoMessage = 'Произошла ошибка загрузки. Пожалуйста, сделайте что-нибудь с этим.';
                break;
        }
    }
    return $infoMessage;
}

//Функция загрузки файлов новая
function uploadImageFile($uploadArray, $uploadPath)
{
    $message = checkErrors($uploadArray);
    if ($message == '') {
        $resultExt = checkTypeFile($uploadArray);
        if ($resultExt === 1) {
            $message = 'Недопустимое расширение файла либо mime-type. ';
            $message .= 'Изображение должно иметь одно из расширений: "jpeg", "png", "jpg".';
        } elseif ($resultExt === 2) {
            $message = 'Имя файла не должно иметь php расширений и содержать в названии буквенные сочетания: "php", "phtml". ';
            $message .= 'Изображение должно иметь одно из расширений: "jpeg", "png", "jpg".';
        } else {
            $newName = nameExists($uploadArray, $resultExt, $uploadPath);
            if (move_uploaded_file($uploadArray['tmp_name'], $uploadPath . $newName)) {
                $message = "Файл:  " . $uploadArray['name'];
                $message .= " успешно загружен в галерею под именем: " . $newName;
            } else {
                $message = "Загрузка файла не состоялась.";
            }
        }
        return $message;
    } else {
        return $message;
    }
}

//Функция проверки соответствия запроса и пути в разделе меню
function checkItem($itemPath)
{
    return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) === $itemPath;
}

//Функция отображения раздела
function pageTitle($items)
{
    foreach ($items as $item) {
        if (checkItem($item['path'])) {
            return $item['title'];
        }
    }
    return false;
}

//Функция создания главного меню
function createMenu($items)
{
    include($_SERVER['DOCUMENT_ROOT'] . '/template/main_menu_ul.php');
}

//Функция перевода массива в строку с разделителями из тегов HTML
function arrayToString($array, $openingTag = '<p>', $closingTag = '</p>')
{
    $string = '';
    foreach ($array as $value) {
        $string .= $openingTag . $value . $closingTag;
    }
    return $string;
}
