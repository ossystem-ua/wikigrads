<?php use_helper('I18N', 'Url') ?>
<?php echo __(<<<EOM
<p>
    Hi $user_first_name,
</p>

<p>
%1% has uploaded a document to %2%.   If you are WikiMates with %1%, you can download the file directly by clicking the link below: <br/>
%3%
</p>

<p>
If you are not WikiMates, you can send a WikiMates request by clicking the link below:<br/>

%4%
</p>


<p>
Happy collaborating!

<br/>
-Lucas & the WikiGrads team.

</p>
EOM
, array(
    "%1%" => $document->getUser()->getFirstName(),
    "%2%" => $document->getCourse()->getShortName(),
    "%3%" => url_for('@document_download?slug='.$document->getId().'|'.Utils::slugify($document->getName()), true),
    "%4%" => url_for('@user?id='.$document->getUserId().'&name='.Utils::slugify($document->getUser()->getName()) , true)
)) ?>
