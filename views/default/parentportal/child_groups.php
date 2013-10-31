<?php
/**
 * ParentPortal Child stats view
 * 
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com
 */

// Groups Module					
$groups_module .= elgg_view('modules/genericmodule', array(
	'view' => 'parentportal/module/groups',
	'module_id' => 'pp-groups-module',
	'module_class' => 'pp-groups-module',
	'view_vars' => array('guid' => $vars['child_guid']), 
));

echo $groups_module;