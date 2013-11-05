<?php
/**
 * ParentPortal lib
 * 
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */

/* Page Functions - Used by page_handler */

/**
 * Get parent portal index content
 */
function parentportal_get_page_content_index($parent) {
	$url = elgg_get_site_url();

	$header = elgg_view_title(elgg_echo('parentportal:title:header'));
	
	$children = parentportal_get_parents_children($parent->getGUID());
	
	// Which tab are we looking at, default parent
	$tab = get_input('tab', 'parent');
	
	if (!in_array($tab, array('student', 'parent'))) {
		$tab = 'parent';
	}
	
	// If we're on the student tab without children, that's a no-no
	if ($tab == 'student' && !$children) {
		$tab = 'parent';
		set_input('tab', 'parent');
	}
	
	// Left column view extender
	$col_left .= elgg_view('parentportal/extend_left', array('tab' => $tab));
	
	// Right column view extender
	$col_right .= elgg_view('parentportal/extend_right', array('tab' => $tab));

	// Parent tab content
	if ($tab == 'parent') {

		$col_left .= elgg_view('modules/ajaxmodule', array(
			'title' => elgg_echo('School Documents'),
			'container_guid' => elgg_get_plugin_setting('parentgroup','parentportal'),
			'tag' => 'schooldocuments',
			'subtypes' => array('blog', 'bookmarks', 'file'),
			'limit' => 10,
			'listing_type' => 'simpleicon',
			'listing_type_override' => 'download_files',
			'restrict_tag' => TRUE,
			'module_type' => 'featured',
			'module_id' => 'parentportal-module-parent-announcements',
			'module_class' => 'parentportal-module',
			'hide_empty' => TRUE,
		));

		$col_left .= elgg_view('modules/ajaxmodule', array(
			'title' => elgg_echo('Travel Updates'),
			'container_guid' => elgg_get_plugin_setting('parentgroup','parentportal'),
			'tag' => 'wexplore',
			'subtypes' => array('blog', 'bookmarks', 'file'),
			'limit' => 10,
			'listing_type' => 'simpleicon',
			'listing_type_override' => 'download_files',
			'restrict_tag' => TRUE,
			'module_type' => 'featured',
			'module_id' => 'parentportal-module-parent-announcements',
			'module_class' => 'parentportal-module',
			'hide_empty' => TRUE,
		));
		
		$col_right .= elgg_view('modules/ajaxmodule', array(
			'title' => elgg_echo('weXplore Updates'),
			'container_guid' => elgg_get_plugin_setting('wexploregroup','parentportal'),
			'subtypes' => array('blog', 'thewire'),
			'listing_type' => 'simple',
			'listing_type_override' => 'download_files',
			'limit' => 5,
			'module_type' => 'featured',
			'module_id' => 'parentportal-module-parent-announcements',
			'module_class' => 'parentportal-module',
			'hide_empty' => TRUE,
	 	));

		$col_right .= elgg_view('modules/ajaxmodule', array(
			'title' => elgg_echo('parentportal:title:parentinformation'),
			'container_guid' => elgg_get_plugin_setting('parentgroup','parentportal'),
			//'tag' => elgg_get_plugin_setting('parenttag', 'parentportal'),
			'tag' => 'news',
			'subtypes' => array('blog', 'thewire'),
			'listing_type' => 'simple',
			'listing_type_override' => 'download_files',
			'restrict_tag' => TRUE,
			'limit' => 3,
			'module_type' => 'featured',
			'module_id' => 'parentportal-module-parent-announcements',
			'module_class' => 'parentportal-module',
			'hide_empty' => TRUE,
	 	));

		/**
		$col_right .= elgg_view('modules/ajaxmodule', array(
			'title' => elgg_echo('Res Life'),
			'container_guid' => elgg_get_plugin_setting('parentgroup','parentportal'),
			'tag' => 'reslife',
			'subtypes' => array('blog', 'thewire'),
			'listing_type' => 'simple',
			'restrict_tag' => TRUE,
			'limit' => 3,
			'module_type' => 'featured',
			'module_id' => 'parentportal-module-parent-announcements',
			'module_class' => 'parentportal-module',
			'hide_empty' => TRUE,
	 	));
		**/
		
		// Popup label/content
		$popup_label = elgg_echo('parentportal:label:whatisthis');
		$popup_info = elgg_echo('parentportal:label:weeklywhat');
		
		$weekly_title = elgg_echo('TGS Weekly') . "<span class='parentportal-small right'><a rel='popup' href='#info'>$popup_label</a><div id='info' class='parentportal-popup' style='display: none;'>$popup_info</div>";
		
		$col_right .= elgg_view('modules/ajaxmodule', array(
			'title' => $weekly_title,
			'tag' => 'tgsweekly',
			'subtypes' => array('tagdashboard'),
			'listing_type' => 'simpleicon',
			'restrict_tag' => TRUE,
			'limit' => 3,
			'module_type' => 'featured',
			'module_id' => 'parentportal-module-parent-announcements',
			'module_class' => 'parentportal-module',
			'hide_empty' => TRUE,
	 	));

		$col_right .= elgg_view('parentportal/module/questions');
	}

	if ($children) {
		// Set input for menu
		set_input('children', true);
		
		if ($tab == 'student') {
			if (count($children) > 1) {
				if (get_input('child_select')) {
					$_SESSION['child_select'] = get_input('child_select');
				}
				$child = get_user($_SESSION['child_select']);
			
				$form_vars = array(
					'action' => elgg_get_site_url() . 'parentportal?tab=student',
					'id' => 'parentportal-select-child-form'
				);
			
				$child_select = elgg_view_form('parentportal/childselect', $form_vars, array('children' => $children));	
			} 
		
			if (!$child) {
				$child = $children[0];
			}
		
			// Left content
			$col_left .= elgg_view('parentportal/module/profile', array('entity' => $child, 'section' => 'details'));
			
			// Activity Module					
			$activity_module .= elgg_view('modules/genericmodule', array(
				'view' => 'parentportal/module/activity',
				'module_id' => 'pp-activity-module',
				'module_class' => 'pp-activity-module',
				'view_vars' => array('guid' => $child->guid), 
			));

			$col_left .= elgg_view_module('featured', elgg_echo("parentportal:title:childactivity"), $activity_module, array(
				'id' => 'parentportal-module-child-activity',
				'class' => 'parentportal-module',
			));
			
			// Child tagged photos module
			$photos_module .= elgg_view('modules/genericmodule', array(
				'view' => 'parentportal/module/photos',
				'module_id' => 'pp-photos-module',
				'module_class' => 'pp-photos-module',
				'view_vars' => array('guid' => $child->guid), 
			));
			

			$col_left .= elgg_view_module('featured', elgg_echo("parentportal:title:childphotos"), $photos_module, array(
				'id' => 'parentportal-module-child-photos',
				'class' => 'parentportal-module',
			));
		
			// Check if todos is enabled
			if (elgg_is_active_plugin('todo')) {
				$col_right .= elgg_view('parentportal/module/todo_container', array('entity' => $child));
			}
		
			// Right content 
			$col_right .= elgg_view('parentportal/child_groups', array('child_guid' => $child->guid));
		}
	} 
	
	// Get the parentportal nav
	$header .= "<br />" . elgg_view_menu('parentportal-nav', array(
		'sort_by' => 'priority',
		// recycle the menu filter css
		'class' => 'elgg-menu-hz elgg-menu-filter elgg-menu-filter-default'
	));
	
	// Show selector
	$header .= "<br />" . $child_select;
	
	$params = array(
			'header' => $header,
			'left_column' => $col_left,
			'right_column' => $col_right,
			'title' => elgg_echo('parentportal'),
			'layout' => 'pp_header_two_column',
	);

	return $params;
}

/**
 * Get admin manage parent content
 */
function parentportal_get_page_content_manageparent($user_guid) {	
	$params = array();
	if ($user_guid) {	
		$user = get_user($user_guid);
	
		elgg_push_breadcrumb(sprintf(elgg_echo('parentportal:label:profile'), $user->name), elgg_get_site_url() . 'profile/' . $user->username);
		elgg_push_breadcrumb(elgg_echo('parentportal:menu:admin:manageparent'));
		
		$form_vars = array(
			'id' => 'manage-parent',
			'name' => 'manage_parent',
		);
		
		$params['content'] = elgg_view_form('parentportal/manageparent', $form_vars, array('user_guid' => $user_guid));
	} else {
		$params['content'] = elgg_echo('parentportal:error:unknown_username');
 	}
	
	$params['title'] = elgg_echo('parentportal:title:manageparent');
	$params['layout'] = 'one_sidebar';
	return $params;
}

function parentportal_get_page_content_user_settings() {
	$params = array();

	// Make sure we don't open a security hole ...
	if ((!elgg_get_page_owner_entity()) || (!elgg_get_page_owner_entity()->canEdit())) {
		elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());
	}
	
	$params['title'] = elgg_echo('parentportal:title:usersettings');
	$params['content'] = elgg_view('core/settings/account');
	$params['layout'] = 'one_sidebar';
	
	return $params;
}

/** Helper Functions **/

/**
 * Create a parent/child relationship for given child
 * 
 * @param int $child_guid
 * @param int $parent_guid
 * @return bool 
 */
function parentportal_assign_child_to_parent($child_guid, $parent_guid) {
	return add_entity_relationship($child_guid, PARENT_CHILD_RELATIONSHIP, $parent_guid);
}
	
/**
 * Return all children of a parent
 *
 * @param int $parent_guid
 * @return array 
 */
function parentportal_get_parents_children($parent_guid) {
	$parent = get_user($parent_guid);

	if ($parent) {
		// Options to sort users alphabetically
		$dbprefix = elgg_get_config('dbprefix');
		$alpha_options = array();
		$alpha_options['joins'] = array(
			"JOIN {$dbprefix}users_entity ue on e.guid = ue.guid"
		);
		$alpha_options['order_by'] = 'ue.name';

		if (elgg_is_active_plugin('roles') && roles_is_member(elgg_get_plugin_setting('view_students_role', 'parentportal'), $parent_guid)) {
			// If this parent/user is in the view all students role, display those users in the student role
			$students_role = elgg_get_plugin_setting('students_role', 'parentportal');
			$children = roles_get_members($students_role, 0, 0, null, false, true);
		} else if ($parent->isAdmin()) {
			$options = array('types' => array('user'), 'limit' => 0);
			$options = array_merge($alpha_options, $options);
			$children = elgg_get_entities($options);
		} else {
			$options = array(
				'relationship' => PARENT_CHILD_RELATIONSHIP,
				'relationship_guid' => $parent_guid,
				'inverse_relationship' => TRUE,
				'types' => array('user'),
				'limit' => 0,
				'offset' => 0,
				'count' => false,
			);
			$options = array_merge($alpha_options, $options);
			$children = elgg_get_entities_from_relationship($options);
		}	
	} 
	return $children ? $children : array();
}

/**
 * Determine if given user is a parent
 *
 * @param ElggUser $user
 * @return bool
 */
function parentportal_is_user_parent($user) {
	if ($user instanceof ElggUser) {
		return $user->is_parent;
	}
	return false;
}

function parentportal_gatekeeper() {
	$allowed = false;
	
	$parsed_url = parse_url(elgg_get_site_url());
	$base_url = $parsed_url['scheme'] . "://" . $parsed_url['host'];
	
	if ((isset($parsed_url['port'])) && ($parsed_url['port'])) {
	 	$base_url .= ":" . $parsed_url['port'];
	}

	$uri = preg_replace('#\?.*|\#.*#', '', $_SERVER['REQUEST_URI']);
	$url = $base_url . $uri;
		
	// Will be true for whitelist, false for blacklist
	$access_toggle = elgg_get_plugin_setting('urltoggle', 'parentportal');
	
	
	$url_list = elgg_get_plugin_setting('urllist','parentportal');;

	// Make sure the list isn't empty
	if (!empty($url_list)) {
		$url_list = explode("\n", $url_list);
	} else {
		$url_list = array();
	}
	
	if ($access_toggle) {
		// exceptions for blacklist
		array_push($url_list, '');
		array_push($url_list, '_css/js.php');
		array_push($url_list, '_css/css.css');
		array_push($url_list, 'parentportal');
		array_push($url_list, 'action/logout');
		array_push($url_list, 'mod/profile/icondirect.php');
	} 
	
	// Allowed is defaulted to the opposite (false for white, true for blacklist)
	$allowed = $access_toggle ? false : true;

	foreach($url_list as $u) {
		$u = trim($u);
		//if(strcmp($url, elgg_get_site_url() . $u) == 0) {
		if (strpos($url, $u)) {
			$allowed = $access_toggle ? true : false;
			break;
		}
	}
	
	if (!$allowed) {
	    register_error(elgg_echo('parentportal:error:nopermissions')); 
	    forward('parentportal');
	}
}

/**
 * Get current child (for use in widgets) 
 * 
 * @return mixed Array of child info, or false if no children/current
 */
function parentportal_get_widget_child_info() {
	$children = parentportal_get_parents_children(elgg_get_logged_in_user_guid());

	if (count($children) > 1) {
		if (get_input('child_select')) {
			$_SESSION['child_select'] = get_input('child_select');
			$child = get_user($_SESSION['child_select']);
		} else {
			$child = $children[0];
			$_SESSION['child_select'] = $child->guid;
		}
	} else if (count($children) == 1) {
		$child = $children[0];
		$_SESSION['child_select'] = $child->guid;
	} else {
		return false;
	}

	$child_info = array(
		'current_child' => $child,
		'children' => $children
	);

	return $child_info;
}

/** 
 * Compare given entities by date updated
 *  
 * @param ElggEntity $a 
 * @param ElggEntity $b
 * @return bool
 */
function compare_entities_updated_dates($a, $b) {
	if ($a->time_updated == $b->time_updated) {
		return 0;
	}
	return ($a->time_updated > $b->time_updated) ? -1 : 1;
}
