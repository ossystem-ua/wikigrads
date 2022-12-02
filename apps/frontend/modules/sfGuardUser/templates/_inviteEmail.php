<?php use_helper('I18N', 'Url') ?>
<?php echo __(<<<EOM
<p>
    Hi $to_name,
</p>

<p>
$full_name would like to invite you to join wikigrads.
</p>

<p>
Check out %1% for more details.
</p>

<p>
%2%
</p>

<p>
Happy collaborating!

<br/>
-Lucas & the WikiGrads team.

</p>
EOM
, array(
  "%1%" => link_to(url_for("@homepage", true), "@homepage", array("absolute" => true)),
  "%2%" => empty($message) ? '' : "Message: $message" 
    )   
    
    
) ?>