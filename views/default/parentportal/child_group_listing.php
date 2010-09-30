<?php
	/**
	 * ParentPortal Child Group listing
	 * 
	 * @package ParentPortal
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Jeff Tilson
	 * @copyright THINK Global School 2010
	 * @link http://www.thinkglobalschool.com
	 **/

	$icon = elgg_view(
			"groups/icon", array(
			'entity' => $vars['entity'],
			'size' => 'tiny',
	));

	//get the membership type
	$membership = $vars['entity']->membership;
	if($membership == ACCESS_PUBLIC) {
		$mem = elgg_echo("groups:open");
	} else {
		$mem = elgg_echo("groups:closed");
	}

	$info .= "<p class='entity_subtext groups'>" . $mem . " / <b>" . get_group_members($vars['entity']->guid, 10, 0, 0, true) ."</b> " . elgg_echo("groups:member");
	$info .= "</p>";
	$info .= "<p class='entity_title'><a href=\"" . $vars['entity']->getUrl() . "\">" . $vars['entity']->name . "</a></p>";
	$info .= "<p class='entity_subtext'>" . $vars['entity']->briefdescription . "</p>";

	echo elgg_view_listing($icon, $info);

?>
