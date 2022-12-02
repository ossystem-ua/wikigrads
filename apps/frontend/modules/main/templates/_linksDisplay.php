<ul>
    <?php foreach($page_links as $page_route => $link_attr):?>
    <li><?php echo link_to(__($link_attr['text']), $page_route, array()) ?></li>
    <?php endforeach; ?>
</ul>