<?php if ($sf_user->getGuardUser() instanceof sfOutputEscaper) : ?>
    <?php $sf_guard_user = $sf_user->getGuardUser()->getRawValue() ?>
<?php else : ?>
    <?php $sf_guard_user = $sf_user->getGuardUser(); ?>
<?php endif; ?>

<?php if($document->getUser() instanceof sfOutputEscaper) :?>
    <?php $friend = $document->getUser()->getRawValue(); ?>
<?php else: ?>
    <?php $friend = $document->getUser();?>
<?php endif; ?>
<?php
    $user_class = "wg-student";
    $icon_file  = "new_design/wiki-file-1.png";
    if($friend->getProfile()->getIsStaff() == 1) {
        $user_class = "wg-instructor";
        $icon_file  = "new_design/wiki-file-2.png";
    }
?>

<div class="wg-post-block wiki-block-document">

    <div>
        <table class="wiki-doc-table"><tr><td class="wiki-doc-ticon"><?php echo image_tag($icon_file); ?></td><td>
        <!-- document name -->
        <div class="wiki-doc-name">
            <?php echo $document->getName(); ?>
        </div>

        <!-- document description -->
        <div class="wiki-doc-description">
            <?php echo $document->getDescription() ?>
        </div>

        <div class="wiki-float-row"></div>

        <div class="wiki-doc-block">
            <!-- document download -->
            <div class="wiki-doc-upload-img">
            <?php
                $name = $document->getName();
                if (strpos($name, 'document_name', 0) !== false) {
                    //$name = 'upload doc '.$document->getId();
                }
                echo link_to($name,
                    '@document_download?slug='.$document->getId().'|'.Utils::slugify($document->getName(),
                     array(
                         'class' => 'wiki-doc-upload'
                     )) );?>
            </div>
            <div class="wiki-doc-clickdw">
                Click to download
            </div>
        </div>

        <div class="wiki-float-row"></div>

        <div class="wiki-doc-user-block">
            <div class="wiki-doc-col wiki-doc-avatar <?php echo $user_class; ?>">
                <!-- avatar -->
                <?php echo link_to(image_tag($friend->getThumbnailImagePath(50, 50)), '@user?id='.$friend->getId().'&name='.Utils::slugify($friend->getName()))?>
            </div>
            <div class="wiki-doc-col">
                <div class="wiki-doc-username">
                    <?php
                        if ($friend->getProfile()->getIsStaff() == 1 || $friend->getProfile()->getIsTutor() == 1):
                            $user_name = $document->getUser()->getFirstName()." ".$document->getUser()->getLastName();
                        else:
                            $user_name = $document->getUser()->getFirstName()." ".substr($document->getUser()->getLastName(),0,1);
                        endif;
                    ?>
                    Uploaded by
                    <span class="<?php echo $user_class; ?>">
                        <?php if ( $document->getUser()->getName()): ?>
                            <?php echo link_to($user_name, '@user?id='.$friend->getId().'&name='.Utils::slugify($friend->getName()))?>
                        <?php else: ?>
                            <span class="sys-msg">user was deleted</span>
                        <?php endif ?>
                    </span>
                    in
                    <span class="wiki-doc-shotname"><?php echo $document->getCourse()->getShortName()." "; ?></span>
                </div>
                <div class="wiki-doc-date">
                    <!-- date posted -->
                    <!--<?php echo formatDatetime(strtotime($document->getDate()), null, isset($timezone) ? $timezone : null);?>-->
                    <?php echo formatDatetime($document->getDate(), null, isset($timezone) ? $timezone : null); ?>
                </div>
            </div>
        </div>
    </td></tr></table>
    </div>
</div>
<div class="wiki-float-row"></div>
