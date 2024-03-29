<?php
include ("../config/config.php");
include ("../locale/language.php");
?>
/*
 * Ext JS Library 2.2.1
 * Copyright(c) 2006-2009, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://extjs.com/license
 */

Ext.onReady(function(){
    
    pb_scanning = new Ext.ProgressBar({
        id:'pb_scanningID',
        width:300,
				cls:'left-align',
        renderTo:'pb_scanning_div'
    });

    pb_file = new Ext.ProgressBar({
        id:'pb_fileID',
        width:300,
				cls:'left-align',
        renderTo:'pb_processing_file_div'
    });

    pb_fields = new Ext.ProgressBar({
        id:'pb_fieldsID',
        width:300,
				cls:'left-align',
        renderTo:'pb_processing_fields_div'
    });
		
    /*pb_scanning.on('update', function(val){
        //You can handle this event at each progress interval if
        //needed to perform some other action
        Ext.fly('pb_scanning_text').dom.innerHTML += '.';
    });*/

	document.getElementById("iframeID").src="dir.php?scan_method=" + scan_method + "&in_frame=1&js_output=1&id=" + dir_id + "&reset_db=" + reset_db;
});

function all_done()
{
Ext.MessageBox.show({
	 title: '<?php echo lang("scanning_done_title",1);?>',
	 msg: '<?php echo lang("scanning_done_text",1);?>',
	 buttons: Ext.MessageBox.OK,
	 icon: Ext.MessageBox.INFO
});				
}
