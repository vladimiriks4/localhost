<?php
$uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/upload/';
//Получение массива файлов изображений, загруженных на сервер
$files = scandir($uploadPath);
$files = array_diff($files, array('..', '.', '.htaccess', 'index.html'));
natsort($files);

?>
<?php if (!empty($files)) :?>
    <?php foreach ($files as $key => $file) :?>
        <div class="flex-element">
            <figure class="in-figure">
                <img src="/upload/<?= $file ?>" alt="Изображение <?= $file ?>"/>
            </figure>
            <div class="info"><p><?= $file ?></p></div>
            <div class="info"><p>Загружено: <?= dateUplaod($uploadPath . $file) ?></p></div>
            <div class="info"><p><?= showFileSize($uploadPath . $file) ?></p></div>
            <div class="info"><label><input type="checkbox" name="checkImage[]" id="chkbx" value="<?= $file ?>"> Удалить</label></div>
        </div>
    <?php endforeach; ?>
<?php else :?>
    <p>В галерее отсутствуют файлы для отображения</p>
<?php endif; ?>
