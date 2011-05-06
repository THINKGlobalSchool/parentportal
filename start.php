<?php
	/**
	 * Parent portal start.php
	 * 
	 * @package ParentPortal
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Jeff Tilson
	 * @copyright THINK Global School 2010
	 * @link http://www.thinkglobalschool.com/
	 * 
	 */
	
	// Init
	function parentportal_init() {
	
		include_once('lib/parentportal.php');
		include_once('lib/ajaxmodule.php');
		global $CONFIG;
		
		// Constants
		define('PARENT_CHILD_RELATIONSHIP', "is_child_of");

		// Extend Admin Menu 
		elgg_extend_view('profile/menu/adminlinks', 'parentportal/adminlinks');
		
		// CSS 
		elgg_extend_view('css/screen','parentportal/css');
				
		// Redirect view
		elgg_extend_view('page_elements/topbar', 'parentportal/redirect');
		
		// Actions	
		elgg_register_action('parentportal/addchildren', $CONFIG->pluginspath . 'parentportal/actions/addchildren.php', 'admin');
		elgg_register_action('parentportal/clearchildren', $CONFIG->pluginspath . 'parentportal/actions/clearchildren.php', 'admin');
		elgg_register_action('parentportal/submitquestion', $CONFIG->pluginspath . 'parentportal/actions/submitquestion.php');
		
		// Plugin hook for index redirect
		register_plugin_hook('index', 'system', 'parentportal_redirect');
		
		// Page handler
		register_page_handler('parentportal','parentportal_page_handler');
		
		// Ajax module page handler
		register_page_handler('ajaxmodule', 'ajaxmodule_page_handler');
		
		// Check if parent has children, if so add a menu item (for admin-type users)
		$children = get_parents_children(get_loggedin_userid());
		
		if ($children) {
			add_menu(elgg_echo('parentportal'), $CONFIG->wwwroot . "pg/parentportal");
		}
		
		if (isloggedin() && is_user_parent(get_loggedin_user())) {
			parentportal_gatekeeper();
	    }	
	
		elgg_register_plugin_hook_handler('view', 'all', 'ajaxmodule_view_hook');
	}
	
	// Register JS
	function parentportal_js() {
		elgg_register_js(elgg_get_site_url() . 'mod/parentportal/views/default/js/ajaxmodule/ajaxmodule.php', 'elgg.ajaxmodule');
	}
	
	// Ajaxmodule view hook handler
	function ajaxmodule_view_hook($hook, $entity_type, $returnvalue, $params) {
		if (get_input('search_viewtype') == 'simple' && $params['view'] != 'object/simple') {
			if (strpos($params['view'], 'object/') === 0) {
				return elgg_view('object/simple', $params['vars']);	
			}
		} else {
			return $returnvalue;
		}
	}
	
	/**
	* ParentPortal Page Handler
	* 
	* @param array $page From the page_handler function
	* @return true|false Depending on success
	*
	*/
	function parentportal_page_handler($page) {
		global $CONFIG;

		switch ($page[0]) {
			// Manage Parent
			case 'manageparent':
				admin_gatekeeper();
				$username = $page[1];
				// forward away if invalid user.
				if (!$user = get_user_by_username($username)) {
					register_error(elgg_echo('parentportal:error:unknown_username'));
					forward($_SERVER['HTTP_REFERER']);
				}
				$title = elgg_echo('parentportal:title:manageparent');
				$content_info = parentportal_get_page_content_manageparent($user->getGUID());
				$layout = "one_column";
				break;
			case 'settings':
				gatekeeper();
				$title = elgg_echo('parentportal:title:usersettings');
				$layout = 'one_column';
				$content_info['content'] = elgg_view('parentportal/parent_settings');
				break;
			default:
				gatekeeper();
				$user = get_loggedin_user();
				set_input('parentportal', true);
				$title = elgg_echo('parentportal');
				$content_info = parentportal_get_page_content_index($user);
				$layout = "pp_top_two_column";
				break;
		}
		
		switch ($layout) {
			case 'one_column':
				$sidebar = isset($content_info['sidebar']) ? $content_info['sidebar'] : '';
				$content = elgg_view('navigation/breadcrumbs') . $content_info['content'];
				$body = elgg_view_layout($layout, $content, $sidebar);
				echo elgg_view_page($title, $body);
				break;
			case 'pp_top_two_column':
				$top = elgg_view('navigation/breadcrumbs');
				$top .= isset($content_info['top']) ? $content_info['top'] : '';
				$left_column = isset($content_info['left_column']) ? $content_info['left_column'] : '';
				$right_column = isset($content_info['right_column']) ? $content_info['right_column'] : '';
				$body = elgg_view_layout($layout, $top, $left_column, $right_column);
				echo elgg_view_page($title, $body, 'parentportal');
				break;
		}
	}
	
	
	/**
	* Ajaxmodule page handler
	* 
	* @param array $page From the page_handler function
	* @return true|false Depending on success
	*
	*/
	function ajaxmodule_page_handler($page) {
		switch ($page[0]) {
			case 'load':
			default:
				$options['container_guid'] 	= get_input('container_guid');
				$options['tag']				= get_input('tag');
				$options['subtypes']		= json_decode(get_input('subtypes'));
				$options['limit']			= get_input('limit', 10);
				$options['offset']			= get_input('offset', 0);
				
				// Set 'listing type' for new simple listing if supplied
				if ($listing_type = get_input('listing_type', FALSE)) {
					set_input('search_viewtype', $listing_type);
				}
				
				echo am_list_entities_by_group_or_tag($options);
			break;
		}
		exit;
	}

	/**
	 * Plugin hook to redirect parent users from index
	 *
	 * @param unknown_type $hook
	 * @param unknown_type $entity_type
	 * @param unknown_type $returnvalue
	 * @param unknown_type $params
	 * @return unknown
	 */
	function parentportal_redirect($hook, $entity_type, $returnvalue, $params) {
		if (is_user_parent(get_loggedin_user())) {
			forward('pg/parentportal');
		}
		return $returnvalue;
	}

	register_elgg_event_handler('init', 'system', 'parentportal_init');
	register_elgg_event_handler('pagesetup', 'system', 'parentportal_js');
?>