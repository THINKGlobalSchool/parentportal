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

$options = array(
	'type' => 'object',
	'subtype' => 'announcement',
	'limit' => 25,
	'container_guid' => elgg_get_plugin_setting('parentgroup','parentportal'),
);

// Ignore expired announcements
$options['metadata_name_value_pairs'] = array(
	array(
		'name' => 'expiry_date', 
		'value' => time(),
		'operand' => '>',
	),
);

// Grab announcements
$announcements = elgg_get_entities_from_metadata($options);

foreach($announcements as $announcement) {	
	// Check if the announcement has been viewed
	if (!check_entity_relationship(elgg_get_logged_in_user_guid(), 'has_viewed_announcement', $announcement->getGUID())) {
		$announcements_content .= elgg_view('announcements/announcement', array('entity' => $announcement));
	}
}

echo $announcements_content;