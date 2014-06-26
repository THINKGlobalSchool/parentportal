<?php
/**
 * Parent portal 'forparents' activity widget
 * 
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2013
 * @link http://www.thinkglobalschool.com/
 *
 */
elgg_push_context('parentportal_activity_widget');

echo elgg_view('filtrate/dashboard', array(
	'menu_name' => 'activity_filter',
	'infinite_scroll' => false,
	'default_params' => array(
		'type' => 0,
		'role' => 0,
		'tag' => 'forparents'
	),
	'list_url' => elgg_get_site_url() . 'ajax/view/tgstheme/activity_list',
	'disable_advanced' => true,
	'disable_history' => true,
	'ignore_query_string' => true,
	'id' => 'activity-filtrate-parents'
));