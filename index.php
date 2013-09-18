<?php
header("Content-type:text/html; charset=utf-8");

define("SCRIPT", "main");

include ("config/config.php");
include ("locale/language.php");

include ("inc/database.php");
include ("inc/functions.php");
include ("security.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title>Jukepod</title>
<?php
include ("inc/header.php");
?>

</head>

<body onLoad="">
<div id="hidden_div">
    <div id="playing_info">
        <div id="playing_info_content">
            <div id="song_info">
                <div id="time_and_control" class="x-toolbar">
                    <div onclick="player_obj.toggle_time_display_mode();" id="digits">
                        <div class='digit digit_empty' id="min_3"></div>
                        <div class='digit' id="min_2"></div>
                        <div class='digit' id="min_1"></div>
                        <div class='digit_sep'></div>
                        <div class='digit' id="sec_2"></div>
                        <div class='digit' id="sec_1"></div>
                    </div>
                    <div id="control">
                    </div>
                    <div id="player_volume"></div>
                    <div id="window_options"></div>
                </div>
                <div id="player_row" class="x-toolbar">
                    <div id="player"></div>
                    <div id="player_options"></div>
                </div>
                <div class="info_row">
                    <div class="label"><img id="info_artist_button" src="img/silk/icons/user.png"></div>
                    <div class="info" id="info_artist">-</div>
                </div>
                <div class="info_row">
                    <div class="label"><img src="img/silk/icons/music.png"></div>
                    <div class="info" id="info_title">-</div>
                </div>
                <div class="info_row">
                    <div class="label"><img id="info_genre_button" src="img/silk/icons/cd.png"></div>
                    <div class="info" id="info_genre">-</div>
                </div>
                <div class="info_row">
                    <div class="label"><img id="info_path_button" src="img/silk/icons/folder.png"></div>
                    <div class="info" id="info_path">-</div>
                </div>
                <div class="info_row">
                    <div class="third">
                        <div class="label"><img src="img/silk/icons/text_list_numbers.png"></div>
                        <div class="info" id="info_track">-</div>
                    </div>
                    <div class="third">
                        <div class="label"><img src="img/silk/icons/time.png"></div>
                        <div class="info" id="info_time">-</div>
                    </div>
                    <div class="third">
                        <div class="label"><img src="img/silk/icons/cog.png"></div>
                        <div class="info" id="info_bitrate">-</div>
                    </div>
                </div>
            </div>
            <div id="info_cover_row" class="info_cover_row">
                <img width="150px" src="img/cover_no_album.gif" id="info_cover">
            </div>
        </div>
    </div>
    <div id="debug"></div>
    <div id="ladebalken"></div>
</div>

</body>
</html>
