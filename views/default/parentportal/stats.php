<?php
/**
 * ParentPortal Child stats view
 * 
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com
 **/


$blog_label = elgg_echo('parentportal:stats:blog');
$blog_count = elgg_get_entities(array('owner_guid' => $vars['entity']->getGUID(), 'type' => 'object', 'subtype' => 'blog', 'count' => true));
$blog_count = $blog_count ? $blog_count : 0;

$photo_label = elgg_echo('parentportal:stats:photo');
$photo_count = elgg_get_entities(array('owner_guid' => $vars['entity']->getGUID(), 'type' => 'object', 'subtype' => 'image', 'count' => true));
$photo_count = $photo_count ? $photo_count : 0;

$bookmark_label = elgg_echo('parentportal:stats:bookmark');
$bookmark_count = elgg_get_entities(array('owner_guid' => $vars['entity']->getGUID(), 'type' => 'object', 'subtype' => 'bookmarks', 'count' => true));
$bookmark_count = $bookmark_count ? $bookmark_count : 0;

if (elgg_is_active_plugin('todo')) {
	$todo_label = elgg_echo('parentportal:stats:todo');
	$todos = get_users_todos($vars['entity']->getGUID());
	
	$todo_count = 0;
	if ($todos) {
		foreach ($todos as $todo) {
			if (has_user_submitted($vars['entity']->getGUID(), $todo->getGUID())) {
				$todo_count++;
			}
		}
	}
	
	$todo_content = <<<HTML
	<tr>
		<td class='label'>$todo_label</td>
		<td class='stat'>$todo_count</td>
	</tr>
HTML;
}

echo <<<HTML
	<div id='parentportal-child-stats'>
		<table id='stats_table'>
			<tr>
				<td class='label'>$blog_label</td>
				<td class='stat'>$blog_count</td>
			</tr>
			<tr>
				<td class='label'>$photo_label</td>
				<td class='stat'>$photo_count</td>
			</tr>
			<tr>
				<td class='label'>$bookmark_label</td>
				<td class='stat'>$bookmark_count</td>
			</tr>
			$todo_content
		</table>
	</div>
HTML;
?>