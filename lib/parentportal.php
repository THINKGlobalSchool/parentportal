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

/** Page Functions - Used by page_handler **/

function parentportal_get_page_content_index($parent) {	
	global $CONFIG;
	
	$header .= "<span style='float: right; display: block;'>";
	$header .= "<a href='{$CONFIG->wwwroot}pg/profile/" . get_loggedin_user()->username . "'>Your Profile</a>";
	$header .= " | <a href='{$CONFIG->wwwroot}pg/friends/" . get_loggedin_user()->username ." '>Friends</a>";
	$header .= " | <a href='{$CONFIG->wwwroot}pg/parentportal/settings'>Edit your settings</a>";
	$header .= "</span>";
	$header .= elgg_view_title(elgg_echo('parentportal:title:header'));
	
	// Definitely need a better way of building the content..
	$children = get_parents_children($parent->getGUID());
	
	// I'm doing this here for now, and I'll make this pretty for 1.8 
	$tab = get_input('tab');
	switch($tab) {
		case 'student':
			if ($children) {
				$student_selected = "class='selected'";
			} else {
				$parent_selected = "class='selected'";
			}
			break;
		case 'parent':
		default:
			$parent_selected = "class='selected'";
			break;
	}
	
	
	if ($parent_selected) {	
		$col_left .= elgg_view('modules/ajaxmodule', array(
			'title' => elgg_echo('Student Services Info'),
			'container_guid' => get_plugin_setting('parentgroup','parentportal'),
			'tag' => 'studentservices',
			'subtypes' => array('blog', 'bookmarks', 'document'),
			'limit' => 10,
			'listing_type' => 'simpleicon',
			'restrict_tag' => TRUE,
			'header_class' => 'pp',
		));
	
	
		$col_left .= elgg_view('modules/ajaxmodule', array(
			'title' => elgg_echo('weXplore Info'),
			'container_guid' => get_plugin_setting('parentgroup','parentportal'),
			'tag' => 'wexplore',
			'subtypes' => array('blog', 'bookmarks', 'document'),
			'limit' => 10,
			'listing_type' => 'simpleicon',
			'restrict_tag' => TRUE,
			'header_class' => 'pp',
		));
		
		
		/*
		$col_right .= elgg_view('modules/ajaxmodule', array(
			'title' => 'Welcome Documents',
			'container_guid' => get_plugin_setting('parentgroup','parentportal'),
			'tag' => 'welcome',
			'subtypes' => array('document'),
			'limit' => 5,
			'header_class' => 'pp',
		));
		*/
	
		$col_right .= elgg_view('modules/ajaxmodule', array(
			'title' => elgg_echo('parentportal:title:parentannouncements'),
			'container_guid' => get_plugin_setting('parentgroup','parentportal'),
			'tag' => get_plugin_setting('parenttag', 'parentportal'),
			'subtypes' => array('blog'),
			'listing_type' => 'simple',
			'limit' => 3,
			'header_class' => 'pp',
		));
	
		$col_right .= elgg_view('parentportal/parent_questions');
	}	
		
	if ($children) {
		
		$student_tab = "<li $student_selected ><a href='?tab=student'>" . elgg_echo('parentportal:title:childinfo') . "</a></li>";
		
		if ($student_selected) {
			
			if (count($children) > 1) {
				if (get_input('child_select')) {
					$_SESSION['child_select'] = get_input('child_select');
				}
				$child = get_user($_SESSION['child_select']);
				$child_select = elgg_view('parentportal/forms/child_select', array('children' => $children));	
			}

			if (!$child) {
				$child = $children[0];
			}
			
			$col_left .= elgg_view('parentportal/child_profile', array('entity' => $child, 'section' => 'details'));
			$col_left .= elgg_view('parentportal/child_activity', array('entity' => $child));

			$col_right .= elgg_View('parentportal/child_groups', array('entity' => $child));

			if (is_plugin_enabled('announcements')) {
				$col_right .= elgg_view('parentportal/sticky_announcement_container', array('sac' => $sac));
			}

			$col_right .= elgg_view('parentportal/child_todos', array('entity' => $child));
			//$col_left .= elgg_view('parentportal/parent_infocenter', array('entity' => $child, 'section' => 'details'));
		}		
	} 
	
	
	$header .= "<div class='elgg_horizontal_tabbed_nav'>
		<br />
		<ul>
			<li $parent_selected ><a href='?tab=parent'>" . elgg_echo('parentportal:title:parentinfo') . "</a></li>
			$student_tab
		</ul>
	</div>
	$child_select";
	
	
	
	return array(
		'top' => $header,
		'left_column' => $col_left,
		'right_column' => $col_right,
	);
}

function parentportal_get_page_content_manageparent($user_guid) {
	global $CONFIG;
	
	if ($user_guid) {	
		$user = get_user($user_guid);
	
		elgg_push_breadcrumb(sprintf(elgg_echo('parentportal:label:profile'), $user->name), $CONFIG->url . 'pg/profile/' . $user->username);
		elgg_push_breadcrumb(elgg_echo('parentportal:menu:admin:manageparent'));
		
		$content = elgg_view_title(elgg_echo('parentportal:title:manageparent'));
		$content .= elgg_view('parentportal/forms/manage_parent', array('user_guid' => $user_guid));
	}
	
	return array('content' => $content);
}

/** Helper Functions **/

/**
 * Create a parent/child relationship for given child
 * 
 * @param int $child_guid
 * @param int $parent_guid
 * @return bool 
 */
function assign_child_to_parent($child_guid, $parent_guid) {
	return add_entity_relationship($child_guid, PARENT_CHILD_RELATIONSHIP, $parent_guid);
}
	
/**
 * Return all children of a parent
 *
 * @param int $parent_guid
 * @return array 
 */
function get_parents_children($parent_guid) {
	
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
function is_user_parent($user) {
	if ($user instanceof ElggUser) {
		return $user->is_parent;
	}
	return false;
}

function parentportal_gatekeeper() {
	global $CONFIG;
	
	$allowed = false;
	
	$parsed_url = parse_url($CONFIG->wwwroot);
	$base_url = $parsed_url['scheme'] . "://" . $parsed_url['host'];
	
	if ((isset($parsed_url['port'])) && ($parsed_url['port'])) {
	 	$base_url .= ":" . $parsed_url['port'];
	}

	$uri = preg_replace('#\?.*|\#.*#', '', $_SERVER['REQUEST_URI']);
	$url = $base_url . $uri;
		
	// Will be true for whitelist, false for blacklist
	$access_toggle = get_plugin_setting('urltoggle', 'parentportal');
	
	$url_list = get_plugin_setting('urllist','parentportal');
	$url_list = explode("\n", $url_list);
	
	if ($access_toggle) {
		// exceptions for blacklist
		array_push($url_list, '');
		array_push($url_list, '_css/js.php');
		array_push($url_list, '_css/css.css');
		array_push($url_list, 'pg/parentportal');
		array_push($url_list, 'action/logout');
		array_push($url_list, 'mod/profile/icondirect.php');
	} 
	
	// Allowed is defaulted to the opposite (false for white, true for blacklist)
	$allowed = $access_toggle ? false : true;
	foreach($url_list as $u) {
		$u = trim($u);
		if(strcmp($url, $CONFIG->wwwroot . $u) == 0) {
			$allowed = $access_toggle ? true : false;
			break;
		}
	}
	
	if (!$allowed) {
	    //register_error(elgg_echo('parentportal')); 
	    forward('pg/parentportal');
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

?>