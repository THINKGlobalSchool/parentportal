<?php
/**
 * ParentPortal settings form
 * 
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */

// URL Blacklist/whitelist toggle
$url_toggle_label = elgg_echo('parentportal:label:urltoggle');
$url_toggle_input = elgg_view('input/dropdown', array(
	'name' => 'params[urltoggle]', 
	'value' => $vars['entity']->urltoggle, 
	'options_values' => array(
		0 => elgg_echo('parentportal:label:blacklist'), 
		1 => elgg_echo('parentportal:label:whitelist')
	)
));

// URL Blacklist/whitelist
$url_list_label = elgg_echo('parentportal:label:urllist');
$url_list_input = elgg_view('input/plaintext', array(
	'name' => 'params[urllist]', 
	'value' => $vars['entity']->urllist)
);

// Parent group input
$parent_group_label = elgg_echo('parentportal:label:parentgroup');

$groups = elgg_get_entities(array(
	'type' => 'group',
	'limit' => 0,
));
						

$groups_array = array();

foreach ($groups as $group) {
	$groups_array[$group->getGUID()] = $group->name;
}
	
$parent_group_input = elgg_view('input/dropdown', array(
	'name' => 'params[parentgroup]', 
	'value' => $vars['entity']->parentgroup, 
	'options_values' => $groups_array
));

// WeXplore group input
$wexplore_group_label = elgg_echo('parentportal:label:wexploregroup');
$wexplore_group_input =  elgg_view('input/dropdown', array(
	'name' => 'params[wexploregroup]', 
	'value' => $vars['entity']->wexploregroup, 
	'options_values' => $groups_array
)); 

// Parent tag input
$parent_tag_label = elgg_echo('parentportal:label:parenttag');
$parent_tag_input = elgg_view('input/text', array(
	'name' => 'params[parenttag]', 
	'value' => $vars['entity']->parenttag)
);

// Parent tag input
$parent_announcement_tag_label = elgg_echo('parentportal:label:parentannouncementtag');
$parent_announcement_tag_input = elgg_view('input/text', array(
	'name' => 'params[parentannouncementtag]', 
	'value' => $vars['entity']->parentannouncementtag)
);

// Parent contacts input
$parent_contacts_label = elgg_echo('parentportal:label:parentcontacts');
$parent_contacts_input = elgg_view('input/plaintext', array(
	'name' => 'params[parentcontacts]', 
	'value' => $vars['entity']->parentcontacts)
);

// If roles enabled
if (elgg_is_active_plugin('roles')) {
	// View all students role (users in this role will see all users in the student role as children)
	$view_students_label = elgg_echo('parentportal:label:viewstudents');
	$view_students_input = elgg_view('input/roledropdown', array(
		'name' => 'params[view_students_role]',
		'id' => 'view-students-role',
		'value' => $vars['entity']->view_students_role,
		'show_hidden' => TRUE,
	));
	
	// Students role, restrict users to this role for above
	$students_role_label = elgg_echo('parentportal:label:studentsrole');
	$students_role_input = elgg_view('input/roledropdown', array(
		'name' => 'params[students_role]',
		'id' => 'students-role',
		'value' => $vars['entity']->students_role,
		'show_hidden' => TRUE,
	));

	$parents_role_label = elgg_echo('parentportal:label:parentsrole');
	$parents_role_input = elgg_view('input/roledropdown', array(
		'name' => 'params[parents_role]',
		'id' => 'parents-role',
		'value' => $vars['entity']->parents_role,
		'show_hidden' => TRUE,
	));
	
	$role_settings_content = <<<HTML
		<div>
			<label>$view_students_label</label><br />
			$view_students_input
		</div><br />
		<div>
			<label>$students_role_label</label><br />
			$students_role_input
		</div><br />
		<div>
			<label>$parents_role_label</label><br />
			$parents_role_input
		</div>
HTML;

	$role_settings_content = elgg_view_module('inline', elgg_echo('parentportal:title:role_settings'), $role_settings_content);
}

$url_filtering_content = <<<HTML
	<div>
	    <label>$url_toggle_label</label><br />
	  	$url_toggle_input
	</div><br />
	<div>
	    <label>$url_list_label</label><br />
		$url_list_input
	</div>
HTML;

echo elgg_view_module('inline', elgg_echo('parentportal:title:url_filtering'), $url_filtering_content);

$group_settings_content = <<<HTML
	<div>
		<label>$parent_group_label</label><br />
		$parent_group_input
	</div><br />
	<div>
		<label>$wexplore_group_label</label><br />
		$wexplore_group_input
	</div>
HTML;

echo elgg_view_module('inline', elgg_echo('parentportal:title:group_settings'), $group_settings_content);

$tag_settings_content = <<<HTML
	<div>
	    <label>$parent_tag_label</label><br />
		$parent_tag_input
	</div><br />
		<div>
	    <label>$parent_announcement_tag_label</label><br />
		$parent_announcement_tag_input
	</div>
HTML;

echo elgg_view_module('inline', elgg_echo('parentportal:title:tag_settings'), $tag_settings_content);

$content = <<<HTML
	<div>
		<label>$parent_contacts_label</label><br />
		$parent_contacts_input
	</div>
	$role_settings_content
HTML;

echo $content;