<?php

define("SCRIPT","IMPORT");
include("config/config.php");
$_SESSION["sql_log"] = array();

include("inc/database.php");
include("inc/functions.php");
include("inc/import_album_cover.php");
include("locale/language.php");

include("security.php");

if (!$_SESSION["permission"]["read_files"]) {
	if (array_key_exists("admin_key", $_GET)AND $_GET["admin_key"]) {
		$query = "SELECT ID FROM user WHERE type = 'admin' AND password = '".$_GET["admin_key"]."'";
		$result = $db->query($query);
		if ($db->num_rows($result)) {
			$admin_id = $db->result($result, 0, 0);
			$query = "SELECT value FROM user_permissions WHERE userID = ".$admin_id." AND value = '1' AND name = 'read_files'";
			$result = $db->query($query);
			if (!$db->num_rows($result))
				die($lang["no_permission"]);
		} else {
			die($lang["no_permission"]);
		}
	} else
		die($lang["no_permission"]);
}
if($_GET["in_frame"]) {
?>
	<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo lang("import_data_title");?></title>
		<link rel="stylesheet" type="text/css" href="extjs/resources/css/ext-all.css" />
	</head>
	<style type="text/css">
		.dir_body
		{
			border: 0px; padding: 3px;
		}
	</style>
	<body class="x-form-item x-window-mc dir_body">
<?php
}

$import_album_cover = new import_album_cover($_GET["id"]);

$import_album_cover->process_albums();

echo show_sql();

if($_GET["in_frame"]) {
?>
	</body>
</html>
<?php
}
?>
