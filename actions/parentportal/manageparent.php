<?php
/**
 * Add Children Action
 * 
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */
		
// get input
$parent 	= get_input('parent');
$children 	= get_input('children');
$enabled 	= get_input('parent_enabled');

$success = false;

// Check values and save
if ($user = get_user($parent)) {	
	$user->is_parent = $enabled;
	// Loop through and assign children
	if ($children) {
		foreach($children as $child) {
			assign_child_to_parent($child, $user->getGUID());
		}	
	}
	if ($user->save()) {
		$success = true;
	}
} 

if ($enabled) {
	// Set up relationship to add parent to channel
	$success &= add_entity_relationship($parent, 'shared_access_member', elgg_get_plugin_setting('parentchannel','parentportal'));
} else {
	// Remove from channel
	$success &= remove_entity_relationship($parent, 'shared_access_member', elgg_get_plugin_setting('parentchannel','parentportal'));
}
	
if ($success) {
	// Save successful, forward to index
	system_message(elgg_echo("parentportal:confirm:addchildren"));
	forward(REFERER);
} else {
	register_error(elgg_echo('parentportal:error:addchildren'));
	forward(REFERER);
}
