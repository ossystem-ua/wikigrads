
<div class="sfTMessageContainer sfTAlert"> 
  <div class="sfTMessageWrap">
    <h3>Oops! Page Not Found. </h3>
    <h5>The server returned a 404 response.</h5>
  </div>
</div>
<dl class="sfTMessageInfo">
  <dt>Did you type the URL?</dt>
  <dd>You may have typed the address (URL) incorrectly. Check it to make sure you've got the exact right spelling, capitalization, etc.</dd>

  <dt>What's next</dt>
  <dd>
    <ul class="sfTIconList">
      <li class="sfTLinkMessage"><a href="javascript:history.go(-1)">Back to previous page</a></li>
      <li class="sfTLinkMessage"><?php echo link_to('Go to Homepage', '@homepage') ?></li>
    </ul>
  </dd>
</dl>
