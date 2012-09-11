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
	
	// Register CSS
	$parentportal_css = elgg_get_simplecache_url('css', 'parentportal/css');
	elgg_register_simplecache_view('css/parentportal/css');
	elgg_register_css('elgg.parentportal', $parentportal_css);
	
	// Register JS
	$parentportal_js = elgg_get_simplecache_url('js', 'parentportal/parentportal');
	elgg_register_simplecache_view('js/parentportal/parentportal');
	elgg_register_js('elgg.parentportal', $parentportal_js);
		
	// Register for view plugin hook 
	elgg_register_plugin_hook_handler('view', 'page/default', 'parentportal_default_view_handler');
	
	// Hook for site menu
	elgg_register_plugin_hook_handler('prepare', 'menu:site', 'parentportal_site_menu_setup');
	
	// Extend Admin Menu 
	elgg_register_plugin_hook_handler('register', 'menu:user_hover', 'parentportal_user_hover_menu_setup');
	
	// Handler to prepare child/parent menu
	elgg_register_plugin_hook_handler('register', 'menu:parentportal-nav', 'parentportal_nav_menu_setup');
	
	// Tabbed nav for todo module
	elgg_register_plugin_hook_handler('register', 'menu:parentportal-todo-nav', 'parentportal_todo_nav_menu_setup');
	
	// Add search to the pp header
	elgg_extend_view('page/elements/parentportal_header', 'search/search_box');

	// Actions	
	$action_base = elgg_get_plugins_path() . 'parentportal/actions/parentportal';
	elgg_register_action('parentportal/manageparent', "$action_base/manageparent.php", 'admin');
	elgg_register_action('parentportal/submitquestion', "$action_base/submitquestion.php");
	
	// Plugin hook for index redirect
	elgg_register_plugin_hook_handler('index', 'system', 'parentportal_redirect');
		
	// Page handler
	elgg_register_page_handler('parentportal','parentportal_page_handler');
	
	// Add announcements to parent portal, if enabled
	if (elgg_is_active_plugin('announcements')) {
		elgg_extend_view('parentportal/extend_right', 'parentportal/announcements');
	}
	
	// add a site navigation item
	$item = new ElggMenuItem('parentportal', elgg_echo('parentportal'), 'parentportal');
	elgg_register_menu_item('site', $item);

	// PP Gatekeeper
	if (elgg_is_logged_in() && parentportal_is_user_parent(elgg_get_logged_in_user_entity())) {
		parentportal_gatekeeper();
    }

	// Whitelist ajax views
	elgg_register_ajax_view('parentportal/module/activity');
	elgg_register_ajax_view('parentportal/module/groups');
	elgg_register_ajax_view('parentportal/module/todos');
	elgg_register_ajax_view('parentportal/module/photos');
}

/**
* ParentPortal Page Handler
* 
* @param array $page From the page_handler function
* @return true|false Depending on success
*
*/
function parentportal_page_handler($page) {
	// Load JS/CSS
	elgg_load_js('elgg.parentportal');
	elgg_load_css('elgg.parentportal');
	
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
			break;
		case 'settings':
			gatekeeper();
			$params = parentportal_get_page_content_user_settings();
			break;
		default:
			gatekeeper();
			$user = elgg_get_logged_in_user_entity();
			set_input('parentportal', true);
			$params = parentportal_get_page_content_index($user);
			break;
	}
	
	switch ($params['layout']) {
		default:
		case 'one_sidebar':
			$body = elgg_view_layout($params['layout'], $params);
			echo elgg_view_page($params['title'], $body);
			break;
		case 'pp_header_two_column':
			$params['header'] = elgg_view('navigation/breadcrumbs') . $params['header'];
			$body = elgg_view_layout($params['layout'], $params);
			echo elgg_view_page($params['title'], $body, 'parentportal');
			break;
	}
	return TRUE;
}

/**
 * Tweak the site menu
 */
function parentportal_site_menu_setup($hook, $type, $return, $params) {	
	if (elgg_in_context('parentportal')) {					
		// Set home link as selected if on parentportal
		foreach($return['default'] as $idx => $item) {
			if ($item->getName() == 'home') {
				$href = elgg_get_site_url() . 'parentportal';
				elgg_http_url_is_identical(full_url(), $options['href']);
				$item->setSelected(true);
			}
		}
	}
	return $return;
}

/**
 * Prepare the parentportal nav menu
 */
function parentportal_nav_menu_setup($hook, $type, $return, $params) {			
	$tab = get_input('tab', 'parent');
	
	if (!in_array($tab, array('student', 'parent'))) {
		$tab = 'parent';
	}
	
	$children = get_input('children', FALSE);

	if ($children) {
		$options = array(
			'name' => 'student_tab',
			'text' => elgg_echo('parentportal:title:childinfo'),
			'href' => '?tab=student',
			'selected' => $tab == 'student',
			'priority' => 1,
		);
		
		$return[] = ElggMenuItem::factory($options);
	}

		
 	$options = array(
		'name' => 'parent_tab',
		'text' => elgg_echo('parentportal:title:parentinfo'),
		'href' => '?tab=parent',
		'selected' => $tab == 'parent',
		'priority' => 0,
	);

	$return[] = ElggMenuItem::factory($options);
	
	return $return;
}

/**
 * Prepare the parentportal todo nav menu
 */
function parentportal_todo_nav_menu_setup($hook, $type, $return, $params) {	
	$tab = get_input('show_todo', 'incomplete');
	
	if (!in_array($tab, array('incomplete', 'complete', 'past_due'))) {
		$tab = 'incomplete';
	}
	
	$options = array(
		'name' => 'incomplete_tab',
		'text' => "<a class='parentportal-todos-nav' href='#parentportal-todos-incomplete'>" . elgg_echo('parentportal:label:todo:incomplete') . "</a>",
		'href' => FALSE,
		'selected' => $tab == 'incomplete',
		'priority' => 0,
	);
	
	$return[] = ElggMenuItem::factory($options);
	
	$options = array(
		'name' => 'past_due_tab',
		'text' => "<a class='parentportal-todos-nav' href='#parentportal-todos-pastdue'>" . elgg_echo('parentportal:label:todo:pastdue') . "</a>",
		'href' => FALSE,
		'selected' => $tab == 'past_due',
		'priority' => 0,
	);
	
	$return[] = ElggMenuItem::factory($options);
	
 	$options = array(
		'name' => 'complete_tab',
		'text' => "<a class='parentportal-todos-nav' href='#parentportal-todos-complete'>" . elgg_echo('parentportal:label:todo:complete') . "</a>",
		'href' => FALSE,
		'selected' => $tab == 'complete',
		'priority' => 1,
	);

	$return[] = ElggMenuItem::factory($options);

	return $return;
}

/**
 * Extend the user hover menu
 */
function parentportal_user_hover_menu_setup($hook, $type, $return, $params) {

	$options = array(
		'name' => 'manage_parent',
		'text' => elgg_echo('parentportal:menu:admin:manageparent'),
		'href' => elgg_get_site_url() . 'parentportal/manageparent/' . $params['entity']->username,
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
	if (parentportal_is_user_parent($user)) {
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
	if (parentportal_is_user_parent(elgg_get_logged_in_user_entity())) {
		forward('parentportal');
	}
	return $returnvalue;
}
