<?php
/**
 * Parent portal child activity widget
 * 
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2013
 * @link http://www.thinkglobalschool.com/
 *
 */

$child = get_user(get_input('child_select', $_SESSION['child_select']));

$activity_module .= elgg_view('modules/genericmodule', array(
	'view' => 'parentportal/module/activity',
	'module_id' => 'pp-activity-module',
	'module_class' => 'pp-activity-module',
	'view_vars' => array('guid' => $child->guid), 
));

echo $activity_module;