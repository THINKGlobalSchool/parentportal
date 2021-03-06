<?php



/**
 * Parent portal start.php
 *
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2015
 * @link http://www.thinkglobalschool.org/
 *
 * @TODO
 * - remove old views
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
	elgg_extend_view('css/elgg', 'css/parentportal/css');

	// Register JS
	$parentportal_js = elgg_get_simplecache_url('js', 'parentportal/parentportal');
	elgg_register_simplecache_view('js/parentportal/parentportal');
	elgg_register_js('elgg.parentportal', $parentportal_js);

	$parentportal_js = elgg_get_simplecache_url('js', 'parentportal/global');
	elgg_register_simplecache_view('js/parentportal/global');
	elgg_register_js('elgg.parentportalglobal', $parentportal_js);
	elgg_load_js('elgg.parentportalglobal');

	// Hook for site menu
	elgg_register_plugin_hook_handler('prepare', 'menu:topbar', 'parentportal_site_menu_setup');

	// Set up entity menu
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'parentportal_entity_menu_setup', 9999);

	// Extend Admin Menu
	elgg_register_plugin_hook_handler('register', 'menu:user_hover', 'parentportal_user_hover_menu_setup');

	// Handler to prepare child/parent menu
	elgg_register_plugin_hook_handler('register', 'menu:parentportal-nav', 'parentportal_nav_menu_setup');

	// Tabbed nav for todo module
	elgg_register_plugin_hook_handler('register', 'menu:parentportal-todo-nav', 'parentportal_todo_nav_menu_setup');

	// Set up activity menu for 'forparents' activity widget
	elgg_register_plugin_hook_handler('register', 'menu:activity_filter', 'parentportal_activity_menu_setup', 999);

	// Modify widget menu
	elgg_register_plugin_hook_handler('register', 'menu:widget', 'parentportal_widget_menu_setup', 502);

	// Pagesetup event handler
	elgg_register_event_handler('pagesetup', 'system', 'parentportal_pagesetup');

	// Actions
	$action_base = elgg_get_plugins_path() . 'parentportal/actions/parentportal';
	elgg_register_action('parentportal/manageparent', "$action_base/manageparent.php", 'admin');
	elgg_register_action('parentportal/submitquestion', "$action_base/submitquestion.php");

	$action_base = elgg_get_plugins_path() . 'parentportal/actions/question_log';
	elgg_register_action('question_log/delete', "$action_base/delete.php", 'admin');

	// Plugin hook for index redirect
	//elgg_register_plugin_hook_handler('index', 'system', 'parentportal_redirect');

	// Page handler
	elgg_register_page_handler('parentportal','parentportal_page_handler');

	// add announcements to parent portal, if enabled
	if (elgg_is_active_plugin('announcements')) {
		elgg_extend_view('parentportal/extend_right', 'parentportal/announcements');
	}

	elgg_extend_view('page/layouts/role_widgets', 'parentportal/child_preload', 1);

	// add a site navigation item
	$item = new ElggMenuItem('parentportal', elgg_echo('parentportal'), 'parentportal');
	elgg_register_menu_item('site', $item);

	// PP Gatekeeper
	if (elgg_is_logged_in() && parentportal_is_user_parent(elgg_get_logged_in_user_entity())) {
		parentportal_gatekeeper();
    }

    // Register widgets
    $widgets = array(
    	'childprofile',
    	'forparentsactivity',
    	'news',
    	'question',
    	'schooldocs',
    	'travelupdates',
    	'wexplore',
    	'groups',
    	'reports',
    	'activity',
    	'todos',
    	'photos',
    );

    foreach ($widgets as $name) {
    	$title = elgg_echo("parentportal:widget:{$name}_title");
    	$desc = elgg_echo("parentportal:widget:{$name}_desc");
    	elgg_register_widget_type("parentportal_{$name}", $title, $desc, array('rolewidget'));
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
		//	set_input('role', elgg_get_plugin_setting('parents_role','parentportal'));
			forward('home?role=' . elgg_get_plugin_setting('parents_role','parentportal'));
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
			echo elgg_view_page($params['title'], $body);
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
 * Entity menu setup
 */
function parentportal_entity_menu_setup($hook, $type, $return, $params) {
	$entity = $params['entity'];

	// Set up question log items
	if (elgg_instanceof($entity, 'object', 'pp_question_log')) {
		$new_menu = array();
		foreach ($return as $idx => $item) {
			if ($item->getName() == 'delete') {
				$new_menu[] = $item;
			}
		}

		return $new_menu;
	}

	// Set up 'tag for parents'
	if (elgg_instanceof($entity, 'object') && elgg_is_logged_in()) {
		// Check if entity has the 'forparents' tag
		$params = array(
			'guid' => $entity->guid,
			'limit' => 1,
			'metadata_name_value_pairs' => array(
				'name' => 'tags',
				'value' => 'forparents',
				'operand' => '=',
				'case_sensitive' => FALSE
			),
			'count' => TRUE
		);

		$has_parent_tag = (int)elgg_get_entities_from_metadata($params);

		// If this entity does not have the 'forparents' tag, show the add button
		if (!$has_parent_tag) {
			$options = array(
				'name' => 'tag_for_parents',
				'text' => elgg_echo('parentportal:label:tagforparents'),
				'title' => 'tag_for_parents',
				'href' => "#{$entity->guid}",
				'link_class' => 'tag-for-parents',
				'section' => 'actions',
				'priority' => 200,
				'id' => "tag-for-parents-{$entity->guid}",
			);
			$return[] = ElggMenuItem::factory($options);
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
 * Set up activity filter menu items for 'forparents' activity widget
 */
function parentportal_activity_menu_setup($h999, $type, $return, $params) {

	if (elgg_in_context('parentportal_activity_widget')) {
		foreach ($return as $idx => $item) {
			if ($item->getName() == 'role-filter' || $item->getName() == 'tag-filter') {
				unset($return[$idx]);
			}
		}
	}

	return $return;
}

/**
 * Modify widget menus for role widgets
 */
function parentportal_widget_menu_setup($hook, $type, $return, $params) {
	if (get_input('custom_widget_controls')) {
		$widget = $params['entity'];

		if ($widget->handler == 'parentportal_forparentsactivity') {
			$options = array(
				'name' => 'river_view_all',
				'text' => elgg_echo('parentportal:label:viewallactivity'),
				'title' => 'river_view_all',
				'href' => elgg_get_site_url() . 'activity',
				'link_class' => 'home-small'
			);

			$return[] = ElggMenuItem::factory($options);
		}

		return $return;
	}

	return $return;
}

/**
* Pagesetup event handler
*
* @return NULL
 */
function parentportal_pagesetup() {
	if (elgg_in_context('admin')) {
		elgg_register_admin_menu_item('administer', 'question_log', 'administer_utilities');
	}
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
