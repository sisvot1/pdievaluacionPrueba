<?php /* COMPANIES $Id: vw_active.php,v 1.18.10.4 2007/10/18 14:27:11 nybod Exp $ */
if (!defined('DP_BASE_DIR')){
	die('You should not access this file directly.');
}

##
##	Companies: View Projects sub-table
##
GLOBAL $AppUI, $company_id, $pstatus, $dPconfig;

$sort = dPgetParam($_GET, 'sort', 'project_name');
if ($sort == 'project_priority')
        $sort .= ' DESC';

$df = $AppUI->getPref('SHDATEFORMAT');

$q  = new DBQuery;
$q->addTable('projects');
$q->addQuery('project_id, project_name, project_start_date, project_status, project_target_budget, project_description,
	project_start_date,
        project_priority,
	contact_first_name, contact_last_name');
$q->addJoin('users', 'u', 'u.user_id = projects.project_owner');
$q->addJoin('contacts', 'con', 'u.user_contact = con.contact_id');
$q->addWhere('projects.project_company = '.$company_id);

include_once ( $AppUI->getModuleClass('projects'));
$projObj = new CProject();
$projList = $projObj->getDeniedRecords($AppUI->user_id );
if ( count($projList) ) {
$q->addWhere('NOT (project_id IN (' . implode(',',$projList) .  ') )') ;
}

$q->addWhere('projects.project_status <> 7');
$q->addOrder($sort);
$s = '';

if (!($rows = $q->loadList())) {
	$s .= $AppUI->_( 'No data available' ).'<br />'.$AppUI->getMsg();
} else {
	$s .= '<tr>';
	$s .= '<th><a style="color:white" href="index.php?m=companies&a=view&company_id='.$company_id.'&sort=project_priority">'.$AppUI->_('Prioridad').'</a></th>'
                .'<th><a style="color:white" href="index.php?m=companies&a=view&company_id='.$company_id.'&sort=project_name">'.$AppUI->_( 'Objetivo' ).'</a></th>'
    .'<th>'.$AppUI->_( 'Descripción del Objetivo' ).'</th>'
		.'<th>'.$AppUI->_( 'Owner' ).'</th>'
		.'<th>'.$AppUI->_( 'Started' ).'</th>'
		.'<th>'.$AppUI->_( 'Status' ).'</th>'
		.'<th>'.$AppUI->_( 'Budget' ).'</th>'
		.'</tr>';
	foreach ($rows as $row) {
		$start_date = new CDate( $row['project_start_date'] );
		$s .= '<tr>';
                $s .= '<td>';
                if ($row['project_priority'] < 0 ) {
                        $s .= "<img src='./images/icons/-1.gif' width=13 height=16>";
                } else if ($row["project_priority"] >= 0) {
                        $s .= "<img src='./images/icons/" . $row["project_priority"] .".gif' width=13 height=16>";
 }

                $s .= '</td>';
		$s .= '<td width="100">';
		$s .= '<a href="?m=projects&a=view&project_id='.$row["project_id"].'">'.$row["project_name"].'</a></td>';
		$s .= '<td nowrap="nowrap" width=500>'.$row["project_description"].'</td>';
		$s .= '<td nowrap="nowrap">'.$row["contact_first_name"].'&nbsp;'.$row["contact_last_name"].'</td>';
		$s .= '<td nowrap="nowrap">'.$start_date->format( $df ).'</td>';
		$s .= '<td nowrap="nowrap">'.$AppUI->_($pstatus[$row["project_status"]]).'</td>';
		$s .= '<td nowrap="nowrap" align="right">'.$dPconfig["currency_symbol"].$row["project_target_budget"].'</td>';
		$s .= '</tr>';
	}
}
echo '<table cellpadding="2" cellspacing="1" border="0" width="100%" class="tbl">' . $s . '</table>';
?>
