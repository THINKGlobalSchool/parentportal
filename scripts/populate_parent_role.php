<?php
/**
 * Populate parent role with existing parents
 */
require_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");
admin_gatekeeper();

echo elgg_view_title('Populate Parent Role');

$go = get_input('go', false);

echo "<pre>";

$parents = elgg_get_entities_from_metadata(array(
	'type' => 'user',
	'metadata_name' => 'is_parent',
	'metadata_value' => 1
));

$parent_role_guid = elgg_get_plugin_setting('parents_role','parentportal');
$parent_role = get_entity($parent_role_guid);

if (!elgg_instanceof($parent_role, 'object', 'role')) {
	echo 'Invalid parent role! Check settings';
	exit;
}

foreach ($parents as $parent) {
	if ($go) {
		$success = '--> Added to role!';
		$parent_role->add($parent);
	}
	echo "{$parent->guid} - {$parent->name} {$success}<br />";
}

echo "</pre>";