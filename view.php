<?php

$uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/upload/';
include($_SERVER['DOCUMENT_ROOT'] . '/include/functions.php');
?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/template/header.php'); ?>
<form action="/include/handler_view_form.php" method="POST" id="viewForm">
    <div id="load">
        <div class="flex-container">
            <?php showFlexElement(); ?>
        </div>
        <input type="submit" name="deleteImages" id="submit" value="Удалить"/>
        <div class="clearfix"></div>
        <div id="result"></div>
    </div>
</form>

<script src="/include/view_form.js"></script>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/template/footer.php'); ?>
