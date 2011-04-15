<?php
/**
 * ParentPortal manage parent form
 * 
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */

$user = get_user($vars['user_guid']);

$enable_label = elgg_echo('parentportal:label:enableparent');
$enable_input = elgg_view('input/dropdown', array(
	'id' => 'parent-enabled', 
	'name' => 'parent_enabled',
	'options_values' => array(1 => 'Enabled', 0 => 'Disabled'),
	'value' => parentportal_is_user_parent($user) ? 1 : 0,
));
											
$child_label = elgg_echo('parentportal:label:childselect');
$child_input = elgg_view('input/userpicker', array(
	'id' => 'child-picker',
	'name' => 'children',
));
											
$save_button = elgg_view('input/submit', array(
	'value' => elgg_echo('save')
));

$parent_input = elgg_view('input/hidden', array(
	'name' => 'parent', 
	'value' => $vars['user_guid']
));

$clear_url = "{$vars['url']}action/parentportal/clearchildren?parent={$vars['user_guid']}";
$clear_link = elgg_view('output/confirmlink', array(
	'href' => $clear_url,
	'text' => elgg_echo('parentportal:label:clearchildren'),
));

$current_children_label = elgg_echo('parentportal:label:currentchildren');
$current_children = parentportal_get_parents_children($user->getGUID());
$current_children_content = elgg_view('parentportal/child_list', array(
	'children' => $current_children
));

$form_body = <<<HTML
	<div>
		<label for='parent_enabled'>$enable_label</label><br />
		$enable_input
	</div>
	<div>
		<label for='child_picker'>$child_label</label>
		$child_input
	</div>
	<div>
		<label>$current_children_label</label><br />
		$current_children_content
	</div>
	<div>
		$clear_link
	</div>
	<div>
		$save_button
	</div>
	$parent_input
HTML;

echo $form_body;
