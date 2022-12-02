<H1>Please take a moment and fill out this form to join your classmates at WikiGrads!</H1>

    <?php echo $form->renderFormTag(url_for('@apply'), array('class' => 'global-form-style')); ?>
    
	<?php echo $form->renderGlobalErrors(); ?>
	<?php echo $form->renderHiddenFields(); ?>


        <div class="apply-field">
            <div id="applyfirst" class="grey-input">
                <?php echo $form['first_name']->render(array(
                    'class' => 'default-value '.($form['first_name']->hasError() ? ' form-error' : '')
                )); ?>  
            </div>
            <?php echo $form['first_name']->renderError(); ?>

        </div>

        <div class="apply-field">
            <div id="apply-last-name" class="grey-input">
                <?php echo $form['last_name']->render(array(
                'class' => 'default-value '.($form['last_name']->hasError() ? 'form-error' : '')
                )); ?>    
            </div>
             <?php echo $form['last_name']->renderError(); ?>
        </div>

        <div class="apply-field">
            <div id="applyemail" class="grey-input">
                <?php echo $form['email']->render(array(
                        'class' => 'default-value '.($form['email']->hasError() ? 'form-error' : '')
                )); ?>

            </div>
            <?php echo $form['email']->renderError(); ?>
        </div>


	<div id="applyschool" class="styled-select">
            <?php echo $form['school_id']->render(array(
                'data-action' => url_for('@update_school_department_dropdown')
            )); ?>
            <?php echo $form['school_id']->renderError(); ?>
	</div>
        
        <div style="clear: both; margin: 0px;"></div>
         
        <div class="apply-field">
            <div id="applypass" class="grey-input">
                <?php
                        $defaultval = "Password";
                        echo $form['password']->render(array(
                        'class' => $form['password']->hasError() ? 'form-error' : '',
                        'value' => 'Password',
                        'type' => 'text',
                        'onfocus' => 'formFieldFocus(this,"'.$defaultval.'",1)',
                        'onblur' => 'formFieldBlur(this,"'.$defaultval.'",1)'
                )); ?>
                    
            </div>
            <?php echo $form['password']->renderError(); ?>
        </div>            

        <div class="apply-field">
            <div id="applypass2" class="grey-input">
                <?php
                        $defaultval = "Retype Password";
                        echo $form['password2']->render(array(
                        'class' => $form['password2']->hasError() ? 'form-error' : '',
                        'value' => 'Retype Password',
                        'type' => 'text',
                        'onfocus' => 'formFieldFocus(this,"'.$defaultval.'",1)',
                        'onblur' => 'formFieldBlur(this,"'.$defaultval.'",1)'
                )); ?>                
            </div>
        </div>
        
        <div style="clear: both; margin: 0px;"></div>

        <div class="apply-field">
            <div id="applystaff">
                <?php echo $form['is_staff']->renderLabel('Are you a professor or TA?'); ?>
                <?php echo $form['is_staff']->render(array()); ?>
                <?php echo $form['is_staff']->renderError(); ?>  
            </div>
        </div>  
        
        <div id="apply-graduation-info" style="display: <?php echo $show_graduation_info_fields ? 'block' : 'none'?>">        
            <div id="applymajor" class="grey-input">
                <?php if(isset($form['major'])):?>
                    <?php
                    $defaultval = 'Major';
                    echo $form['major']->render(array(
                        'class' => $form['major']->hasError() ? 'form-error' : '',
                        'value' => 'Major',
                        'type' => 'text',
                        'onfocus' => 'formFieldFocus(this,"'.$defaultval.'",0)',
                        'onblur' => 'formFieldBlur(this,"'.$defaultval.'",0)',
                    )); ?>
                    <?php echo $form['major']->renderError(); ?>
                <?php else:?>
                <?php endif;?>
            </div>

            <div id="applyclassyear" class="styled-select">
                <?php echo $form['class_year']->render(array(
                    'id' => 'class_year'
                )); ?>
                <?php echo $form['class_year']->renderError(); ?>
            </div>
        </div>
        
        <div style="clear: both; margin: 0px;"></div>

	<div id="applysubmit">
            <input type=image value="Submit" src="<?php echo image_path("btn-createaccount.png"); ?>" id="createaccount" />
	</div>

    </form>

