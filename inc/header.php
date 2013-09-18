<link rel="stylesheet" type="text/css" href="extjs/resources/css/ext-all.css" />
<link rel="stylesheet" type="text/css" href="extjs/resources/css/gtheme.css" />
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/icons.css" />

<script type="text/javascript" src="extjs/adapter/ext/ext-base.js" charset="UTF-8"></script>
<script type="text/javascript" src="extjs/ext-all.js" charset="UTF-8"></script>
<SCRIPT type="text/javascript" src="js/Ext.overrides.js"></SCRIPT>

<script type="text/javascript" src="list/lists.php"></script>
<SCRIPT type="text/javascript" src="js/plugins.php"></SCRIPT>

<script type="text/javascript" src="extjs/src/locale/ext-lang-en.js" charset="UTF-8"></script>

<script type="text/javascript">
	SM2_DEFER = true;
	Ext.BLANK_IMAGE_URL = 'extjs/resources/images/default/s.gif';
</script>
<script type="text/javascript" src="soundmanager/script/soundmanager2.js"></script>
<script type="text/javascript">

	function onItemSelected(item) {
			if (item == null) {
					// nothing selected
			} else {
					//cooliris_window.close();
					filter_setting('album',item.guid);
			}
	}

	function play() {
		soundManager.togglePause('my_soundID');
	}
	
	function stop() {
		soundManager.stop("my_soundID");
	}

	var cp = new Ext.state.CookieProvider({
		expires: new Date(new Date().getTime()+(1000*60*60*24*30)), //30 days
	});
	Ext.state.Manager.setProvider(cp);	
</script>

<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="icon" href="favicon.ico" type="image/x-icon">
