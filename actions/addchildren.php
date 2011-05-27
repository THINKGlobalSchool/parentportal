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
	foreach($children as $child) {
		assign_child_to_parent($child, $user->getGUID());
	}	
	if ($user->save()) {
		$success = true;
	}
} 

// Get group
$group = get_entity(get_plugin_setting('parentgroup','parentportal'));
if (!elgg_instanceof($group, 'group')) {
	register_error(elgg_echo('parentportal:error:invalidparentgroup'));
	forward(REFERER);
}

if ($enabled) {
	// access ignore so user can be added to access collection of invisible group
	$ia = elgg_set_ignore_access(TRUE);
	// This is stupid.. but need to set the page owner here to the group otherwise the
	// Group ACL isn't available
	set_page_owner($group->guid);
	$success &= $group->join($user);
	elgg_set_ignore_access($ia);

	if ($success) {
		// flush user's access info so the collection is added
		get_access_list($user->guid, 0, true);

		// Remove any invite or join request flags
		remove_entity_relationship($group->guid, 'invited', $user->guid);
		remove_entity_relationship($user->guid, 'membership_request', $group->guid);
	}
} else {
	// Remove parent from group
	$success &= $group->leave($user);
}
	
if ($success) {
	// Save successful, forward to index
	system_message(elgg_echo("parentportal:confirm:addchildren"));
	forward($_SERVER['HTTP_REFERER']);
} else {
	register_error(elgg_echo('parentportal:error:addchildren'));
	forward($_SERVER['HTTP_REFERER']);
}
?>