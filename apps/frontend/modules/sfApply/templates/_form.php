<div id="wg-form-registration">
    <div class="wg-left-reg-block">
        <div class="wiki-caption-1">
            <?php if ($type == 1): ?>
                <span>Teachers</span>, take a moment and fill out this form to join your students on WikiGrads!
            <?php else: ?>
                <span>Students</span>, take a moment and fill out this form to join your instructors and class-mates on WikiGrads!
            <?php endif; ?>
        </div>
    </div>
    
    <div class="wg-right-reg-block">
        <div class="wiki-form-reg">
            <?php
                $route = "@apply";
                switch($type) {
                    case 0: { $route = "@apply0"; }break;
                    case 1: { $route = "@apply1"; }break;
                }
            ?>
            <!-- registration form start -->
            <?php echo $form->renderFormTag(url_for($route), array('class' => 'global-form-style')); ?>

            <?php echo $form->renderGlobalErrors(); ?>
            <?php echo $form->renderHiddenFields(); ?>
            
            <?php if ($type == 1): ?>
                <div style="display: none;">
                    <?php echo $form['is_staff']->render(array('checked' => 'checked')); ?>
                    <?php echo $form['is_staff']->renderError(); ?>
                </div>
            <?php endif; ?>
            <!-- first name -->
            <div class="wg-reg-fields">
                <?php $defaultval = "First Name"; ?>
                <label class="wg-apply-input"><?php echo $defaultval; ?></label>
                <?php
                    echo $form['first_name']->render(array(
                        'class' => 'default-value',
                        'type' => 'text',
                        'onfocus' => 'formApplyFieldFocus(this);',
                        'onblur' => 'formApplyFieldBlur(this,"'.$defaultval.'");'
                    )); 
                ?>
                <?php echo $form['first_name']->renderError(); ?>
            </div>
            <div class="wg-clear"></div>
            <!-- last name -->
            <div class="wg-reg-fields">
                <?php $defaultval = "Last Name";?>
                <label class="wg-apply-input"><?php echo $defaultval; ?></label>
                <?php
                    echo $form['last_name']->render(array(
                        'class' => 'default-value',
                        'type' => 'text',
                        'onfocus' => 'formApplyFieldFocus(this);',
                        'onblur' => 'formApplyFieldBlur(this,"'.$defaultval.'");'
                    )); 
                ?>
                <?php echo $form['last_name']->renderError(); ?>
            </div>
            <div class="wg-clear"></div>
            <!-- email -->
            <div class="wg-reg-fields">
                <?php $defaultval = "E-Mail"; ?>
                <label class="wg-apply-input"><?php echo $defaultval; ?></label>
                <?php
                    echo $form['email']->render(array(
                        'class' => '',
                        'type' => 'text',
                        'onfocus' => 'formApplyFieldFocus(this);',
                        'onblur' => 'formApplyFieldBlur(this,"'.$defaultval.'");'
                    )); 
                ?>
                <?php echo $form['email']->renderError(); ?>
            </div>
            <div class="wg-clear"></div>
            <!-- password -->
            <div class="wg-reg-fields">
                <?php $defaultval = "Password (6 characters or more)"; ?>
                <label class="wg-apply-input"><?php echo $defaultval; ?></label>
                <?php
                    echo $form['password']->render(array(
                        'class' => '',
                        'type' => 'password',
                        'id' => 'wg-password',
                        'onfocus' => 'formApplyFieldFocus(this);',
                        'onblur' => 'formApplyFieldBlur(this,"'.$defaultval.'");'
                    )); 
                ?>
                <?php echo $form['password']->renderError(); ?>
            </div>
            <div class="wg-clear"></div>
            <!-- confirm password -->
            <div class="wg-reg-fields">
                <?php $defaultval = "Confirm password"; ?>
                <label class="wg-apply-input"><?php echo $defaultval; ?></label>
                <?php
                    echo $form['password2']->render(array(
                        'class' => '',
                        'type' => 'password',
                        'id' => 'wg-password-confirm',
                        'onfocus' => 'formApplyFieldFocus(this);',
                        'onblur' => 'formApplyFieldBlur(this,"'.$defaultval.'");'
                    )); 
                ?>
            </div>
            <div class="wg-clear"></div>
            <!--  -->
            <div class="wg-reg-fields wiki-block custom-select">
                <?php 
                    echo $form['school_id']->render(array(
                        'data-action' => url_for('@update_school_department_dropdown'),
                        'class' => ''
                    )); 
                ?>
            </div>
            <?php echo $form['school_id']->renderError(); ?>
            <div class="wg-clear"></div>

            <?php if ($type == 1): ?>
            <div class="wg-reg-fields">
                <?php $defaultval = "Subject/Department Name, e.g. Chemistry"; ?>
                <label class="wg-apply-input"><?php echo $defaultval; ?></label>
                <?php
                    echo $departmentForm['name']->render(array(
                        'class' => '',
                        'onfocus' => 'formApplyFieldFocus(this);',
                        'onblur' => 'formApplyFieldBlur(this,"'.$defaultval.'");'
                    )); 
                ?>
            </div>
            <div class="wg-clear"></div>
            
            <div class="wg-reg-fields">
                <?php $defaultval = "Subject Code, e.g. ENGL"; ?>
                <label class="wg-apply-input"><?php echo $defaultval; ?></label>
                <?php
                    echo $departmentForm['alias']->render(array(
                        'class' => 'default-value',
                        'onfocus' => 'formApplyFieldFocus(this);',
                        'onblur' => 'formApplyFieldBlur(this,"'.$defaultval.'");'
                    )); 
                ?>
            </div>
            <div class="wg-clear"></div>
            
            <div class="wg-reg-fields">
                <?php $defaultval = "Course Number, e.g. 121"; ?>
                <label class="wg-apply-input"><?php echo $defaultval; ?></label>
                <?php
                    echo $courseForm['code']->render(array(
                        'class' => 'default-value',
                        'onfocus' => 'formApplyFieldFocus(this);',
                        'onblur' => 'formApplyFieldBlur(this,"'.$defaultval.'");'
                    )); 
                ?>
            </div>
            <div class="wg-clear"></div>
            
            <div class="wg-reg-fields">
                <?php $defaultval = "Course Title"; ?>
                <label class="wg-apply-input"><?php echo $defaultval; ?></label>
                <?php
                    echo $courseForm['name']->render(array(
                        'class' => '',
                        'onfocus' => 'formApplyFieldFocus(this);',
                        'onblur' => 'formApplyFieldBlur(this,"'.$defaultval.'");'
                    )); 
                ?>
            </div>
            <div class="wg-clear"></div>
            <?php endif; ?>

            <?php if ($type == 0): ?>
            <div class="wg-reg-fields custom-select">
                <?php echo $form['class_year']->render(array(
                    'id' => 'class_year',
                    'class' => ''
                )); ?>                
            </div>
            <div class="wg-clear"></div>
            
            <?php echo $form['class_year']->renderError(); ?>
            <div class="wg-reg-fields">
                <?php if(isset($form['major'])):?>
                    <?php $defaultval = 'Major'; ?>
                    <label class="wg-apply-input"><?php echo $defaultval; ?></label>
                    <?php
                        echo $form['major']->render(array(
                            'class' => '' . ($form['major']->hasError() ? '' : ''),
                            'type' => 'text',
                            'onfocus' => 'formApplyFieldFocus(this);',
                            'onblur' => 'formApplyFieldBlur(this,"'.$defaultval.'");'
                        )); 
                    ?>
                    <?php echo $form['major']->renderError(); ?>
                <?php endif;?>
            </div>
            <div class="wg-clear"></div>
            <?php endif;?>
            <div class="wiki-submit-create">
                <a href="" OnClick="onSubmitForm('#createaccount'); return false;">Create your account</a>
            </div>
            <input type=image value="Submit" src="<?php echo image_path("empty.png"); ?>" id="createaccount" class="create-account" />
        </div>
    </div>
    <div class="wg-clear"></div>
</div>