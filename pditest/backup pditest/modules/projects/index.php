<?php  /* PROJECTS $Id: index.php,v 1.84.6.16 2007/09/18 02:27:31 cyberhorse Exp $ */
if (!defined('DP_BASE_DIR')){
	die('You should not access this file directly.');
}

$AppUI->savePlace();

$reports = $AppUI->readFiles( DP_BASE_DIR.'/modules/projects/reports', "\.php$" );
// load the companies class to retrieved denied companies
require_once( $AppUI->getModuleClass( 'companies' ) );

// Let's update project status!
if(isset($_GET["update_project_status"]) && isset($_GET["project_status"]) && isset($_GET["project_id"]) ){
	$projects_id = $_GET["project_id"]; // This must be an array

	foreach($projects_id as $project_id){
		$r  = new DBQuery;
		$r->addTable('projects');
		$r->addUpdate('project_status', "{$_GET['project_status']}");
		$r->addWhere('project_id   = '.$project_id);
		$r->exec();
		$r->clear();
	}
}
// End of project status update
// retrieve any state parameters
if (isset( $_GET['tab'] )) {
	$AppUI->setState( 'ProjIdxTab', $_GET['tab'] );
}

$tab = $AppUI->getState( 'ProjIdxTab' ) !== NULL ? $AppUI->getState( 'ProjIdxTab' ) : 500;
$currentTabId = $tab;
$active = intval( !$AppUI->getState( 'ProjIdxTab' ) );

if (isset( $_POST['company_id'] )) {
	$AppUI->setState( 'ProjIdxCompany', intval( $_POST['company_id'] ) );
}
$company_id = $AppUI->getState( 'ProjIdxCompany' ) !== NULL ? $AppUI->getState( 'ProjIdxCompany' ) : $AppUI->user_company;

$company_prefix = 'company_';

if (isset( $_POST['department'] )) {
	$AppUI->setState( 'ProjIdxDepartment', $_POST['department'] );
	
	//if department is set, ignore the company_id field
	unset($company_id);
}
$department = $AppUI->getState( 'ProjIdxDepartment' ) !== NULL ? $AppUI->getState( 'ProjIdxDepartment' ) : $company_prefix.$AppUI->user_company;

//if $department contains the $company_prefix string that it's requesting a company and not a department.  So, clear the 
// $department variable, and populate the $company_id variable.
if(!(strpos($department, $company_prefix)===false)){
	$company_id = substr($department,strlen($company_prefix));
	$AppUI->setState( 'ProjIdxCompany', $company_id );
	unset($department);
}

$orderdir = $AppUI->getState('ProjIdxOrderDir') ? $AppUI->getState('ProjIdxOrderDir') : 'asc';
if (isset( $_GET['orderby'] )) {
    if ($AppUI->getState('ProjIdxOrderDir') == 'asc') {
		$orderdir = 'desc';
    } else {
    	$orderdir = 'asc';
    }
    $AppUI->setState('ProjIdxOrderBy', $_GET['orderby']);
}
$orderby  = $AppUI->getState('ProjIdxOrderBy') ? $AppUI->getState('ProjIdxOrderBy') : 'project_end_date';
$AppUI->setState( 'ProjIdxOrderDir', $orderdir);

// prepare the users filter
if (isset( $_POST['show_owner'] ))
	$AppUI->setState( 'ProjIdxowner', intval( $_POST['show_owner'] ) );
$owner = $AppUI->getState( 'ProjIdxowner' ) !== NULL ? $AppUI->getState( 'ProjIdxowner' ) : 0;


$bufferUser = '<select name="show_owner" onchange="document.pickUser.submit()" class="text">';
$bufferUser .= "<OPTION VALUE='0'>".$AppUI->_('All Users');

$usersql = "
SELECT user_id, user_username, contact_first_name, contact_last_name
FROM users, contacts
WHERE user_contact = contact_id
ORDER BY contact_last_name";


include ("reportes/jpgraph/jpgraph.php");
//include ("jpgraph/jpgraph_line.php");
include ("reportes/jpgraph/jpgraph_bar.php");

//validacion de que es usuario administrador
if ($AppUI->user_type == 1 )
{
require_once ("modules/tasks/consulta_tarea/class/class.php");
$obj5 = new Consulta();
$ano = date("Y");
$mes = date("Y-m");
    

	       $fecha1 = $_POST["fecha1"]; 
               $fecha6 = substr($fecha1,0,7);//fecha seleccionada por el usuario
               $mes2 = substr($fecha1,0,7);
               $ano6 = substr($fecha1,0,4);//ano seleccionado
   
$validacion_registro = $obj5->vali_guar($fecha6);
	
echo "<center><form name ='form11' action='' method='post'>
		<input type='text' size='10' id='fecha1' name='fecha1' value=.$fecha1.  readonly='readonly' /> 
        <button id='f_btn1'>...</button>
        <script type='text/javascript'>//<![CDATA[
      Calendar.setup({
        inputField : 'fecha1',
        trigger    : 'f_btn1',
        onSelect   : function() { this.hide() },
        showTime   : 12,
        dateFormat : '%Y-%m-%d'
      });
      </script>

		<input type='hidden' name='grabar' value='si' />
        
        <input type='button' value='Guardar Histórico' title='Histórico' onclick='valida();' />
		
	</form> <div id='valor'></div></center>";
	//echo count($validacion_registro);
	if (isset($_POST["grabar"]) && $_POST["grabar"] == "si" )
		{
				if (count($validacion_registro) == 0)  
				 {
					$fec_co = "$ano-02"; 
					if ($mes == $fec_co)
					{
						$obj5->add_meta_mes_nuevo() ;
						//echo $ano5= date ("Y") +1;
					}
					
					if ($ano6 >= 2012 && $mes2 < $mes )            
		   			{
					//echo "imprimiendoando".$fecha1 = $_POST['fecha1']";
					$obj5->add_meta_mes();

					//$obj5->consulta_id_meta_que_no_estan_el_mes_seleccionado();
					echo "<font color='#ff0000'><center>.::Históricos Almacenado Satisfactoriamente::.</center></font><script> location.href = 'index.php?m=projects';</script>";	
					
					exit;
					}
					else
					{
					echo "<font color='#ff0000'><center>.::No hay datos para esta busqueda::.</center></font>";	
					}
				}

				else{
					echo "<font color='#ff0000'><center>.::Históricos ya fué registrado::.</center></font>";	
				}

			
		}
//echo "....".$AppUI->user_id;  
//echo ".**".$AppUI->user_type;
}
if (($rows = db_loadList( $usersql, NULL )))
{
  foreach ($rows as $row)
  {
    if ( $owner == $row["user_id"])
      $bufferUser .= "<OPTION VALUE='".$row["user_id"]."' SELECTED>".$row["contact_last_name"].', '.$row["contact_first_name"]. ' ('. $row["user_username"]. ')';
    else
      $bufferUser .= "<OPTION VALUE='".$row["user_id"]."'>".$row["contact_last_name"].', '.$row["contact_first_name"]. ' ('. $row["user_username"]. ')';
  }
}

// collect the full projects list data via function in projects.class.php
projects_list_data();



// setup the title block
$titleBlock = new CTitleBlock( 'Projects', 'applet3-48.png', $m, "$m.$a" );
$titleBlock->addCell( $AppUI->_('Vigencia') . ':');
$titleBlock->addCell( $bufferUser, '', '<form action="?m=projects" method="post" name="pickUser">', '</form>');
$titleBlock->addCell( $AppUI->_('Company') . '/' . $AppUI->_('Division') . ':');
$titleBlock->addCell( $buffer, '', '<form action="?m=projects" method="post" name="pickCompany">', '</form>');
$titleBlock->addCell();
if ($canAuthor) {
	$titleBlock->addCell(
		'<input type="submit" class="button" value="'.$AppUI->_('new project').'">', '',
		'<form action="?m=projects&a=addedit" method="post">', '</form>'
	);
}
$titleBlock->show();

$project_types = dPgetSysVal("ProjectStatus");

$active = 0;
$complete = 0;
$archive = 0;
$proposed = 0;

foreach($project_types as $key=>$value)
{
        $counter[$key] = 0;
	if (is_array($projects)) {
		foreach ($projects as $p)
			if ($p['project_status'] == $key)
				++$counter[$key];
	}
        $project_types[$key] = $AppUI->_($project_types[$key], UI_OUTPUT_RAW) . ' (' . $counter[$key] . ')';
}


if (is_array($projects)) {
        foreach ($projects as $p)
        {
                if ($p['project_status'] == 3)
                        ++$active;
                else if ($p['project_status'] == 5)
                        ++$complete;
                else
                        ++$proposed;
        }
}

$fixed_project_type_file = array(
        $AppUI->_('In Progress', UI_OUTPUT_RAW) . ' (' . $active . ')' => "vw_idx_active",
        $AppUI->_('Complete', UI_OUTPUT_RAW) . ' (' . $complete . ')'    => "vw_idx_complete",
				$AppUI->_('Archived', UI_OUTPUT_RAW). ' (' . $counter['7'] . ')' => 'vw_idx_archived');

/**
* Now, we will figure out which vw_idx file are available
* for each project type using the $fixed_project_type_file array 
*/
$project_type_file = array();

foreach($project_types as $project_type){
	$project_type = trim($project_type);
	if(isset($fixed_project_type_file[$project_type])){
		$project_file_type[$project_type] = $fixed_project_type_file[$project_type];
	} else { // if there is no fixed vw_idx file, we will use vw_idx_proposed
		$project_file_type[$project_type] = 'vw_idx_proposed';
	}
}

// tabbed information boxes
$tabBox = new CTabBox( "?m=projects", DP_BASE_DIR.'/modules/projects/', $tab );

$tabBox->add( 'vw_idx_proposed', $AppUI->_('All', UI_OUTPUT_RAW). ' (' . count($projects) . ')' , true,  500);
foreach($project_types as $ptk=>$project_type) {
		$tabBox->add($project_file_type[$project_type], $project_type, true, $ptk);
}
$min_view = true;
$tabBox->add("viewgantt", "Gantt");
$tabBox->show();
?>

<script> function valida() {  
document.form11.submit();  
/*document.getElementById("valor").innerHTML="<font color='#ff0000'>.::Históricos Almacenado Satisfactoriamente::.</font>";*/ }</script>
<noscript>
  <p>La página que estás viendo requiere para su funcionamiento el uso de JavaScript. 
Si lo has deshabilitado intencionadamente, por favor vuelve a activarlo.</p>
</noscript>