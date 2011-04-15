<?php
/**
 * ParentPortal admin links	
 * 
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */

$title = elgg_echo('parentportal:title:childinfo');

$user = get_entity($vars['entity']->guid);

$location = elgg_view("output/tags",array('value' => $user->location));

$icon = elgg_view_entity_icon($user, 'large', array('hover' => FALSE));

$username = $user->username;

$child_stats = elgg_view('parentportal/stats', $vars);

$body = <<<HTML
<div id="parentportal-child-profile">
	<table style='width: 100%;'> 
		<tr>
			<td style='width: 175px;'>
				<div class="parentportal-child-profile-icon {$icon_class}">
					{$icon}
				</div>
			</td>
			<td>
				<div class='parentportal-child-profile-contents'>
					<h3>{$user->name}</h3>
					<p class='parentportal-child-profile-info briefdescription'>{$user->briefdescription}</p>
					<p class='parentportal-child-profile-info location'>{$location}</p>
					$child_stats
				</div>
			</td>
		</tr>
	</table>
</div>
HTML;

$options = array(
	'id' => 'parentportal-module-child-profile',
	'class' => 'parentportal-module',
);

echo elgg_view_module('featured', $title, $body, $options);

