<?php /* SMARTSEARCH$Id: tickets.inc.php,v 1.7.2.5 2007/03/06 00:34:43 merlinyoda Exp $ */
if (!defined('DP_BASE_DIR')){
  die('You should not access this file directly.');
}

/**
* tickets Class
*/
class tickets extends smartsearch {
	var $table = "tickets";
	var $table_module	= "ticketsmith";
	var $table_key = "ticket";
	var $table_link = "index.php?m=ticketsmith&a=view&ticket=";
	var $table_title = "Tickets";
	var $table_orderby = "subject";
	var $search_fields = array ("author","recipient","subject","type","cc","body","signature");
	var $display_fields = array ("author","recipient","subject","type","cc","body","signature");

	function ctickets (){
		return new tickets();
	}
}
?>
