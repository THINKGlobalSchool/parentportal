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
		global $CONFIG;
		
		// Constants
		define('PARENT_CHILD_RELATIONSHIP', "is_child_of");

		// Extend Admin Menu 
		elgg_extend_view('profile/menu/adminlinks', 'parentportal/adminlinks');
		
		// CSS 
		elgg_extend_view('css','parentportal/css');
		
		// Actions	
		register_action('parentportal/addchildren', false, $CONFIG->pluginspath . 'parentportal/actions/addchildren.php');
		register_action('parentportal/clearchildren', false, $CONFIG->pluginspath . 'parentportal/actions/clearchildren.php');

		// Page handler
		register_page_handler('parentportal','parentportal_page_handler');
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
		}
		
		$sidebar = isset($content_info['sidebar']) ? $content_info['sidebar'] : '';
		$content = elgg_view('navigation/breadcrumbs') . $content_info['content'];

		$body = elgg_view_layout($layout, $content, $sidebar);

		page_draw($title, $body);
	}

	register_elgg_event_handler('init', 'system', 'parentportal_init');
?>