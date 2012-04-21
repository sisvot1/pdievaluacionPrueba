<?php /* ADMIN $Id: do_perms_aed.php,v 1.1.10.2 2007/03/06 00:34:44 merlinyoda Exp $ */
if (!defined('DP_BASE_DIR')){
  die('You should not access this file directly.');
}

$del = isset($_POST['del']) ? $_POST['del'] : 0;

$obj =& $AppUI->acl();

$AppUI->setMsg( 'Permission' );
if ($del) {
	if ($obj->del_acl($_REQUEST['permission_id'])) {
		$AppUI->setMsg( "deleted", UI_MSG_ALERT, true );
		$AppUI->redirect();
	} else {
		$AppUI->setMsg( $obj->msg(), UI_MSG_ERROR );
		$AppUI->redirect();
	}
} else {
	// No longer have update, only add.
	if ($obj->addRolePermission()) {
		$AppUI->setMsg( 'added', UI_MSG_OK, true );
	} else {
		$AppUI->setMsg( $obj->msg(), UI_MSG_ERROR );
	}
	$AppUI->redirect();
}
?>
