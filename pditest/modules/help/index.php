<?php /* $Id: index.php,v 1.7.12.3 2007/03/06 00:34:41 merlinyoda Exp $ */
if (!defined('DP_BASE_DIR')){
	die('You should not access this file directly.');
}

$hid = dPgetParam( $_GET, 'hid', 'help.toc' );

$inc = DP_BASE_DIR.'/modules/help/'.$AppUI->user_locale.'/'.$hid.'.hlp';

if (!file_exists( $inc )) {
	$inc = DP_BASE_DIR.'/modules/help/en/'.$hid.'';
	if (!file_exists( $inc )) {
		$hid = "help.pdf";
		$inc = DP_BASE_DIR.'/modules/help/'.$AppUI->user_locale.'/'.$hid.'.hlp';
		if (!file_exists( $inc )) {
		  $inc = DP_BASE_DIR.'/modules/help/en/'.$hid.'.hlp';
		}
	}
}
if ($hid != 'help.pdf') {
	echo '<a href="?m=help&dialog=1">' . $AppUI->_( 'index' ) . '</a>';
}
readfile( $inc );
?>
