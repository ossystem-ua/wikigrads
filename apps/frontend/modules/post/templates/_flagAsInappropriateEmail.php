<?php use_helper('I18N', 'Url') ?>
<?php echo __(<<<EOM
<p>
    Hi $recipientFirstName (WikiGrads moderator),
</p>

<p>
    $notifierFullName has flagged the following $postType as inappropriate:
</p>

<p>
    <div>
        ----------
    </div>
    <div>
        Course: $courseDepartmentAndCode
    </div>
    <div>
        Posted by: $postOwnerFullName
    </div>
    <div>
        Date: $postDate
    </div>
    <br />
    <div>
        $postContent
    </div>
    <br />
    <div>
        ----------
    </div>
</p>

<p>
    To check the flagged $postType, follow the link below:
    <br />
    %1%
</p>

<p>
    Happy collaborating!
    <br />
    -Lucas &amp; the WikiGrads team.
</p>
EOM
, array(
    "%1%" => link_to(url_for("@homepage", true), "@homepage", array("absolute" => true))
    )
) ?>