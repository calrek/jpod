<?php  
include ("../config/config.php");
include ("../locale/language.php");
?>
Ext.grid.GridFilters.prototype.filtersText = '<?php echo lang("filter");?>';
Ext.grid.filter.BooleanFilter.prototype.yesText = '<?php echo lang("yes");?>';
Ext.grid.filter.BooleanFilter.prototype.noText = '<?php echo lang("no");?>';
Ext.grid.filter.DateFilter.prototype.beforeText = '<?php echo lang("before_date");?>';
Ext.grid.filter.DateFilter.prototype.afterText = '<?php echo lang("after_date");?>';
Ext.grid.filter.DateFilter.prototype.onText = '<?php echo lang("on_date");?>'; 
