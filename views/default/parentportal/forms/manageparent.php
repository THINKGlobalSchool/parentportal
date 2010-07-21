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
	$enable_input = elgg_view('input/pulldown', array(
												'internalid' => 'parent_enabled', 
												'internalname' => 'parent_enabled',
												'options_values' => array(1 => 'Enabled', 0 => 'Disabled'),
												'value' => is_user_parent($user) ? 1 : 0,
												));
												
	$child_label = elgg_echo('parentportal:label:childselect');
	$child_input = elgg_view('input/userpicker', array(
													'internalid' => 'child_picker',
													'internalname' => 'children',
												));
												
	$save_button = elgg_view('input/submit', array('value' => elgg_echo('save'), 'class' => 'submit_button'));
	
	$parent_input = elgg_view('input/hidden', array('internalname' => 'parent', 'value' => $vars['user_guid']));
	
	$clear_url = "{$vars['url']}action/parentportal/clearchildren?parent={$vars['user_guid']}";
	$clear_link = elgg_view('output/confirmlink', array(
		'href' => $clear_url,
		'text' => elgg_echo('parentportal:label:clearchildren'),
	));
	
	$current_children_label = elgg_echo('parentportal:label:currentchildren');
	$current_children = get_parents_children($user->getGUID());
	$current_children_content = elgg_view('parentportal/childlist', array('children' => $current_children));

	$form_body = <<<EOT
	<br />
	<p>
		<label for='parent_enabled'>$enable_label</label><br /><br />
		$enable_input
	</p>
	<p>
		<label for='child_picker'>$child_label</label>
		$child_input
	</p><br />
	<p>
		<label>$current_children_label</label><br />
		$current_children_content
	</p><br />
	<p>
		$clear_link <br /> $save_button
		$parent_input
	</p>
	
EOT;

	echo elgg_view('input/form', array(
		'internalid' => 'manage_parent',
		'internalname' => 'manage_parent',
		'action' => "{$vars['url']}action/parentportal/addchildren",
		'body' => $form_body
	));
?>