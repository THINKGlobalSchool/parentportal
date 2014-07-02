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
	'admin:administer_utilities:question_log' => 'Parent Question Log',
	
	// Menu's
	'parentportal:menu:admin:manageparent' => "Manage Parent",
	'parentportal:menu:home' => 'Parent Portal Home',
	'parentportal:menu:logout' => 'Logout',
	'parentportal:menu:spothome' => 'Spot Home',

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
	'parentportal:error:invalidparentgroup' => 'Parent group is invalid or not configured',
	'parentportal:error:nopermissions' => 'You do not have permission to view this page',
	'parentportal:error:questionlog' => 'Error saving question to log',
	'parentportal:error:invaliduser' => 'Invalid \'to\' user',
	'parentportal:error:invalidparentrole' => 'Invalid Parent Role',
	
	// Titles/Label
	'parentportal:title:manageparent' => "Create/Manage Parent Settings",
	'parentportal:title:header' => 'Welcome to the THINK Spot Parent Portal',
	'parentportal:title:childinfo' => 'Your Child', 
	'parentportal:title:parentinfo' => 'Parent Information',
	'parentportal:title:parentinformation' => 'News and Bulletins',
	'parentportal:title:parentquestions' => 'Ask a Question',
	'parentportal:title:parentinfocenter' => 'Information Center',
	'parentportal:title:childactivity' => 'Your Child\'s Recent Activity', 
	'parentportal:title:childgroups' => 'Your Child\'s Groups', 
	'parentportal:title:childtodos' => 'Your Child\'s To Do\'s', 
	'parentportal:title:usersettings' => 'User Settings', 
	'parentportal:title:childphotos' => 'Photo\'s tagged with your child',
	'parentportal:title:url_filtering' => 'URL Filtering',
	'parentportal:title:group_settings' => 'Group Settings',
	'parentportal:title:tag_settings' => 'Tag Settings',
	'parentportal:title:role_settings' => 'Role Settings',
	
	'parentportal:label:profile' => "%s's Profile", 
	'parentportal:label:enableparent' => "Parent Enabled", 
	'parentportal:label:childselect' => "Select Child",
	'parentportal:label:currentchildren' => "Current Children",
	'parentportal:label:clearchildren' => "Clear Current Children",
	'parentportal:label:urltoggle' => "URL List Toggle (List behaves as either a whitelist or blacklist)",
	'parentportal:label:urllist' => "URL List (relative to site root, ie: activity)",
	'parentportal:label:blacklist' => "Blacklist",
	'parentportal:label:whitelist' => "Whitelist", 
	'parentportal:label:nochildren' => "Sorry. You have no Children",
	'parentportal:label:parentgroup' => 'Parent Group',
	'parentportal:label:wexploregroup' => 'weXplore Group',
	'parentportal:label:parentcontacts' => 'Parent Portal Contacts',
	'parentportal:label:noannouncements' => 'No News',
	'parentportal:label:havequestions' => 'Have a question? Use the form below and we\'ll get back to you!',
	'parentportal:label:questionto' => 'To: ',
	'parentportal:label:questionfrom' => 'From (Your Email)',
	'parentportal:label:questionsubject' => 'Subject',
	'parentportal:label:questionbody' => 'Message',
	'parentportal:label:selectchild' => 'Select Child: ',
	'parentportal:label:todo:complete' => 'Complete To Do\'s',
	'parentportal:label:todo:incomplete' => 'Upcoming To Do\'s',
	'parentportal:label:todo:pastdue' => 'Past Due To Do\'s',
	'parentportal:label:parenttag' => 'Parent Tag (for including blogs/wire posts in news and bulletins)',
	'parentportal:label:parentannouncementtag' => 'Parent Announcement Tag (for including general announcements)',
	'parentportal:label:noresults' => 'No Results',
	'parentportal:label:editsettings' => 'Edit your settings',
	'parentportal:label:editprofile' => 'Edit profile',
	'parentportal:label:spotquestion' => 'Spot Parent Portal Question: %s',
	'parentportal:label:viewstudents' => 'View all students role',
	'parentportal:label:studentsrole' => 'Student Role (Restrict users displayed in View all students role to these users)', 
	'parentportal:label:parentsrole' => 'Parents Role', 
	'parentportal:label:whatisthis' => 'What is this?',
	'parentportal:label:weeklywhat' => 'A digest containing the highlights of the week at TGS as created and curated by students and staff.',
	'parentportal:label:viewmessagebody' => 'View Message Body',
	'parentportal:label:question_status' => 'Status',
	'parentportal:label:question_status_text' => 'Status Text',	
	'parentportal:label:tagforparents' => 'Tag For Parents',
	'parentportal:label:viewallactivity' => 'View All Activity',

	// Stat labels
	'parentportal:stats:blog' => 'Blog Posts',
	'parentportal:stats:photo' => 'Photos',
	'parentportal:stats:bookmark' => 'Bookmarks',
	'parentportal:stats:rubric' => 'Rubrics',
	'parentportal:stats:group' => 'Groups',
	'parentportal:stats:todo' => 'Complete To Do\'s',
	
	// Widgets
	'parentportal:widget:childprofile_title' => 'Your Child',
	'parentportal:widget:news_title' => 'News and Bulletins',
	'parentportal:widget:question_title' => 'Ask a Question',
	'parentportal:widget:schooldocs_title' => 'School Documents',
	'parentportal:widget:travelupdates_title' => 'Travel Updates',
	'parentportal:widget:wexplore_title' => 'weXplore Updates',
	'parentportal:widget:groups_title' => 'Your Child\'s Groups',
	'parentportal:widget:reports_title' => 'Report Cards',
	'parentportal:widget:activity_title' => 'Your Child\'s Recent Activity',
	'parentportal:widget:todos_title' => 'Your Child\'s To Do\'s',
	'parentportal:widget:photos_title' => 'Photos Tagged With Your Child',
	'parentportal:widget:forparentsactivity_title' => 'Parent Feed',

	'parentportal:widget:childprofile_desc' => 'Displays Child Profile Info',
	'parentportal:widget:news_desc' => 'Display News and Bulletins',
	'parentportal:widget:question_desc' => 'Display the question form',
	'parentportal:widget:schooldocs_desc' => 'Display school documents',
	'parentportal:widget:travelupdates_desc' => 'Display travel updates',
	'parentportal:widget:wexplore_desc' => 'Display wexplore updates',
	'parentportal:widget:groups_desc' => 'Display list of child groups',
	'parentportal:widget:reports_desc' => 'Display child report cards',
	'parentportal:widget:activity_desc' => 'Display child activity',
	'parentportal:widget:todos_desc' => 'Display child todos',
	'parentportal:widget:photos_desc' => 'Display child tagged photos',
	'parentportal:widget:forparentsactivity_desc' => 'Display activity for items tagged \'forparents\'',

	// Other
	

);

add_translation('en',$english);
