<?php /* SMARTSEARCH$Id: files.inc.php,v 1.7.2.5 2007/03/06 00:34:43 merlinyoda Exp $ */
if (!defined('DP_BASE_DIR')){
  die('You should not access this file directly.');
}

/**
* files Class
*/
class files extends smartsearch {
	var $table = "files";
	var $table_module	= "files";
	var $table_key = "file_id";
	var $table_link = "index.php?m=files&a=addedit&file_id=";
	var $table_title 	= "Files";
	var $table_orderby = "file_name";
	var $search_fields = array ("file_real_filename","file_name","file_description","file_type");
	var $display_fields = array ("file_real_filename","file_name","file_description","file_type");
	var $follow_up_link = 'fileviewer.php?file_id=';
	
	function cfiles (){
		return new files();
	}
}
?>
