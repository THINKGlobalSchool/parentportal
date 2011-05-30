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
	$header .= "<span style='float: right; display: block;'><a href='{$url}parentportal/settings'>Edit your settings</a></span>";
	$header .= elgg_view_title(elgg_echo('parentportal:title:header'));
	
	$children = parentportal_get_parents_children($parent->getGUID());
	
	// Which tab are we looking at, default parent
	$tab = get_input('tab', 'parent');
	
	if ($tab != 'parent' || $tab != 'student') {
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
			'title' => 'Welcome Documents',
			'container_guid' => elgg_get_plugin_setting('parentgroup','parentportal'),
			'tag' => 'welcome',
			'subtypes' => array('file'),
			'limit' => 5,
			'module_type' => 'featured',
			'module_id' => 'parentportal-module-welcome-documents',
			'module_class' => 'parentportal-module',
		));
		
		
		$col_right .= elgg_view('modules/ajaxmodule', array(
			'title' => elgg_echo('parentportal:title:parentinformation'),
			'container_guid' => elgg_get_plugin_setting('parentgroup','parentportal'),
			'tag' => elgg_get_plugin_setting('parenttag', 'parentportal'),
			'subtypes' => array('blog', 'thewire'),
			'listing_type' => 'simple',
			'limit' => 3,
			'module_type' => 'featured',
			'module_id' => 'parentportal-module-parent-announcements',
			'module_class' => 'parentportal-module',
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
			$col_left .= elgg_view('parentportal/module/activity', array('entity' => $child));
		
			// Right content 
			$col_right .= elgg_View('parentportal/module/groups', array('entity' => $child));
		
			// Check if todos is enabled
			if (elgg_is_active_plugin('todo')) {
				$col_right .= elgg_view('parentportal/module/todos', array('entity' => $child));
			}
		
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
		set_page_owner(elgg_get_logged_in_user_guid());
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
		if (!$parent->isAdmin()) {
			$children = elgg_get_entities_from_relationship(array(
														'relationship' => PARENT_CHILD_RELATIONSHIP,
														'relationship_guid' => $parent_guid,
														'inverse_relationship' => TRUE,
														'types' => array('user'),
														'limit' => 9999,
														'offset' => 0,
														'count' => false,
													));
		} else {
			$children = elgg_get_entities(array('types' => array('user'), 'limit' => 9999));
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
	
	$url_list = elgg_get_plugin_setting('urllist','parentportal');
	$url_list = explode("\n", $url_list);
	
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
		if(strcmp($url, elgg_get_site_url() . $u) == 0) {
			$allowed = $access_toggle ? true : false;
			break;
		}
	}
	
	if (!$allowed) {
	    //register_error(elgg_echo('parentportal')); 
	    forward('parentportal');
	}
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
