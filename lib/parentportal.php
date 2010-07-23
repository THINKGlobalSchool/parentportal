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
	
	function parentportal_get_page_content_index() {
		return array(
				'top' => 'Welcome!',
				'left_column' => 'left content',
				'right_column' => 'right content'
				);
	}
	
	function parentportal_get_page_content_manageparent($user_guid) {
		global $CONFIG;
		
		if ($user_guid) {	
			$user = get_user($user_guid);
		
			elgg_push_breadcrumb(sprintf(elgg_echo('parentportal:label:profile'), $user->name), $CONFIG->url . 'pg/profile/' . $user->username);
			elgg_push_breadcrumb(elgg_echo('parentportal:menu:admin:manageparent'));
			
			$content = elgg_view_title(elgg_echo('parentportal:title:manageparent'));
			$content .= elgg_view('parentportal/forms/manageparent', array('user_guid' => $user_guid));
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
		return elgg_get_entities_from_relationship(array(
														'relationship' => PARENT_CHILD_RELATIONSHIP,
														'relationship_guid' => $parent_guid,
														'inverse_relationship' => TRUE,
														'types' => array('user'),
														'limit' => 9999,
														'offset' => 0,
														'count' => false,
													));

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
			array_push($url_list, '');
			array_push($url_list, '_css/js.php');
			array_push($url_list, '_css/css.css');
			array_push($url_list, 'pg/parentportal');
		} 
	
		foreach($url_list as $u) {
			$u = trim($u);
			if ($access_toggle) {
				// Whitelist
				if(strcmp($url, $CONFIG->wwwroot . $u) == 0) {
					$allowed = true;
					break;
				}
			} else {
				// Blacklist
				if(strcmp($url, $CONFIG->wwwroot . $u) == 0) {
					$allowed = false;
					break;
				} else {
					$allowed = true;
				}
			}
		}
		
		if (!$allowed) {
		    //register_error(elgg_echo('parentportal')); 
		    forward('pg/parentportal');
		}
    }
	
?>