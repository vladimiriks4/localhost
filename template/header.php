<?php

//Массив разделов меню сайта
$mainMenu = [
    [
        'title' => 'Загрузка изображений на сервер',
        'path' => '/',
    ],
    [
        'title' => 'Просмотр и удаление изображений',
        'path' => '/view.php',
    ],
];

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="/styles.css">
    <title>Галерея изображений</title>
    <script src="/include/jquery-3.4.1.min.js"></script>
</head>
<body>

	<h1><?= pageTitle($mainMenu) ?></h1>
	<?php createMenu($mainMenu); ?>
    <div class="clearfix"></div>
