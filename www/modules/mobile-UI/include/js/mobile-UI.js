/*Personnal JS functions
/Including jquery-mobile global configuration override*/

$(document).bind('mobileinit',function(){
   /*$.mobile.selectmenu.prototype.options.nativeMenu = false;*/ /*ne pas activer sinon le reload sur menus déroulants ne fonctionne plus*/
   $.mobile.page.prototype.options.domCache = false;
   $.mobile.ajaxEnabled = true;
   $.mobile.changePage.defaults.reloadPage = true;
});

function change_src(modif_src)
{
	document.getElementById('graphe_img').src = modif_src;
}

function change_gris()
{
	if(document.getElementById('durer').disabled == true)
	{
		document.getElementById('durer').disabled = false;
	}
	else
	{
		document.getElementById('durer').disabled = true;
	}
}
