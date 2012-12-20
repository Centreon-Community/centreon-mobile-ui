<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Centreon - IT & Network Monitoring</title>
	<link rel="shortcut icon" href="./img/favicon.ico"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="robots" content="index, nofollow" />
	<!--<meta name="viewport" content="width=479px" />-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

<!--Import CSS & Javascript-->
	
	<link href="../css/themes/default/jquery.mobile.min.css" rel="stylesheet" type="text/css" />
	<script src="js/jquery.min.js"></script>
	<script src="js/jquery.mobile.min.js"></script>
	<link href="../css/style-mobile.css" rel="stylesheet" type="text/css"/>
	<!--<script type="text/javascript" src="js/mobile-UI.js"></script>-->
	
</head>
<body>

<script>
/*Personnal JS functions
Thx ADes :)
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
</script>