<?php
	/**
	 * Clear Children Action
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
	$parent = get_input('parent');
				
	$success = false;

	// Check values and save
	if ($user = get_user($parent)) {	
		$children = get_parents_children($parent); 
		foreach ($children as $child) {
	 		remove_entity_relationship($child->getGUID(),PARENT_CHILD_RELATIONSHIP, $parent);
		}
	} 
		
	if ($success) {
		// Save successful, forward to index
		system_message(elgg_echo("parentportal:confirm:clearchildren"));
		forward($_SERVER['HTTP_REFERER']);
	} else {
		register_error(elgg_echo('parentportal:error:clearchildren'));
		forward($_SERVER['HTTP_REFERER']);
	}
?>