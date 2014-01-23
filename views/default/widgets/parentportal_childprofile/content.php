<?php
/**
 * Parent portal news widget
 * 
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2013
 * @link http://www.thinkglobalschool.com/
 *
 */
elgg_load_js('elgg.parentportal');
elgg_load_css('elgg.parentportal');
set_input('children', true);

$child_info = parentportal_get_widget_child_info();

if (!$child_info) {
	echo elgg_echo("parentportal:label:nochildren");
	return;
}

if (count($child_info["children"]) > 1) {
	$form_vars = array(
		'action' => current_page_url(),
		'id' => 'parentportal-select-child-form'
	);

	echo elgg_view_form('parentportal/childselect', $form_vars, array('children' => $child_info["children"])) . "<br />";	
}

$child = $child_info["current_child"];

$location = elgg_view("output/tags",array('value' => $child->location));

$icon = elgg_view_entity_icon($child, 'large', array('hover' => FALSE));

$child_stats = elgg_view('parentportal/stats', array('child' => $child_info['current_child']));

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
					<h3>{$child->name}</h3>
					<p class='parentportal-child-profile-info briefdescription'>{$child->briefdescription}</p>
					<p class='parentportal-child-profile-info location'>{$location}</p>
					$child_stats
				</div>
			</td>
		</tr>
	</table>
</div>
HTML;

echo $body;