<?php if ($pager) : ?>
    <div id="pager-container">
    
    <?php if (isset($results) && $results === true) : ?>
        <div class="pager-results">
            <?php echo $pager->getNbResults().' Result'.($pager->getNbResults() != 1 ? 's' : '') ?>
        </div>
    <?php endif; ?>
    
    <?php if ($pager->haveToPaginate()) : ?>
        <ul class="pager">
            <li></li>
                        
            <?php #rewrite the uri based on if there is a page variable found in the url; if there is one; remove it so it does not get duplicated ?>
            <?php $uri = preg_replace('#(\?|&)page.*?\d+#', '', isset($url) && $url ? html_entity_decode($url) : html_entity_decode($sf_request->getUri())) ?>
            
            <?php #add the page variable depending if there are any other request variables in the url ?>
            <?php $page_name = preg_match('#\?#', $uri) == true ? '&page=' : '?page='; ?>
            
            <?php if ($pager->getPage() != $pager->getFirstPage()) : ?>
                <li class="pager-first">
                    <?php echo link_to('first', $uri.$page_name.$pager->getFirstPage()) ?>                    
                </li>
            <?php endif; ?>
            
            <?php if ($pager->getPage() != $pager->getPreviousPage()) : ?>
                <li class="pager-previous">
                    <?php echo link_to('prev', $uri.$page_name.$pager->getPreviousPage()) ?>
                </li>
            <?php endif; ?>
        
            <?php foreach ($pager->getLinks('5') as $page) : ?>
                <?php if ($page == $pager->getPage()) : ?>
                    <li class="pager-current">
                        <?php echo $page ?>
                    </li>
                <?php else : ?>
                    <li>
                        <?php echo link_to($page, $uri.$page_name.$page) ?>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
            
            <?php if ($pager->getPage() != $pager->getNextPage()) : ?>
                <li class="pager-next">
                    <?php echo link_to('next', $uri.$page_name.$pager->getNextPage(), array('class'=>'pager-nextxx')) ?>
                </li>
            <?php endif; ?>
            
            <?php if ($pager->getPage() != $pager->getLastPage()) : ?>
                <li class="pager-last">
                    <?php echo link_to('last', $uri.$page_name.$pager->getLastPage()) ?>
                </li>
            <?php endif; ?>
        </ul>
    <?php endif; ?>
        <div class="clear"></div>
    </div>
<?php endif; ?>