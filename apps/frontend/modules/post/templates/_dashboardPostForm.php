<!--generating tag <FORM>-->
<?php echo $form->renderFormTag(url_for('@process_dashboard_post_form'), array(
    'id' => 'dashboard-post-form',
)) ?>
<div class="wg-post-row-1">
    <div class="wg-post-col-1">
        <div class="wiki-inline wiki-left wiki-form-block-upload">
            <div class="wiki-upload-block wg-upload-document">
                <div class="wiki-inline">
                    <a class="tooltip4" title="Upload document" OnClick="showUploadDocument()">Document</a>
                </div>
            </div>
            <div class="wiki-equation-block">
                <a id="wiki-fx" class="tooltip4" title="Equation editor" onclick="javascript:OpenLatexEditor(0)">Equation editor</a>
            </div>
            <div class="wiki-upload-block wg-upload-link-video">
                <a class="tooltip4" title=" Add link/video" onclick="showLinkRow();">Link/video</a>
            </div>
            <div class="wiki-upload-block wg-upload-photo">
                <div class="wiki-inline">
                    <a class="tooltip4" title="Upload photo" OnClick="showUploadImage();">Photo</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="wg-post-row-2">
<div class="wg-post-col-1">
    <?php if (isset($profile)): ?>
        <?php echo (image_tag($profile->getThumbnailImagePath(100, 100), array('class' => 'wg-form-logo'))); ?>
    <?php endif; ?>
</div>

<div class="wg-post-col-2">


    <?php echo $form->renderGlobalErrors() ?>
    <?php echo $form->renderHiddenFields() ?>
    <?php echo $form['content']->renderError() ?>

    <div class="wg-post-row-1 wg-area-post">
        <span class="wg-required-2" id="wg-dash-form"></span>
        <input type="hidden" id="scrape_url_address" value="<?php echo url_for("@notification_scrape_url"); ?>"/>
        <?php echo $form['content']->render() ?>
    </div>
    <div class="wiki-upload-document" style="display: none;">
        <?php echo image_tag('new_design/wiki-close.png', array('id' => 'clear-document-data',
                                                                'onclick' => 'deleteDocument()',
                                                                'style' => 'float: right;')); ?>
        <table class="wiki-doc-uptbl">
            <tr>
                <td>
                <div class="wiki-win-block-right">
                    <div id="wiki-button-load-doc" class="wiki-win-preview wiki-win-preview-document href-cursor">
                    Preview
                    </div>
                </div>
                </td>
                <td>
                    <input id="wiki-doc-inp" type="text" def-value="Document name" value="Document name" maxlength="50"/>
                    <!--<textarea id="wiki-doc-txt" def-value="Brief description">Brief description</textarea>-->
                    <div class="wiki-center-button">
                        <div class="wiki-win-btup wiki-inline">
                            <a id="wiki-button-text-image" onclick="onUploadDoc(this);">Upload</a>
                        </div>
                        <div class="wiki-win-btcl wiki-inline">
                            <a onclick="deleteDocument();">Cancel</a>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="wiki-upload-image" style="display: none;">
        <?php echo image_tag('new_design/wiki-close.png', array('id' => 'clear-image-data',
                                                                'onclick' => 'deleteImage()',
                                                                'style' => 'float: right;')); ?>
        <div class="wiki-win-block-center">
            <div id="wiki-button-load-image" class="wiki-win-preview wiki-win-preview-image href-cursor">Preview</div>
        </div>
        <div class="wiki-center">
            <div class="loader"></div>
        </div>
    </div>
<!--    <div id="equation-field"  style="display: none;">
        <?php echo image_tag('new_design/wiki-close.png', array('id' => 'delete-equation',
                                                                'onclick' => 'deleteEquation(0)')); ?>
        <div id="wg-show-equation-post" style="display: none;"></div>
    </div>
    <span id="wg-equation-text"></span>-->
    <div class="add-link" style="display: none;">
        <span>Link:</span>
        <input id="link-data" type="text" name="add-link" placeholder="Paste or enter a link" maxlength="255"/>
    </div>
    <div id="site-information" style="display:none;">
        <?php echo image_tag('new_design/wiki-close.png', array('id' => 'close-link-data')); ?>
        <div id="si-images"></div>
        <span id="si-title"></span><br/>
        <span id="si-description"></span><br/>
        <span id="si-link"><a href="" target="_blank"></a></span>
        <div id="si-image-rotator">
            <div class="prev">&#9668;</div>
            <div class="next">&#9658;</div>
            <div class="info"></div><br/>
        </div>
        <div class="chkbox"><input id="disable-image" name="dsbl-img" type="checkbox"/><label class="chkboxlabel" for="dsbl-img">without thumbnail</label></div>
        <div style="clear: both;"></div>
    </div>

    <div class="wg-post-row-2" style="clear: left;">
        <div class="wiki-inline wiki-right wiki-form-block-pin">
            <?php if($isStaff || $sf_user->getGuardUser()->getIsOfficer() == 1) : ?>
                <?php echo $form['is_pinned']->render() ?>
                <label id="pin" for="post_is_pinned">Pin this post to top</label>
            <?php endif; ?>
        </div>
    </div>

    <div class="wg-post-row-3 wiki-right">
        <a id="wg-post-button" class="tooltip3 href-cursor" title="Post">Post</a>
    </div>

    <div style="display: none;">
        <?php echo $form['course_id']->render() ?>
        <?php echo $form['type']->render() ?>
        <?php echo $form['everyone']->render() ?>
        <?php echo $form['attachment_id']->render() ?>
        <?php echo $form['document_id']->render(array('id' => 'result-doc-id')) ?>
        <?php echo $form['attachment_url']->render() ?>
        <?php if (isset($studentId)): ?>
            <input type="hidden" name="studentId" value="<?php echo $studentId; ?>"/>
        <?php endif; ?>
        <input type="hidden" name="_dontcare"/>
        <input type='hidden' id='tmp_course_id' value='0' />
        <input type="image" src="<?php echo image_path('btn-post-comment-ask.png') ?>" id="form-sumit-ask" />
    </div>

    </form>
</div>
</div>
<div style="display: none;">
    <form name="hiddeFormLoadImage" id="hiddeFormLoadImage" action="upload.php" method="post" enctype="multipart/form-data">
        <input name="files" id="files" type="file" accept="image/*" />
        <input type="reset" id="hiddeFormClearImage"/>
    </form>
    <form name="hiddeFormLoadDoc" id="hiddeFormLoadDoc" action="<? echo url_for('@useruploaddoc') ?>" method="post" enctype="multipart/form-data">
        <input name="file" id="docs" type="file" />
        <input type="text" id="doc-course-id" name="course_id" />
        <input type="text" id="doc-name" name="name" />
        <textarea id="doc-desciption" name="description"></textarea>
        <input type="reset" id="hiddeFormClearDoc"/>
    </form>
</div>
