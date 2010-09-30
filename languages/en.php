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
		'parentportal:confirm:questionsent' => "Your question was successfully submitted",
	
		// Errors
		'parentportal:error:unknown_username' => "Unknown Username",
		'parentportal:error:addchildren' => "Error updating user",
		'parentportal:error:clearchildren' => "Error clearing children",
		'parentportal:error:to' => 'Required field \'to\' is missing',
		'parentportal:error:from' => 'Required field \'from\' is missing',
		'parentportal:error:subject' => 'Required field \'subject\' is missing',
		'parentportal:error:body' => 'Required field \'message\' is missing',
		'parentportal:error:questionsent' => "There was an error submitting your question",
		
		// Titles/Label
		'parentportal:title:manageparent' => "Create/Manage Parent Settings",
		'parentportal:title:header' => 'Welcome to the THINK Spot Parent Portal',
		'parentportal:title:childinfo' => 'Your Child', 
		'parentportal:title:parentinfo' => 'Parent Information',
		'parentportal:title:parentannouncements' => 'Announcements',
		'parentportal:title:parentquestions' => 'Ask a Question >>',
		'parentportal:title:parentinfocenter' => 'Information Center',
		'parentportal:title:childactivity' => 'Your Child\'s Recent Activity', 
		'parentportal:title:childtodos' => 'Your Child\'s To Do\'s', 
		'parentportal:label:profile' => "%s's Profile", 
		'parentportal:label:enableparent' => "Parent Enabled", 
		'parentportal:label:childselect' => "Select Child",
		'parentportal:label:currentchildren' => "Current Children",
		'parentportal:label:clearchildren' => "Clear Current Children",
		'parentportal:label:urltoggle' => "URL List Toggle (List behaves as either a whitelist or blacklist)",
		'parentportal:label:urllist' => "URL List (relative to site root, ie: pg/activity)",
		'parentportal:label:blacklist' => "Blacklist",
		'parentportal:label:whitelist' => "Whitelist", 
		'parentportal:label:nochildren' => "Sorry. You have no Children",
		'parentportal:label:parentchannel' => 'Parent Channel',
		'parentportal:label:parentcontacts' => 'Parent Portal Contacts',
		'parentportal:label:noannouncements' => 'No Announcements',
		'parentportal:label:havequestions' => 'Have a question? Use the form below and we\'ll get back to you!',
		'parentportal:label:questionto' => 'To: ',
		'parentportal:label:questionfrom' => 'From (Your Email)',
		'parentportal:label:questionsubject' => 'Subject',
		'parentportal:label:questionbody' => 'Message',
		'parentportal:label:selectchild' => 'Select Child: ',
		
		// Other
		
	
	);

	add_translation('en',$english);
?>