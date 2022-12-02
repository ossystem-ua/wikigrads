<nav>
    <?php if ($menu) : ?>
        <ul>
    	
        <?php foreach ($menu as $label => $route) : ?>
    	   
            <li><?php echo link_to($label, $route) ?></li>
        
    	<?php endforeach; ?>
    	
    	</ul>
    <?php endif; ?>
</nav>