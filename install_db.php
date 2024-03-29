<?php
define( "SCRIPT", "install_db" );

include "config/config.php";
include "inc/database.php";
include "inc/functions.php";

$_SESSION["sql_log"] = array();

$db = new db( "", "", "", "", CREATE_DB );

$queries = file_get_contents( "sql/database.sql" );

$query_array = explode( ";", $queries );

for ( $i=0;$i<sizeof( $query_array );$i++ ) {
	if ( $query_array[$i] ) $db->query( $query_array[$i] );
}

echo "all_done...";
?>
