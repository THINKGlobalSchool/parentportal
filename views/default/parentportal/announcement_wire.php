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

	$desc = $vars['entity']->description;
	$owner = get_user($vars['entity']->owner_guid);
	$desc = parse_urls($desc);
	$time = friendly_time($vars['entity']->time_created);
	
	$owner_link = "<a href='{$vars['url']}pg/profile/{$owner->username}/'>{$owner->name}</a>";
	
	echo <<<EOT
		<div class='river_item riverdashboard'> 
			<div class='river_item_contents clearfloat' style='margin-left: 5px; margin-bottom: 5px;'>
				<b>$desc</b> 
				<br />
				<span class='entity_subtext'>
					by $owner_link $time
				</span>
			</div>
		</div>
EOT;
?>