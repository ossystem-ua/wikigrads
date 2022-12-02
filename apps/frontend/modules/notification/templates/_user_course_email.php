<?php use_helper('I18N', 'Url') ?>
<?php echo __(<<<EOM
<p>
    Hi $user_first_name,
</p>

<p>
%1% is looking for WikiMates in %2%.
Send a WikiMates request and start sharing class document by clicking the link below:
</p>

<p>
%3%
</p>

<p>
Happy collaborating!

<br/>
-Lucas & the WikiGrads team.

</p>
EOM
, array(
    "%1%" => $userCourse->getUser()->getName(),
    "%2%" => $userCourse->getCourse()->getShortName(),
    "%3%" => url_for('@user?id='.$userCourse->getUserId().'&name='.Utils::slugify($userCourse->getUser()->getName()) , true)
)) ?>
