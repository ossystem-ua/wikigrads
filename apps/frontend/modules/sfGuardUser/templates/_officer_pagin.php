<div id="wg-tb-pagin">
        <ul>
            <li><a href="<?php echo $link; ?>/0">|<</a></li>

            <?php if ($options['page'] > 0): ?>
                <li><a href="<?php echo $link; ?>/<?php echo ($options['page'] - 1); ?>"><</a></li>
            <?php endif; ?>

            <?php for ($i = $options['min']; $i < $options['max']; $i++): ?>
                <li><a href="<?php echo $link; ?>/<?php echo $i; ?>">
                    <?php if ($options['page'] == $i): ?>
                        <b><?php echo ($i+1); ?></b>
                    <?php else: ?>
                        <?php echo ($i+1); ?>
                    <?php endif; ?>
                    </a>
                </li>
            <?php endfor; ?>

            <?php if ($options['page'] < ($options['maxpg']-1)): ?>
                <li><a href="<?php echo $link; ?>/<?php echo ($options['page'] + 1); ?>">></a></li>
            <?php endif; ?>

            <li><a href="<?php echo $link; ?>/<?php echo ($options['maxpg']-1); ?>">>|</a></li>
        </ul>
</div>