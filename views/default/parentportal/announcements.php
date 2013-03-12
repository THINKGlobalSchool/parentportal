<?php
/**
 * ParentPortal announcements view
 * 
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */

$container_guid = elgg_get_plugin_setting('parentgroup','parentportal');
$announcement_tag = elgg_get_plugin_setting('parentannouncementtag','parentportal');

$options = array(
	'type' => 'object',
	'subtype' => 'announcement',
	'limit' => 25,
);

// Ignore expired announcements
$options['metadata_name_value_pairs'] = array(
	array(
		'name' => 'expiry_date', 
		'value' => time(),
		'operand' => '>',
	),
);

// Joins for announcement tag metadata
$dbprefix = elgg_get_config('dbprefix');

$joins[] = "JOIN {$dbprefix}metadata tmd on tmd.entity_guid = e.guid";
$joins[] = "JOIN {$dbprefix}metastrings tmsv on tmsv.id = tmd.value_id";
$joins[] = "JOIN {$dbprefix}metastrings tmsn on tmd.name_id = tmsn.id";

$options['joins'] = $joins;

// Container where clause
$container_sql = "e.container_guid IN ({$container_guid})";

$access_sql = get_access_sql_suffix('tmd');

// Tag sql where clause
$tag_sql = "
	(
		(tmsn.string IN ('tags')) AND ( BINARY tmsv.string IN ('{$announcement_tag}')) 
		AND
		$access_sql
	)
";

// Combine wheres
$options['wheres'] = "
	(
		$container_sql
		OR
		$tag_sql
	)
"; 

// Grab announcements
$announcements = elgg_get_entities_from_metadata($options);

foreach($announcements as $announcement) {	
	// Check if the announcement has been viewed
	if (!check_entity_relationship(elgg_get_logged_in_user_guid(), 'has_viewed_announcement', $announcement->getGUID())) {
		$announcements_content .= elgg_view('announcements/announcement', array('entity' => $announcement));
	}
}

echo $announcements_content;