<?php
/**
 * ParentPortal Custom Nav
 * 
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com
 **/

global $CONFIG;

$home->name = 'Parent Portal Home';
$home->value->url = $CONFIG->url . 'pg/parentportal';
$home->value->context = 'parentportal';

$calendar->name = elgg_echo('tgscalendar:calendars');
$calendar->value->url = $CONFIG->url . 'pg/calendar';
$calendar->value->context = 'calendar';

$logout_url = elgg_add_action_tokens_to_url($CONFIG->url . 'action/logout');
$logout->name = 'Logout';
$logout->value->url = $logout_url;

// If user doesn't have the flag set, add a link back to regular homepage
if (!is_user_parent(get_loggedin_user())) {
	$normal_home->name = 'Spot Home';
	$normal_home->value->url = $CONFIG->url . 'pg/dashboard';
	$parent_nav = array($normal_home, $home, $calendar, $logout);
} else {
	$parent_nav = array($home, $calendar, $logout);
}



$nav_html = '';
$context = get_context();

$item_count = 0;

// if there are no featured items, display the standard tools in alphabetical order
if ($parent_nav) {
	foreach ($parent_nav as $info) {
		$selected = ($info->value->context == $context) ? 'class="selected"' : '';
		$title = htmlentities($info->name, ENT_QUOTES, 'UTF-8');
		$url = htmlentities($info->value->url, ENT_QUOTES, 'UTF-8');

		$nav_html .= "<li $selected><a href=\"$url\" title=\"$title\"><span>$title</span></a></li>";
	}
} 

// only display, if there are nav items to display
if ($nav_html) {
	echo <<<___END
	<div id="elgg_main_nav" class="clearfix">
		<ul class="navigation">
			$nav_html
		</ul>
	</div>
___END;
}
?>
