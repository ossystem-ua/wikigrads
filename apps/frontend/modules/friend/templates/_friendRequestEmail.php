<?php use_helper('I18N', 'Url') ?>
<?php echo __(<<<EOM
<p>
    Hi $user_first_name,
</p>

<p>
$friend_fullname added you as a WikiMate on WikiGrads.  If you confirm $friend_first_name as a WikiMate, he/she will be a member of your study group and will be allowed to download your documents.  
In return, you will be able to download his/her documents.  Only WikiMates are allowed to download each other's documents.
</p>

<p>
To confirm this WikiMate request, follow the link below:
<br/>
%1%
</p>

<p>
Happy collaborating!

<br/>
-Lucas & the WikiGrads team.

</p>
EOM
, 
  array())
//array("%1%" => link_to(url_for("@friend_request_pending_list", true), "@friend_request_pending_list", array("absolute" => true)))) 
        
?>