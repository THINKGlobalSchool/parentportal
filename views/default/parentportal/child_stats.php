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

	$photo_label = elgg_echo('parentportal:stats:photo');
	$photo_count = elgg_get_entities(array('owner_guid' => $vars['entity']->getGUID(), 'type' => 'object', 'subtype' => 'image', 'count' => true));
	
	$bookmark_label = elgg_echo('parentportal:stats:bookmark');
	$bookmark_count = elgg_get_entities(array('owner_guid' => $vars['entity']->getGUID(), 'type' => 'object', 'subtype' => 'bookmarks', 'count' => true));
	
	$rubric_label = elgg_echo('parentportal:stats:rubric');
	$rubric_count = elgg_get_entities(array('owner_guid' => $vars['entity']->getGUID(), 'type' => 'object', 'subtype' => 'rubric', 'count' => true));
	
	$todo_label = elgg_echo('parentportal:stats:todo');
	$todos = get_users_todos($vars['entity']->getGUID());
	
	$todo_count = 0;
	foreach ($todos as $todo) {
		if (has_user_submitted($vars['entity']->getGUID(), $todo->getGUID())) {
			$todo_count++;
		}
	}
	
	echo "
		<table id='stats_table'>
			<tr class='odd'>
				<td class='label'>$blog_label</td>
				<td class='stat'>$blog_count</td>
			</tr>
			<tr class='even'>
				<td class='label'>$photo_label</td>
				<td class='stat'>$photo_count</td>
			</tr>
			<tr class='odd'>
				<td class='label'>$bookmark_label</td>
				<td class='stat'>$bookmark_count</td>
			</tr>
			<tr class='even'>
				<td class='label'>$rubric_label</td>
				<td class='stat'>$rubric_count</td>
			</tr>
			<tr class='odd'>
				<td class='label'>$todo_label</td>
				<td class='stat'>$todo_count</td>
			</tr>
		</table>
	";
?>