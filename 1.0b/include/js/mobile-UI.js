/*Personnal JS functions
/Including jquery-mobile global configuration override
*/
$(document).on('pagehide', function (e) {
    var page = $(e.target);
    if (!$.mobile.page.prototype.options.domCache
        && (!page.attr('data-dom-cache')
            || page.attr('data-dom-cache') == "false")
        ) {
        page.remove();
    }
	
	});

$(document).bind('mobileinit',function(){
   $.mobile.selectmenu.prototype.options.nativeMenu = false;
   $.mobile.page.prototype.options.domCache = false;
   $.mobile.ajaxEnabled = true;
   $.mobile.changePage.defaults.reloadPage = false;
});
