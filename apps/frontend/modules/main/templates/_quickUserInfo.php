<div id="quick-user-info">

	<div id="qui-heading">
		<span class="name"><?php echo link_to($user->getName(),'@dashboard') ?></span>
        <?php $togarw_btn_class = ($expanded) ? 'togarw-up-drk' : 'togarw-dn-drk'; ?>
    	<div class="btn-toggle-container"><a href="#" id="collapse-qui-detail" class="<?php echo $togarw_btn_class ?>"></a></div>
	</div>

	<div id="qui-detail"<?php if( ! $expanded) echo ' class="display-none"' ?>>
		<div id="lnavuserimage">
			<?php echo image_tag($user->getThumbnailImagePath(250, 250));?>
		</div>

		<div id="userbio">
		   
			<?php foreach ($user->getUserSchool() as $school_link): ?>
				<ul>
					<li>School: <?php echo $school_link->getSchool()->getName(); ?></li>
					<li>Class: <?php echo $school_link->getClassYear() ? ' '.$school_link->getClassYear() : '' ?></li>
					
					<?php if ($school_link->getMajorOrPrimaryDepartmentName()): ?>
						<li>Major: <?php echo $school_link->getMajorOrPrimaryDepartmentName(); ?></li>
					<?php endif; ?>	
				</ul>
			<?php endforeach; ?>                    
		</div>
	</div>
</div>