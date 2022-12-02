<div class="wiki-win-button-close"><a onclick="onCloseMathEditor();">&nbsp;</a></div>
<div class="wiki-win-block-content">
    <div class="wiki-win-caption">
        <span class="wiki-win-text">LaTeX Equation Editor</span>
    </div>
    <div class="wiki-win-clear"></div>
    <div class="wiki-win-line"></div>
    <div class="wiki-win-clear"></div>
    <div class="wiki-win-body">
        <div id="editor"></div>
        <textarea id="wiki-math-editor-textarea"></textarea>
        <div id="equation-block"><img id="equation" /></div>
        <a id="wiki-math-ok-button" onclick="fx(<?php echo $id; ?>);">Insert</a>
        <script type="text/javascript" src="/js/math_editor/eq_config.js"></script>
        <script type="text/javascript" src="/js/math_editor/eq_editor-lite-15.js"></script>
        <script type="text/javascript">
            EqEditor.embed('editor','latex','urc,fn|geo,spa,bin,sym,for,sub,acc.ace,arr,rel|ope,bra,gel,geu,mat','en-us');
            var a=new EqTextArea('equation', 'wiki-math-editor-textarea');
            EqEditor.add(a,false);
        </script>
    </div>
</div>
<!--<div class="wiki-win-button-close"><a onclick="onCloseMathEditor();">&nbsp;</a></div>
<div class="wiki-win-block-content">
    <div class="wiki-win-caption">
        <span class="wiki-win-text">LaTeX Equation Editor</span>
    </div>
    <div class="wiki-win-clear"></div>
    <div class="wiki-win-line"></div>
    <div class="wiki-win-clear"></div>
    <div class="wiki-win-body">
        <div id="editor"></div>
        <textarea id="wiki-math-editor-textarea"></textarea>
        <div id="equation-block"><img id="a123" src="" alt=""/></div>
        <a id="wiki-math-ok-button" onclick="fx()">Insert</a>
    </div>
</div>-->

<!--<script type="text/javascript">-->
<!--//    input = document.getElementById('wiki-math-editor-textarea');
//    input.oninput = function() {
////        jQuery("#equation-block").html(input.value);
//        var formula = jQuery("#wiki-math-editor-textarea").val(),
//            url = '/editor/math';
//        jQuery.get(url,{formula: formula}, function(data){
//            console.log(data);
////            jQuery("#a123").attr("src", data);
//            jQuery("#equation-block").html(data);
//        });
////        return false;
//    };-->
<!--</script>-->
<script type="text/javascript">
    jQuery(document).ready(function() {
       jQuery("#wiki-math-editor-textarea").maxEquationLength();
       jQuery();
    });
</script>