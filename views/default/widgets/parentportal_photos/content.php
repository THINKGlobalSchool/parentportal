<?php
/**
 * Parent portal child photos widget
 * 
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2013
 * @link http://www.thinkglobalschool.com/
 *
 */

$child = get_user($_SESSION['child_select']);

// Child tagged photos module
$photos_module = elgg_view('modules/genericmodule', array(
	'view' => 'parentportal/module/photos',
	'module_id' => 'pp-photos-module',
	'module_class' => 'pp-photos-module',
	'view_vars' => array('guid' => $child->guid), 
));

echo $photos_module;