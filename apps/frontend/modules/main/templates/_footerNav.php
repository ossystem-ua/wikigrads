<span id="footerrights">WikiGrads &nbsp;&nbsp;&nbsp; all rights reserved</span>
<span id="footlinks">
  <?php foreach($page_links as $page_route => $link_attr):?>
    <span class="footlink"><?php echo link_to(__($link_attr['text']), $page_route, array()) ?></span>
    <?php if( ! isset($link_attr['last'])): ?>
    <span class="link-divider">|</span>
    <?php endif; ?>
  <?php endforeach; ?>
</span>

