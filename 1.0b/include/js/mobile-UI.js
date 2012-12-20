/*Personnal JS functions
/Including jquery-mobile global configuration override

$(document).bind('mobileinit',function(){
   /*$.mobile.selectmenu.prototype.options.nativeMenu = false;*/ /*ne pas activer sinon le reload sur menus déroulants ne fonctionne plus*/
   $.mobile.page.prototype.options.domCache = false;
   $.mobile.ajaxEnabled = true;
   $.mobile.changePage.defaults.reloadPage = true;
});
