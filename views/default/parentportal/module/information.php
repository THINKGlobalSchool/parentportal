<?php
/**
 * Parent Portal information module
 * 
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */

$title = elgg_echo('parentportal:title:parentinformation');

$limit = get_input('limit', 20);
$offset = get_input('offset', 0);

$group = get_entity(elgg_get_plugin_setting('parentgroup','parentportal'));

$tag = elgg_get_plugin_setting('parenttag', 'parentportal');

$entities = elgg_get_entities(array(
	'type' => 'object',
	'subtypes' => array('blog', 'thewire'),
	'container_guid' => $group->getGUID(),
	//'group_by' => 'e.guid', ...why??
	'limit' => 0,
));

if ($tag) {
	$tag_entities = elgg_get_entities_from_metadata(array(
		'type' => 'object',
		'subtypes' => array('blog', 'thewire'),
		'metadata_name_value_pairs' => array(	'name' => 'tags', 
												'value' => $tag, 
												'operand' => '=',
												'case_sensitive' => FALSE),
		'limit' => 0,
	));
}

// Make sure we have something 
if (!$entities) {
	$entities = array();
}

if (!$tag_entities) {
	$tag_entities = array();
}

$entities = array_merge($entities, $tag_entities);
usort($entities, "compare_entities_updated_dates");	

$entities = array_slice($entities, $offset, $limit);

foreach ($entities as $idx => $entity) {
	// Display entities in their custom container
	$body .=  elgg_view('parentportal/infoitem', array('entity' => $entity));
}

if (!$body) {
	$body .= '<center>' . elgg_echo('parentportal:label:noannouncements') . '</center>';
}

$options = array(
	'id' => 'parentportal-module-parent-announcements',
	'class' => 'parentportal-module',
);

echo elgg_view_module('featured', $title, $body, $options);
