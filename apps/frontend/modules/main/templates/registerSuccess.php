<form action="<?php url_for('@register'); ?>" method="POST">
<ul>
	<li>
		<?php echo $registerForm['first_name']->getError(); ?>
		<?php echo $registerForm['first_name']->getLabel(); ?>
		<?php echo $registerForm['first_name']->getField(); ?>
	</li>
	<li>
		<?php echo $registerForm['last_name']->getError(); ?>
		<?php echo $registerForm['last_name']->getLabel(); ?>
		<?php echo $registerForm['last_name']->getField(); ?>
	</li>
</ul>
</form>

