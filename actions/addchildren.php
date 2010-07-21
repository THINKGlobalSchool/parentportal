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
		
	// admin only
	admin_gatekeeper();
	
	// must have security token 
	action_gatekeeper();
	
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
		
	if ($success) {
		// Save successful, forward to index
		system_message(elgg_echo("parentportal:confirm:addchildren"));
		forward($_SERVER['HTTP_REFERER']);
	} else {
		register_error(elgg_echo('parentportal:error:addchildren'));
		forward($_SERVER['HTTP_REFERER']);
	}
?>