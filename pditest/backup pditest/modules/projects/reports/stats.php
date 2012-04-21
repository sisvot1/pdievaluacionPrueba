<?php
if (!defined('DP_BASE_DIR')) {
  die('You should not access this file directly.');
}

function file_size($size)
{
	if (empty($size))
		return '0 B';
        if ($size > 1024*1024*1024)
                return round($size / 1024 / 1024 / 1024, 2) . ' Gb';
        if ($size > 1024*1024)
                return round($size / 1024 / 1024, 2) . ' Mb';
        if ($size > 1024)
                return round($size / 1024, 2) . ' Kb';
        return $size . ' B';
}

$sql = '
SELECT *, round(sum(task_log_hours),2) as work
FROM projects
LEFT JOIN tasks ON task_project = project_id
LEFT JOIN user_tasks ON user_tasks.task_id = tasks.task_id
LEFT JOIN users ON user_tasks.user_id = users.user_id
LEFT JOIN task_log ON task_log_task = tasks.task_id AND task_log_creator = users.user_id';
if (!empty($project_id))
	$sql .= ' WHERE project_id = ' . $project_id;
$sql .= ' GROUP BY tasks.task_id, users.user_id';
$users_all = db_loadList($sql);

foreach ($users_all as $user)
{
	$users_per_task[$user['task_id']][] = $user['user_id'];
	$users[$user['user_id']]['all'][$user['task_id']] = $user;
	$users[$user['user_id']]['name'] = (!empty($user['user_username']))?$user['user_username']:$user['user_id'];
	$users[$user['user_id']]['hours'] = 0;
	$users[$user['user_id']]['completed'] = array();
	$users[$user['user_id']]['inprogress'] = array();
//	$users[$user['user_id']]['pending'] = array();
	$users[$user['user_id']]['overdue'] = array();
}

$tasks['hours'] = 0;
$tasks['inprogress'] = array();
$tasks['completed'] = array();
//$tasks['pending'] = array();
$tasks['overdue'] = array();
$sql = '
SELECT sum(file_size)
FROM files
WHERE file_project = ' . $project_id . '
GROUP BY file_project';
$files = db_loadResult($sql);
//$ontime = round(100 * (1 - (count($tasks['overdue']) / count($all_tasks)) - (count($tasks['completed']) / count($all_tasks))));

?>
<table width="100%" border="1" cellpadding="0" cellspacing="0" class="tbl">
<tr>
	<th colspan="3"><?php echo $AppUI->_('Progress Chart (completed/in progress)'); ?></th>
</tr>


<table class="tbl">
<tr>
	<td>


<table width="100%" cellspacing="1" cellpadding="4" border="0" class="tbl">
<tr>
	<th colspan="2"><?php echo $AppUI->_('Detalle el proyecto'); ?></th>
</tr>
<tr>
	<td><?php echo $AppUI->_('No. Persona asignadas'); ?>:</td>
	<td><?php echo count($users); ?> <?php echo $AppUI->_('users'); ?></td>
</tr>
</table>
<br />

<table width="100%" cellspacing="1" cellpadding="4" border="0" class="tbl">
<tr>
	<th colspan="2"><?php echo $AppUI->_('Espacio utilizado en documentos'); ?></th>
</tr>
<tr>
	<td><?php echo $AppUI->_('Space Utilized'); ?>:</td>
	<td nowrap="nowrap"><?php echo file_size($files); ?></td>
</tr>
</table>
	</td>
	<td width="100%" valign="top">
<table width="100%" cellspacing="1" cellpadding="4" border="0" class="tbl">
<tr>
	<th><?php echo $AppUI->_('Meta asignada'); ?></th>

	<th><?php echo $AppUI->_('Metas atrasadas'); ?></th>
	<th><?php echo $AppUI->_('En progreso'); ?></th>
	<th><?php echo $AppUI->_('Metas completadas'); ?></th>
	<th><?php echo $AppUI->_('Total de metas'); ?></th>
	</tr>
<?php foreach ($users as $user => $stats) {?>
<tr>
	<td><?php echo $stats['name']; ?></td>

	<td><?php echo count($stats['overdue']); ?></td>
	<td><?php echo count($stats['inprogress']); ?></td>
	<td><?php echo count($stats['completed']); ?></td>
	<td><?php echo count($stats['all']); ?></td>
	</tr>
<?php } ?>
<tr>
	<td class="highlight"><?php echo $AppUI->_('Total'); ?>:</td>
	<td class="highlight"><?php echo count($tasks['inprogress']); ?></td>
	<td class="highlight"><?php echo count($tasks['completed']); ?></td>
	<td class="highlight"><?php echo count($all_tasks); ?></td>
	</tr>
</table>
	</td>
</tr>
</table>
