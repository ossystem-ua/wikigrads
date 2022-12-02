/*
    AutoPager
    init():
        'list_container': provide the id of the container that will be appended to. the action called should return the next page in the list, 
          ALSO wrapped in this container (just as if they hit the 'more' link and a new page load took place). 
          The autopager will extract the list items from the returned html returned via ajax, so no need to worry about nested list_containers.
    addCallback(): 
        method to add a function that will be called AFTER the autopager has retrieved a page of data via ajax. You can load as many methods up as you
        wish. they will be executed in the order added.
        Note that if the method must be executed AFTER being returned, pass it in as a string and it will be eval()'d. Otherwise if it is an function
          it will be call()'d.
    Notes:
        - for the link that loads the next page of data, wrap it in <div id="autopager"...
        - only place one 'more' link in the autopager wrapper... the href of this link is used to retrieve the next page of data
    Author: bmiller
*/

AutoPager = {
  
    init: function(list_container) {
        var ajax_loading = $("<div class='loading'><img src='../../images/ajax-loader.gif' /></div>");
        var autopager = $('#autopager');
        var opts = {offset: '100%'};
        
        autopager.waypoint(function(event, direction) {
            autopager.waypoint('remove');
            var href = autopager.children('a').attr('href');     //alert(href);
            if( ! href) { return; }
            
            autopager.html(ajax_loading);
            
            $.ajax({
                url: href,
                dataType: "html",
                data: {pager: true},
                success: function(data, textStatus, XMLHttpRequest) {
                    autopager.remove(); // autopager is present in new data
                        // extract the returned list item html (list items should be nested in list_container in returned html)
                    var ele = $(data).filter(list_container).get(0);
                    var html = $(ele).html();
                                 
                    $(list_container).append(html);
                    
                    // now the html may or may not contain another 'more' link - if it does then set the new waypoint.
                    AutoPager.init(list_container);
                    AutoPager.execCallbacks();
                }
            });   
        }, opts);
    },
    
    // CALLBACKS
    callbacks: [],
    addCallback: function(f) {
        AutoPager.callbacks.push(f);
    },
    execCallbacks: function() {
        for(i=0;i<AutoPager.callbacks.length;i++) {
            if(typeof AutoPager.callbacks[i] == 'string') {
                eval(AutoPager.callbacks[i]);
            } else {
                AutoPager.callbacks[i].call();
            }
        }    
    }
    
}