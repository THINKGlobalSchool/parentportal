<?php
/**
 * Parent Portal Child ToDo list
 * 
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */

$todos = $vars['todos'];
$counter = 0;

if($todos){
	foreach($todos as $todo){
		//get the owner
		$owner = $todo->getOwnerEntity();

		//get the time
		$due_date = date("F j, Y", $todo->due_date);
		//$friendlytime = friendly_time($todo->time_created);
		
		$icon = elgg_view_entity_icon($todo->getOwnerEntity(), 'tiny');

	    $info = "<div class='entity_listing_icon'>" . $icon . "</div>";

		//get the body
		$info .= "<div class='entity_listing_info' style='width: auto;'><p class='entity_title'><a href='{$todo->getURL()}'>{$todo->title}</a></p>";
	
		//get the user details
		$info .= "<p class='entity_subtext'><b>Due: {$due_date}</b></p>";
		$info .= "</div>";
		//display 
		echo "<div class='entity_listing clearfix'>" . $info . "</div>";
		
		if ($vars['count']) {
			$counter++;
			if ($counter >= $vars['count']) {
				break;
			}
		} 
	} 
}