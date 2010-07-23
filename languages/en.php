<?php
	/**
	 * Parent portal language file
	 * 
	 * @package ParentPortal
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Jeff Tilson
	 * @copyright THINK Global School 2010
	 * @link http://www.thinkglobalschool.com/
	 * 
	 */
	
	$english = array(
		
		// Default Content & Entity/Object Related
		'parentportal' => 'Parent Portal',
		
		// Menu's
		'parentportal:menu:admin:manageparent' => "Manage Parent",

		// Actions
		
		// Action labels
	
		// Confirmations
		'parentportal:confirm:addchildren' => "User Updated",
		'parentportal:confirm:clearchildren' => "Children Cleared",
	
		// Errors
		'parentportal:error:unknown_username' => "Unknown Username",
		'parentportal:error:addchildren' => "Error updating user",
		'parentportal:error:clearchildren' => "Error clearing children",
			
		// Titles/Label
		'parentportal:title:manageparent' => "Create/Manage Parent Settings",
		'parentportal:label:profile' => "%s's Profile", 
		'parentportal:label:enableparent' => "Parent Enabled", 
		'parentportal:label:childselect' => "Select Child",
		'parentportal:label:currentchildren' => "Current Children",
		'parentportal:label:clearchildren' => "Clear Current Children",
		'parentportal:label:urltoggle' => "URL List Toggle (List behaves as either a whitelist or blacklist)",
		'parentportal:label:urllist' => "URL List (relative to site root, ie: pg/activity)",
		'parentportal:label:blacklist' => "Blacklist",
		'parentportal:label:whitelist' => "Whitelist", 
		
		// Other
		
	
	);

	add_translation('en',$english);
?>