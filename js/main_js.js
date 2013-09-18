Ext.onReady(function() {
	Ext.QuickTips.init();

	Ext.SliderTip = Ext.extend(Ext.Tip, {
		minWidth: 10,
		offsets: [0, -10],
		init: function(slider) {
			slider.on('dragstart', this.onSlide, this);
			slider.on('drag', this.onSlide, this);
			slider.on('dragend', this.hide, this);
			slider.on('destroy', this.destroy, this);
		},

		onSlide: function(slider, e, thumb) {
			this.show();
			this.body.update(this.getText(slider));
			this.doAutoWidth();
			this.el.alignTo(thumb.el, 'b-t?', this.offsets);
		},

		getText: function(slider) {
			return slider.getValue();
		}
	});

	var player_bar_tip = new Ext.SliderTip({
		getText: function(slider) {
			return String.format('<b>{0}</b>', renderDuration(Math.round(player_obj.duration * slider.getValue() / 100)));
		}
	});

	var title = '<div class="mp3_title"><div class="icon"><img src="img/silk/icons/music.png"></div><div id="title" class="title"><?php
echo lang("mp3_grid_title", 1); ?></div><div class="about"><?php
echo lang("hello", 1); ?> <?php
echo $_SESSION["username"]; ?>, <a href="<?php
if ($_SESSION["usertype"] == "guest") echo "login";
else echo "logout";
?>.php"><?php
if ($_SESSION["usertype"] == "guest") echo $lang["login"];
else echo $lang["logout"];
?></a>&nbsp;<?php
if ($_SESSION["permission"]["useradmin"]) {
?><img src="img/silk/icons/user.png" onClick="open_user_form(<?php
	echo $_SESSION['
	userID ']; ?>)">&nbsp;<?php
}
?><img src="img/silk/icons/help.png" onClick="my_about()"></div></div>';

	player_bar = new Ext.Slider({
		renderTo: 'player',
		id: 'player_bar',
		minValue: 0,
		maxValue: 100,
		value: 0,
		width: 180,
		disabled: true,
		plugins: player_bar_tip,
		listeners: {
			dragstart: function(s, e) {
				player_obj.stop_updating = true;
			},
			dragend: function(s, e) {
				player_obj.seek_percent(s.getValue());
			},
			changecomplete: function(s, v) {
				player_obj.seek_percent(v);
			},
			render: function(s) {
				var parent = document.getElementById("player_bar").firstChild.firstChild;
				var child = document.getElementById("player_bar").firstChild.firstChild.firstChild;

				var ladebalken = document.getElementById("ladebalken");

				parent.insertBefore(ladebalken, child);
			}
		}
	});

	var volume_tip = new Ext.SliderTip({
		getText: function(slider) {
			return String.format('<b>{0}% <?php echo lang("volume", 1); ?></b>', slider.getValue());
		}
	});

	player_volume_bar = new Ext.Slider({
		renderTo: 'player_volume',
		minValue: 0,
		maxValue: 100,
		value: 100,
		width: 50,
		vertical: false,
		plugins: volume_tip,
		listeners: {
			change: function(s, v) {
				player_obj.set_volume(v);
			}
		}
	});

	Ext.get('player_bar').applyStyles('cursor:pointer');

	var dir_tree = new Ext.tree.TreePanel({
		resizable: false,
		height: 300,
		useArrows: true,
		title: '<?php echo lang("folder", 1); ?>',
		autoScroll: true,
		iconCls: 'icon-folder',
		id: 'dir_treeID',
		animate: true,
		border: false,
		enableDD: false,
		containerScroll: true,
		trackMouseOver: false,
		<?php
		if ($_SESSION["permission"]["read_files"]) {
		?>
		contextMenu: new Ext.menu.Menu({
				items: [{
						id: 'import_only_files_in_dir',
						text: '<?php echo lang("import_only_files_in_dir", 1); ?>',
						iconCls: 'icon-new-update'
					}, {
						id: 'import_new_files_and_dirs',
						text: '<?php echo lang("import_new_files_and_dirs", 1); ?>',
						iconCls: 'icon-new-update'
					}, {
						id: 'import_all_files',
						text: '<?php echo lang("import_all_files", 1); ?>',
						iconCls: 'icon-folder'
					},
					new Ext.menu.Separator(), {
						id: 'import_cover',
						text: '<?php echo lang("import_cover", 1); ?>',
						iconCls: 'icon-album'
					},
					new Ext.menu.Separator(), {
						id: 'reload-node',
						text: '<?php echo lang("reload_node", 1); ?>',
						iconCls: 'icon-full-update'
					},
					new Ext.menu.Separator(), {
						id: 'clear_cache',
						text: '<?php echo lang("clear_cache", 1); ?>',
						iconCls: 'icon-clear-cache'
					}
				],
				listeners: {
					itemclick: function(item) {
						var node = item.parentMenu.contextNode;
						var scan_method = "";
						var scan_type = "";
						switch (item.id) {
							case 'import_only_files_in_dir':
								scan_method = "SCAN_ONLY_FILES_IN_CURRENT_DIR";
								scan_type = "files";
								break;
							case 'import_new_files_and_dirs':
								scan_method = "SCAN_ONLY_NEW";
								scan_type = "files";
								break;
							case 'import_all_files':
								scan_method = "ALL";
								scan_type = "files";
								break;
							case 'import_cover':
								scan_type = "cover";
								break;
							case 'reload-node':
								if (node.reload) node.reload();
								break;
							case 'clear_cache':
								clear_cache();
								break;
						}
						if (scan_type) {
								switch (scan_type) {
									case "files":
										readdir_window = window.open("read_dir.php?scan_method=" + scan_method + "&id=" + node.attributes.id, "readdir", "width=440,height=253,scrollbars=no,toolbar=no,status=no,directories=no,menuebar=no,location=no,resizable=0");
										break;
									case "cover":
										readdir_window = window.open("read_album.php?id=" + node.attributes.id, "readalbum", "width=440,height=193,scrollbars=no,toolbar=no,status=no,directories=no,menuebar=no,location=no,resizable=0");
										break;
								}
						}
					}
				}
			}),
		<?php
		}
		?>
			listeners: { <?php
			if ($_SESSION["permission"]["read_files"]) { ?> 'contextmenu': function(node, e) {
					dont_select_tree_node = true;
					node.select();
					dont_select_tree_node = false;
					var c = node.getOwnerTree().contextMenu;
					c.contextNode = node;
					c.showAt(e.getXY());
				},
				<?php
			} ?> 'render': function(tp) {
				tp.getSelectionModel().on('selectionchange', function(tree, node) {
					if (!dont_select_tree_node) {
						filter_setting("tree", node.attributes.full_path);
					} else dont_select_tree_node = false;
				})
			}
		},

		dataUrl: 'functions/get_tree.php',
		rootVisible: false,
		layout: 'fit',
		root: {
			text: '<?php echo lang("tree_root_name", 1); ?>',
			draggable: false,
			id: -1
		}
	});

	player_obj = new player();
	mp3_list_obj = mp3_list();
	play_list_obj = play_list();
	artist_obj = artist_list();
	album_obj = album_list();

	var filter_panel = new Ext.Panel({
		region: 'west',
		id: 'filter_panelID',
		width: 234,
		border: false,
		minSize: 90,
		header: true,
		title: '<?php echo lang("filter", 1); ?>',
		iconCls: 'icon-filter',
		animFloat: false,
		layout: 'accordion',
		items: [play_list_obj, dir_tree, artist_obj, album_obj]
	});

	var viewport = new Ext.Viewport({
		layout: 'border',
		items: [
			{
			region: 'north',
			height : 75,
			layout : 'vbox',
			layoutConfig: {
				align : 'stretch'
			},
			defaults: {
				frame:true,
				margins : '5 5 0 5',
				flex:1
			},
			items : [{
				html:'<div class="mp3_title"><div class="about"><?php echo USERNAME;?>, <img src="img/silk/icons/user.png" onClick="open_user_form(<?php echo USERID;?>)"> <a href="logout.php"/>Logout</a></div></div>',
				header: true
			}]

		},
		{
			region : 'west',
			split : true,
			width : 400,
			layout : 'vbox',
			layoutConfig: {
				align : 'stretch'
			},
			defaults: {
				frame:true,
				margins : '0 0 5 0',
				flex:1
			},
			margins : '5 0 5 5',
			items : [filter_panel]
		},
			new Ext.Panel({
				id: 'center_pangelID',
				boder: true,
				split: true,
				height: 70,
				minHeight: 70,
				maxHeight: 70,
				region: 'center',
				listeners: {
					beforecollapse: function() {
						undock_player();
					}
				},
				margins : '5 5 5 0',
				layout:'vbox',
				layoutConfig: {
					align : 'stretch'
				},
				defaults: {
					frame:true,
					margins : '0 0 5 0',
					flex:1
				},
				items: [
				{
					region: 'north',
					border: false,
					id: 'top_northID',
					layout: 'fit',
					height: 150,
					header: true,
					title: 'player',
					items: [{
						xtype: 'box',
						el: 'playing_info',
						id: 'playing_info_content',
						border: false
					}]
				}, {
					region: 'center',
					border: false,
					header: true,
					title: 'Mp3 List',
					id: 'center_regionID',
					layout: 'fit',
					items: [mp3_list_obj]
				}, {
					region: 'south',
					hidden: 'true',
					border: false,
					id: 'center_southID',
					layout: 'fit',
					items: []
				}
				]
			})
		]
	});

	player_obj.undock_button = new Ext.Button({
		iconCls: 'icon-undock',
		tooltip: '<?php echo lang("undock", 1); ?>',
		id: 'player_undock_buttonID',
		handler: undock_player
	}).render("window_options"); // where you want to render
	player_obj.prev_button = new Ext.Button({
		iconCls: 'icon-previous',
		tooltip: '<?php echo lang("play_prev_song_from_list", 1); ?>',
		id: "player_previous_buttonID",
		handler: function() {
			player_obj.prev_next(-1);
		}
	}).render("control"); // where you want to render
	player_obj.stop_button = new Ext.Button({
		iconCls: 'icon-stop',
		tooltip: '<?php echo lang("stop_song_from_list", 1); ?>',
		id: "player_stop_buttonID",
		handler: function() {
			player_obj.stop_playing();
		}
	}).render("control"); // where you want to render
	player_obj.pause_button = new Ext.Button({
		iconCls: 'icon-play',
		tooltip: '<?php echo lang("pause_song_from_list", 1); ?>',
		id: "player_pause_buttonID",
		handler: function() {
			player_obj.pause_playlist();
		}
	}).render("control"); // where you want to render
	player_obj.next_button = new Ext.Button({
		iconCls: 'icon-next',
		tooltip: '<?php echo lang("play_next_song_from_list", 1); ?>',
		id: "player_next_buttonID",
		handler: function() {
			player_obj.prev_next(1);
		}
	}).render("control"); // where you want to render
	player_obj.shuffle_button = new Ext.Button({
		iconCls: 'icon-shuffle',
		enableToggle: true,
		tooltip: '<?php echo lang("random_tooltip", 1); ?>',
		id: 'player_shuffle_buttonID',
		handler: function(btn) {
			if (btn.pressed) {
				player_obj.list_random = true;
				player_obj.played_songs = new Array();
			} else {
				player_obj.list_random = false;
				player_obj.played_songs = new Array();
			}
		}
	}).render("player_options"); // where you want to render
	player_obj.extras_button = new Ext.Button({
		iconCls: 'icon-extras',
		tooltip: '<?php echo lang("extras", 1); ?>',
		disabled: true,
		id: 'player_extras_buttonID'
	}).render("player_options"); // where you want to render
	player_obj.extras_button.addListener({
		'click': {
			fn: function(btn) {
				var menu = extras_menu(player_obj.current_data, "player");
				menu.show(document.getElementById("player_extras_buttonID"));
			}
		}
	})

	if (cp.get("player_window_show", 0)) undock_player();

	player_obj.set_time_display_mode();
	dir_tree.getRootNode().expand(false);
	soundManager = new SoundManager();
	soundManager.onload = function() {
		player_obj.inited = 1;
	}
	soundManager.url = 'soundmanager/swf/'; // directory where SM2 .SWFs live
	soundManager.debugMode = false;
	//soundManager.nullURL = 'soundmanager/null.mp3'
	player_obj.last_position = 0;
	soundManager.waitForWindowLoad = true;
	soundManager.consoleOnly = true;
	//soundManager.useConsole = true;
})