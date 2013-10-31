<?php
/**
 * Parent portal news widget
 * 
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2013
 * @link http://www.thinkglobalschool.com/
 *
 */
elgg_load_js('elgg.parentportal');
elgg_load_css('elgg.parentportal');

echo elgg_view('modules/ajaxmodule', array(
	'container_guid' => elgg_get_plugin_setting('parentgroup','parentportal'),
	//'tag' => elgg_get_plugin_setting('parenttag', 'parentportal'),
	'tag' => 'news',
	'subtypes' => array('blog', 'thewire'),
	'listing_type' => 'simple',
	'listing_type_override' => 'download_files',
	'restrict_tag' => TRUE,
	'limit' => 3,
	'hide_empty' => TRUE,
));