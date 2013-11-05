<?php
/**
 * ParentPortal child role dashboard preload
 * 
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2013
 * @link http://www.thinkglobalschool.com/
 * 
 */

$parent_role_guid = elgg_get_plugin_setting('parents_role','parentportal');
$parent_role = get_entity($parent_role_guid);

$view_all_role_guid = elgg_get_plugin_setting('view_students_role', 'parentportal');
$view_all_role = get_entity($view_all_role_guid);

if (elgg_instanceof($parent_role, 'object', 'role') && $parent_role->isMember() || $view_all_role->isMember()) {
	$child_info = parentportal_get_widget_child_info();
}
