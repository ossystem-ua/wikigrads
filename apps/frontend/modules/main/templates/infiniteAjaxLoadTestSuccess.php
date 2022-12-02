<style>
p {
    margin:8px 0 50px 0;
}

.article {
    padding:16px 0;
    border-top:1px solid #ddd;
}
</style>
<div class="content-pad">
    <textarea id="devdump" style="width:100%; height:200px"></textarea>
    <h1>TEST</h1>
    
    <div id="list-container">
<?php foreach($pager as $p): ?>
        <div class="article">
            <p><?php echo $p->content ?></p>
        </div>
<?php endforeach; ?>
    </div>
    
    <?php include_partial('global/pager', array('pager' => $pager, 'results' => true)); ?>
    <div id="btm-scroll-detector"></div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    AutoPaginate.init('#list-container', '#pager-container', '.pager-next', '.article');
    
    /*
    var $loading = $("<div class='loading'><img src='images/ajax-loader.gif' /></div>");
    $target = $('#pager-container');
    opts = {
        offset: '100%'
    };

    $target.waypoint(function(event, direction) {
        $target.waypoint('remove');
        $('#my-list').append($loading);

        var pagerNext = $('.pager-next a');
        if( ! pagerNext.length) {
            alert('no more data');
            return;
        }
        
        $.get(pagerNext.attr('href'), function(data) {
            $('#devdump').val(data + "=================================================\n");
            
            var $data = $(data);
            $('#my-list').append($data.find('.article'));
            $loading.detach();
            //$('.more').replaceWith($data.find('.more'));
            $('.pager-next').replaceWith($data.find('.pager-next'));
            $target.waypoint(opts);
        });
    }, opts);
    */
});

</script>