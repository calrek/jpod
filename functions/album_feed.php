<?php
header('Content-type: text/xml');

include("../config/config.php");
include("../locale/language.php");

include("../inc/database.php");
include("../inc/functions.php");
include("../security.php");
?>
<rss version="2.0" xmlns:media="http://search.yahoo.com/mrss/" xmlns:atom="http://www.w3.org/2005/Atom">
	<channel>
		<?php 
		if($_REQUEST["sort_dir"])
			$dir = $_REQUEST["sort_dir"];
		else
			$dir = "ASC";
			
		if($_REQUEST["sort"]=="artist")
			$sort = "if(artistID!=0,0,1),artist ".$dir.",name ".$dir;
		else
			$sort = "name ".$dir;
		
		$query = "SELECT ID,name,cover,cover_resized,num_files,artist FROM album WHERE name != '' ";
		if($_REQUEST["query"] and $_REQUEST["query"]!="undefined")
		{
			$fields = substr($_REQUEST["fields"],1,strlen($_REQUEST["fields"])-2);
			$fields_array = explode(",",$fields);
			for($i=0;$i<sizeof($fields_array);$i++)
			{
				$field = str_replace("\\\"","",$fields_array[$i]);
				$where_query[] = $field." LIKE '%".$_REQUEST["query"]."%'";
			}
			$query .= " AND (".implode(" OR ",$where_query).")";
		}
		$query .= " ORDER BY ".$sort;
		$result = $db->query($query);
		while ($row = $db->fetch_array($result))
		{ 
			if(!$row["cover_resized"])
			{
				$link = "img/cover_no_album.gif";
				$thumb = "img/cover_no_album.gif";
			}
			else
			{
				$link = "cover/album/orig/".$row["ID"].".jpg";
				$thumb = "cover/album/resized/".$row["ID"].".jpg";
			}
			
			if(!$row["artist"])
				$artist = $lang["various"];
			else
				$artist = $row["artist"];
		?>
		<item>
		    <title><?php echo htmlspecialchars($row["name"]." - ".$artist);?></title>
				<media:description><?php echo $row["num_files"]." Songs";?></media:description>
		    <link><?php echo $link;?></link>
				<guid><?php echo $row["ID"];?></guid>
		    <media:thumbnail url="<?php echo $thumb;?>"/>
		    <media:content url="<?php echo $link;?>"/>
		 </item>
		 <?php 
		}
		?>
    <atom:link rel="vorherige" href="functions/album_feed.php?page=<?php echo $previous_page;?>" />
    <atom:link rel="naechste" href="functions/album_feed.php?page=<?php echo $next;?>" />
	</channel>
</rss>

