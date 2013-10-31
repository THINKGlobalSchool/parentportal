<?php
/**
 * Parent portal report card widget
 * 
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2013
 * @link http://www.thinkglobalschool.com/
 *
 */

$child = get_user(get_input('child_select', $_SESSION['child_select']));

// Create group module				
$module = elgg_view('modules/genericmodule', array(
	'view' => 'reportcards/modules/reportcards',
	'module_id' => 'reportcards-module',
	'view_vars' => array(
		'owner_guid' => $child->guid,
		'display' => 'latest',
		'period' => 'all',
		'year' => 'all',
		'parent_mode' => TRUE, // Set parent mode
	), 
));

echo "<div class='reportcard-pp-module'>";
echo $module;
echo "</div>";