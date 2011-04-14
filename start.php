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

// Register init
elgg_register_event_handler('init', 'system', 'parentportal_init');

// Init
function parentportal_init() {
	
	// Register and load library
	elgg_register_library('parentportal', elgg_get_plugins_path() . 'parentportal/lib/parentportal.php');
	elgg_load_library('parentportal');
	
	// Constants
	define('PARENT_CHILD_RELATIONSHIP', "is_child_of");
	
	// CSS 
	elgg_extend_view('css/elgg','parentportal/css');
	
	// Extend the default pageshell
//	elgg_extend_view('page/default', )
	
	
	// Register for view plugin hook 
	elgg_register_plugin_hook_handler('view', 'page/default', 'parentportal_default_view_handler');
	
	// Hook for site menu
	elgg_register_plugin_hook_handler('prepare', 'menu:site', 'parentportal_site_menu_setup');
	
	// Extend Admin Menu 
	elgg_register_plugin_hook_handler('register', 'menu:user_hover', 'parentportal_user_hover_menu_setup');

	// Actions	
	$action_base = elgg_get_plugins_path() . 'parentportal/actions/parentportal';
	elgg_register_action('parentportal/manageparent', "$action_base/manageparent.php", 'admin');
	elgg_register_action('parentportal/clearchildren', "$action_base/clearchildren.php", 'admin');
	elgg_register_action('parentportal/submitquestion', "$action_base/submitquestion.php");
	
	// Plugin hook for index redirect
	elgg_register_plugin_hook_handler('index', 'system', 'parentportal_redirect');
		
	// Page handler
	elgg_register_page_handler('parentportal','parentportal_page_handler');
	
	// Check if parent has children, if so add a menu item (for admin-type users)
	$children = get_parents_children(elgg_get_logged_in_user_guid());
	
	if ($children) {
		// add a site navigation item
		$item = new ElggMenuItem('parentportal', elgg_echo('parentportal'), 'parentportal');
		elgg_register_menu_item('site', $item);
	}
	
	// PP Gatekeeper
	if (elgg_is_logged_in() && is_user_parent(elgg_get_logged_in_user_entity())) {
		parentportal_gatekeeper();
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
	switch ($page[0]) {
		// Manage Parent
		case 'manageparent':
			admin_gatekeeper();
			$username = $page[1];
			elgg_set_context('manageparent');
			// forward away if invalid user.
			if (!$user = get_user_by_username($username)) {
				register_error(elgg_echo('parentportal:error:unknown_username'));
				forward(REFERER);
			}
			$params = parentportal_get_page_content_manageparent($user->getGUID());
			$layout = "one_sidebar";
			break;
		case 'settings':
			gatekeeper();
			$title = elgg_echo('parentportal:title:usersettings');
			$layout = 'content';
			$content_info['content'] = elgg_view('parentportal/parent_settings');
			break;
		default:
			gatekeeper();
			$user = elgg_get_logged_in_user_entity();
			set_input('parentportal', true);
			$params = parentportal_get_page_content_index($user);
			$layout = 'pp_header_two_column';
			break;
	}
	
	
	switch ($layout) {
		case 'one_sidebar':
			$body = elgg_view_layout($layout, $params);
			echo elgg_view_page($params['title'], $body);
			break;
		case 'pp_header_two_column':
			$params['header'] = elgg_view('navigation/breadcrumbs') . $params['header'];
			$body = elgg_view_layout($layout, $params);
			echo elgg_view_page($params['title'], $body, 'parentportal');
			break;
	}
}

/**
 * Tweak the site menu
 */
function parentportal_site_menu_setup($hook, $type, $return, $params) {	
	if (elgg_in_context('parentportal')) {		
		// Wipe out exising menu
		$return = array();
				
		// If user doesn't have the flag set, add a link back to regular homepage
		if (!is_user_parent(elgg_get_logged_in_user_entity())) {
			$options = array(
				'name' => 'spot_home',
				'text' => elgg_echo('parentportal:menu:spothome'),
				'href' =>  elgg_get_site_url(),
				'priority' => 1,
			);
			$return['default'][] = ElggMenuItem::factory($options);
		}
		
		// Add parent portal home
		$options = array(
			'name' => 'parentportal_home',
			'text' => elgg_echo('parentportal:menu:home'),
			'href' =>  elgg_get_site_url() . 'parentportal',
			'priority' => 2,
			//'context' => 'parentportal'
		);
		$return['default'][] = ElggMenuItem::factory($options);
	
		
		// If calendar is enabled, include it
		if (elgg_is_active_plugin('calendar')) {
			$options = array(
				'name' => 'calendar',
				'text' => elgg_echo('tgscalendar:calendars'),
				'href' =>  elgg_get_site_url() . 'calendar',
				'priority' => 3,
				//'context' => 'calendar'
			);
			$return['default'][] = ElggMenuItem::factory($options);
		}
		
		// Add logout button
		$options = array(
			'name' => 'logout',
			'text' => elgg_echo('parentportal:menu:logout'),
			'href' =>  elgg_add_action_tokens_to_url(elgg_get_site_url() . 'action/logout'),
			'priority' => 999,
		);
		$return['default'][] = ElggMenuItem::factory($options);
		
	}
	
	return $return;
}

/**
 * Extend the user hover menu
 */
function parentportal_user_hover_menu_setup($hook, $type, $return, $params) {
	$options = array(
		'name' => 'manage_parent',
		'text' => elgg_echo('parentportal:menu:admin:manageparent'),
		'href' => elgg_get_site_url() . 'parentportal/manageparent/' . elgg_get_page_owner_entity()->username,
		'section' => 'admin',
	);
	$return[] = ElggMenuItem::factory($options);
	
	return $return;
}


/**
 * Plugin hook handler interrupt the page/default view
 *
 * @param sting  $hook   view
 * @param string $type   input/tags
 * @param mixed  $value  Value
 * @param mixed  $params Params
 *
 * @return array
 */
function parentportal_default_view_handler($hook, $type, $value, $params) {
	$user = elgg_get_logged_in_user_entity(); 

	// If the user is a parent, output the parentportal page shell instead of the default
	if (is_user_parent($user)) {
		elgg_set_context('parentportal');
		$value = elgg_view('page/parentportal', $params['vars']);
	}
	
	return $value;
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
	if (is_user_parent(elgg_get_logged_in_user_entity())) {
		forward('parentportal');
	}
	return $returnvalue;
}
