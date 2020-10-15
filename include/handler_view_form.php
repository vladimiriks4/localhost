<?php

$uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/upload/';
include($_SERVER['DOCUMENT_ROOT'] . '/include/functions.php');
$req = arrayToString(deleteFile($uploadPath));
?>
<div class="flex-container">
    <?php showFlexElement(); ?>
</div>
<input type="submit" name="deleteImages" id="submit" value="Удалить" />
<div class="clearfix"></div>
<div id="result"><?= $req ?></div>
