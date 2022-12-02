<?php use_helper('I18N', 'Url') ?>
<?php echo __(<<<EOM
<p>
    Hi $first_name $last_name,
</p>	
<p> 
    Welcome to WikiGrads, a social learning platform for higher education that facilitates student engagement, peer mentoring, and active learning. Specifically, the platform:	
</p>
<ul>
    <li>Generates a private, interactive feed for any university course using familiar social media tools</li>
    <li>Organizes all questions, discussions, communications, blogs, and documents/photos continuously over time in one convenient location</li>
</ul> 
<p>        
    To prevent abuse of the site, we require that you activate your account by clicking on the following link:  %1%	
</p>  
<p>
    Engage, collaborate, and learn!	
</p>        
<p>  
    ‐ Lucas & the WikiGrads team	
</p>    
EOM
, array(
  "%1%" => link_to(url_for("sfApply/confirm?validate=$validate", true), "sfApply/confirm?validate=$validate", array("absolute" => true)))) ?>
