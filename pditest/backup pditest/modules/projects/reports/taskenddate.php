<?php
if (!defined('DP_BASE_DIR')){
  die('You should not access this file directly.');
}

$do_report 		    = dPgetParam( $_POST, "do_report", 0 );
$log_start_date 	= dPgetParam( $_POST, "log_start_date", 0 );
$log_end_date 	    = dPgetParam( $_POST, "log_end_date", 0 );
$user_id            = dPgetParam( $_POST, "user_id", $AppUI->user_id);

// create Date objects from the datetime fields
$start_date = intval( $log_start_date ) ? new CDate( $log_start_date ) : new CDate();
$end_date   = intval( $log_end_date )   ? new CDate( $log_end_date ) : new CDate();

if (!$log_start_date) {
	$start_date->subtractSpan( new Date_Span( "14,0,0,0" ) );
}
$end_date->setTime( 23, 59, 59 );
?>

<script language="javascript">
var calendarField = '';

function popCalendar( field ){
	calendarField = field;
	idate = eval( 'document.editFrm.log_' + field + '.value' );
	window.open( 'index.php?m=public&a=calendar&dialog=1&callback=setCalendar&date=' + idate, 'calwin', 'width=250, height=220, scrollbars=no' );
}

/**
 *	@param string Input date in the format YYYYMMDD
 *	@param string Formatted date
 */
function setCalendar( idate, fdate ) {
	fld_date = eval( 'document.editFrm.log_' + calendarField );
	fld_fdate = eval( 'document.editFrm.' + calendarField );
	fld_date.value = idate;
	fld_fdate.value = fdate;
}
</script>

<form name="editFrm" action="index.php?m=projects&a=reports" method="post">
<input type="hidden" name="project_id" value="<?php echo $project_id;?>" />
<input type="hidden" name="report_type" value="<?php echo $report_type;?>" />

<table cellspacing="0" cellpadding="4" border="0" width="100%" class="std">


<tr>
	<td align="right" nowrap="nowrap"><?php echo $AppUI->_('For period');?>:</td>
	<td nowrap="nowrap">
		<input type="hidden" name="log_start_date" value="<?php echo $start_date->format( FMT_TIMESTAMP_DATE );?>" />
		<input type="text" name="start_date" value="<?php echo $start_date->format( $df );?>" class="text" disabled="disabled" />
		<a href="#" onClick="popCalendar('start_date')">
			<img src="./images/calendar.gif" width="24" height="12" alt="<?php echo $AppUI->_('Calendar');?>" border="0" />
		</a>
	</td>
	<td align="right" nowrap="nowrap"><?php echo $AppUI->_('to');?></td>
	<td nowrap="nowrap">
		<input type="hidden" name="log_end_date" value="<?php echo $end_date ? $end_date->format( FMT_TIMESTAMP_DATE ) : '';?>" />
		<input type="text" name="end_date" value="<?php echo $end_date ? $end_date->format( $df ) : '';?>" class="text" disabled="disabled" />
		<a href="#" onClick="popCalendar('end_date')">
			<img src="./images/calendar.gif" width="24" height="12" alt="<?php echo $AppUI->_('Calendar');?>" border="0" />
		</a>
	</td>

	<td nowrap='nowrap'>
	   <?php
	       $sql = "select user_id, concat_ws(' ', contact_first_name, contact_last_name)
	               from users left join permissions on (user_id = permission_user)
	                          left join contacts on (user_contact = contact_id)
	               where !isnull(permission_user)";
	       $users = array(0 => $AppUI->_("All")) + db_loadHashList($sql);
	       echo arraySelect($users, "user_id", "class='text'", $user_id);
	   ?>
	</td>
	
	<td align="right" width="50%" nowrap="nowrap">
		<input class="button" type="submit" name="do_report" value="<?php echo $AppUI->_('submit');?>" />
	</td>
</tr>

</table>
</form>

<?php
if($do_report){
    $projects_filter = '';
    if ($project_id != 0)
			$projects_filter = " and task_project = $project_id ";

    $user_filter     = "";
    
    $sql = "select t.*, p.project_name, p.project_description, u.user_username
            from tasks as t,
                 users as u,
                 projects as p";
    if($user_id > 0){
        $sql         .= ", user_tasks as ut";
        $user_filter  = " and ut.user_id = $user_id
                         and ut.task_id = t.task_id ";
    }
    $sql.=" where task_end_date   >= '".$start_date->format( FMT_DATETIME_MYSQL )."'
                and task_end_date <= '".$end_date->format( FMT_DATETIME_MYSQL )."'
                and p.project_id   = t.task_project
                and t.task_dynamic = '0'
                and t.task_owner = u.user_id
                $projects_filter
                $user_filter
            order by project_name asc, task_end_date asc";

    $tasks = db_loadHashList($sql, "task_id");
    $first_task = current($tasks);
    $actual_project_id = 0;
    $first_task        = true;
    $task_log          = array();
    if ($tasks1['task_priority']==0) {$str .= "Impacto Medio";}
		else if ($tasks1['task_priority']==-1) {$str .= "Bajo Impacto";}
		else if ($tasks1['task_priority']==1) {$str .= "Impacto Alto";}
 		else if ($tasks1['task_priority']==2) {$str .= "Muy Alto Impacto";}
		else{$tasks1 .= "";}
		echo "<table class='tbl' width='100%'>";
    echo "<tr><th>".$AppUI->_("Objetivo")."</th><th>".$AppUI->_("Meta")."</th><th>".$AppUI->_("Descripción de la Meta")."</th><th>".$AppUI->_("Lider de la Meta")."</th><th>".$AppUI->_("Fecha Final de la Meta")."</th><th>".$AppUI->_("Fecha de la ultima Actividad")."</th><th>".$AppUI->_("% Cumplimiento")."</th></tr>";
    $hrs = $AppUI->_("hrs"); // To avoid calling $AppUI each row
    foreach($tasks as $task){
       	if($actual_project_id != $task["task_project"]){
            echo "<tr><td colspan='2'><b>".$task["project_name"]."</b></td><td colspan='7' width=400>".$task["project_description"]."</td>";
            $actual_project_id = $task["task_project"];
        }
        $sql = "select *
                from task_log
                where task_log_task = ".$task["task_id"]."
                order by task_log_date desc
                limit 1";
        db_loadHash($sql, $task_log);				

                                if ($task["task_priority"]==0) {$str = "Impacto Medio";}
		else if ($task["task_priority"]==-1) {$str = "Bajo Impacto";}
		else if ($task["task_priority"]==1) {$str = "Impacto Alto";}
 		else if ($task["task_priority"]==2) {$str = "Muy Alto Impacto";}
		else{$tasks1 .= "";}
			  echo "<tr><td>&nbsp;&nbsp;&nbsp;".$task["project_name"]."</td><td>&nbsp;&nbsp;&nbsp;".$task["task_name"]."</td><td width=400>".$task["task_description"]."</td><td>".$task["user_username"]."</td><td>".$task["task_end_date"]."</td><td>".$task_log["task_log_date"]."</td><td width=50>".$task["task_percent_complete"]."</td></tr>";
    }
}
?>
