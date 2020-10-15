<ul class="main-menu">
    <?php foreach ($items as $item) :?>
        <li class="<?= checkItem($item['path']) ? 'current-item' : '' ?>">
        	<a href="<?= $item['path'] ?>"><?= $item['title'] ?></a>
        </li>
    <?php endforeach;?>
</ul>
