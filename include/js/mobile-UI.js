/*Personnal JS functions
/Including jquery-mobile global configuration override*/

$(document).bind('mobileinit',function(){
   /*$.mobile.selectmenu.prototype.options.nativeMenu = false;*/ /*ne pas activer sinon le reload sur menus déroulants ne fonctionne plus*/
   $.mobile.page.prototype.options.domCache = false;
   $.mobile.ajaxEnabled = true;
   $.mobile.changePage.defaults.reloadPage = true;
});

function affiche_jour(id){
	document.getElementById('graphe_img_jour').style.display='block';
	}
function affiche_mois(id){
	document.getElementById('graphe_img_mois').style.display='block';
	}
function affiche_an(id){
	document.getElementById('graphe_img_an').style.display='block';
	}
function cache_jour(id){
	document.getElementById('graphe_img_jour').style.display='none';
	}
function cache_mois(id){
	document.getElementById('graphe_img_mois').style.display='none';
	}
function cache_an(id){
document.getElementById('graphe_img_an').style.display='none';
	}