<?php /* COMPANIES $Id: reportes.class.php,v 1.9.12.3 2007/03/06 00:34:40 merlinyoda Exp $ */
if (!defined('DP_BASE_DIR')){
  die('You should not access this file directly.');
}

/**
 *	@package dotProject
 *	@subpackage modules
 *	@version $Revision: 1.9.12.3 $
*/

require_once( $AppUI->getSystemClass ('dp' ) );

/**
 *	Companies Class
 *	@todo Move the 'address' fields to a generic table
 */
class CCompany extends CDpObject {
/** @var int Primary Key */
	var $reporte_id = NULL;
/** @var string */
	var $reporte_name = NULL;

// these next fields should be ported to a generic address book
	var $reporte_phone1 = NULL;
	var $reporte_phone2 = NULL;
	var $reporte_fax = NULL;
	var $reporte_address1 = NULL;
	var $reporte_address2 = NULL;
	var $reporte_city = NULL;
	var $reporte_state = NULL;
	var $reporte_zip = NULL;
	var $reporte_email = NULL;

/** @var string */
	var $reporte_primary_url = NULL;
/** @var int */
	var $reporte_owner = NULL;
/** @var string */
	var $reporte_description = NULL;
/** @var int */
	var $reporte_type = null;
	
	var $reporte_custom = null;

	function CCompany() {
		$this->CDpObject( 'reportes', 'reportes_id' );
	}
    
// overload check
	function check() {
		if ($this->reportes_id === NULL) {
			return 'reportes id is NULL';
		}
		$this->reporte_id = intval( $this->reporte_id );

		return NULL; // object is ok
	}

// overload canDelete
}
?>
