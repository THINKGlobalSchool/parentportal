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
	$icon_class = "large";
	
	$username = $user->username;

	//contruct the display
	$display = <<<EOT
	<div>
		<h3 class="pp">$title</h3>
	</div>
	<div id="child_block">
		<table> 
			<tr>
				<td>
					<div class="child_block_icon {$icon_class}">
						{$icon}
					</div>
				</td>
				<td>
					<div class='child_block_contents'>
						<h3>{$user->name}</h3>
						<p class='child_profile_info briefdescription'>{$user->briefdescription}</p>
						<p class='child_profile_info location'>{$location}</p>
					</div>
				</td>
			</tr>
		</table>
	</div>
	
EOT;

	echo $display;
	