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

$user = get_entity($vars['entity']->guid);
$more_info = '';

$title = elgg_echo('parentportal:title:childinfo');

//set some variables
$location = elgg_view("output/tags",array('value' => $user->location));
$section = $vars['section'];

$icon = elgg_view("profile/icon",array('entity' => $user, 'size' => 'large', 'override' => 'true'));

$icon = elgg_view_entity_icon($user, 'large', array('hover' => FALSE));

$icon_class = "large";

$username = $user->username;

$child_stats = elgg_vieW('parentportal/child_stats', $vars);

//contruct the display
$display = <<<HTML
<div>
	<h3 class="pp">$title</h3>
</div>
<div id="child_block">
	<table style='width: 100%;'> 
		<tr>
			<td style='width: 175px;'>
				<div class="child_block_icon {$icon_class}">
					{$icon}
				</div>
			</td>
			<td>
				<div class='child_block_contents'>
					<h3>{$user->name}</h3>
					<p class='child_profile_info briefdescription'>{$user->briefdescription}</p>
					<p class='child_profile_info location'>{$location}</p>
					<div class='child_stats'>
						$child_stats
					</div>
				</div>
			</td>
		</tr>
	</table>
</div>

HTML;

echo $display;
