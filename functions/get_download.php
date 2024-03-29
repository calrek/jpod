<?php
include ("../config/config.php");
include ("../locale/language.php");
include ("../inc/database.php");

include ("../inc/functions.php");
include ("../security.php");

if (!$_SESSION["permission"]["download"]) 
	html_no_permission ();

$query    = "SELECT filename,full_path FROM song WHERE ID = " . $_REQUEST["ID"];
$result   = $db -> query ($query);
$filename = MP3_PATH . "/" . $db -> result ($result, 0, "full_path") . "/" . $db -> result ($result, 0, "filename");

//$filename = str_replace(ROOT,"",$filename);
if (defined ("LOW_MEMORY_MODE")AND LOW_MEMORY_MODE==1) 
	$fp = fopen ($filename, "r");
else 
	$fc = file_get_contents ($filename);

$size = filesize ($filename);
header ('Content-Disposition: attachment; filename="' . basename ($db -> result ($result, 0, "filename")) . '"');
header ('Content-Length: ' . $size);

if (defined ("LOW_MEMORY_MODE")AND LOW_MEMORY_MODE==1) {
	while (!feof ($fp)) {
		echo (@fgets ($fp, 4096));
	}
	fclose ($fp);
} else 
	echo $fc;

$query = "UPDATE song SET num_downloads = num_downloads + 1 WHERE ID = " . $_REQUEST["ID"];
$db -> query ($query);
?>
