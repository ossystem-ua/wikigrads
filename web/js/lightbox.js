/* zoom any image
 * widget by IonDen
 * v 2.3
 * 02.06.2010
 * rev. 55
 * depends on jQuery 1.4
 * UTF-8
 */
(function($){
    $("a.zoom").live("click", function(event) {
        var object= this;
        event.preventDefault();
//return false;
        var winZoom = $('#idZoomWindow');
        if (winZoom) {
            var screenWidth  = $(window).width();
            var screenHeight = $(window).height() - 60;
            var url = $(object).attr('href');
            if (winZoom.css('display') == 'block') {
                winZoom.css('display', 'none');
                winZoom.html('');
            } else {
                
                var img = new Image();
                img.src = url;
                img.onload = function() {
                    
                    var winWidth = img.width,
                        winHeight = img.height;
                
                    if (winWidth > screenWidth)
                        winWidth = screenWidth - ((screenWidth/100)*10);
                    
                    if (winHeight > (screenHeight-10))
                        winHeight = (screenHeight-10);
                          
                    winZoom.html('<a id="zoomImage" class="href-cursor"><img src="' + url + '" style="width:' + winWidth + 'px; height:' + winHeight + 'px;" /></a>');
                    winZoom.css('display', 'block');
                                        
                    //var top = -(winHeight / 2)-4;
                    //var left = -(winWidth / 2);                    
                    //left = -((screenWidth - winWidth) / 2);
                    
                    var top  = (screenHeight - winHeight) / 2;
                    var left = (screenWidth - winWidth) / 2;                    

                    winZoom.css('left', '' + left + 'px');
                    winZoom.css('top',  '' + top + 'px');
                };
            }
        }
    });
    
    $('a#zoomImage img').live("click", function(event){ 
        var winZoom = $('#idZoomWindow');
        if (winZoom) {
            winZoom.css('display', 'none');
            winZoom.html('');
        }
    });
    
})(jQuery);