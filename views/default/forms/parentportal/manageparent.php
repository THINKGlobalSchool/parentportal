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
$current_children = parentportal_get_parents_children($user->getGUID());

$children = array();
foreach ($current_children as $child) {
	$children[] = $child->guid;
}

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
	'values' => $children,
));
											
$save_button = elgg_view('input/submit', array(
	'value' => elgg_echo('save')
));

$parent_input = elgg_view('input/hidden', array(
	'name' => 'parent', 
	'value' => $vars['user_guid']
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
		$save_button
	</div>
	$parent_input
HTML;

echo $form_body;
