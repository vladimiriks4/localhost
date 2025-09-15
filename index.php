<?php

$uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/upload/';
if (!file_exists($uploadPath)){
    mkdir($uploadPath, 0777);
}

include($_SERVER['DOCUMENT_ROOT'] . '/include/functions.php');
include($_SERVER['DOCUMENT_ROOT'] . '/template/header.php');
?>

<div class="upload-block">
    <form enctype="multipart/form-data" action="/include/handler_upload_form.php" method="POST" id="upl-form">
        <ul>
        	<li><span>Загрузка изображений с расширением: 'jpeg', 'png', 'jpg'. </span></li>
            <li><span>Загрузите не более 5 файлов размером не более 5Mb каждый: </span></li>
            <li><input type="file" name="myFile[]" id="my-file" multiple accept="image/jpeg,image/png"/></li>
            <li><input type="submit" name="upload" id="submit" value="Загрузить"/></li>
        </ul>
    </form>
</div>
<div id="result"></div>

<script src="/include/upload_form.js"></script>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/template/footer.php'); ?>
