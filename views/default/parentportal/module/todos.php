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

// Use modules' simpleicon view here
set_input('ajaxmodule_listing_type', 'simpleicon');
		
$title = elgg_echo('parentportal:title:childtodos');		
		
// get the user's todos, will be seperating complete/incomplete
global $CONFIG;

$test_id = get_metastring_id('manual_complete');
$one_id = get_metastring_id(1);
$wheres = array();

$user_guid = $vars['entity']->getGUID();		
$relationship = COMPLETED_RELATIONSHIP;

$options = array(
	'type' => 'object',
	'subtype' => 'todo',
	'relationship' => TODO_ASSIGNEE_RELATIONSHIP, 
	'relationship_guid' => $user_guid, 
	'inverse_relationship' => FALSE,
	'metadata_name' => 'status',
	'metadata_value' => TODO_STATUS_PUBLISHED,
	'order_by_metadata' => array('name' => 'due_date', 'as' => 'int', 'direction' => 'DESC'),
	'full_view' => FALSE,
	'pagination' => FALSE,
	'limit' => 10,
	'offset' => 0,
);

// Complete
$wheres[] = "(EXISTS (
		SELECT 1 FROM {$CONFIG->dbprefix}entity_relationships r2 
		WHERE r2.guid_one = '$user_guid'
		AND r2.relationship = '$relationship'
		AND r2.guid_two = e.guid) OR 
			EXISTS (
		SELECT 1 FROM {$CONFIG->dbprefix}metadata md
		WHERE md.entity_guid = e.guid
			AND md.name_id = $test_id
			AND md.value_id = $one_id))";

$options['wheres'] = $wheres;

$complete_todos = elgg_list_entities_from_relationship($options);

$wheres = array();

// Incomplete
$wheres[] = "NOT EXISTS (
		SELECT 1 FROM {$CONFIG->dbprefix}metadata md
		WHERE md.entity_guid = e.guid
			AND md.name_id = $test_id
			AND md.value_id = $one_id)";

$wheres[] = "NOT EXISTS (
		SELECT 1 FROM {$CONFIG->dbprefix}entity_relationships r2 
		WHERE r2.guid_one = '$user_guid'
		AND r2.relationship = '$relationship'
		AND r2.guid_two = e.guid)";

$options['wheres'] = $wheres;

$incomplete_todos = elgg_list_entities_from_relationship($options);

$todo_nav .= elgg_view_menu('parentportal-todo-nav', array(
	'sort_by' => 'priority',
	// recycle the menu filter css
	'class' => 'elgg-menu-hz elgg-menu-filter elgg-menu-filter-default'
));

$body = <<<HTML
	$todo_nav
	<div class='parentportal-todos-content' id='parentportal-todos-incomplete'>
		$incomplete_todos
		<span class='parentportal-view-all-link'><a href="todo/assigned/{$vars['entity']->username}?status=incomplete">View all incomplete</a></span>
	</div>
	<div class='parentportal-todos-content' id='parentportal-todos-complete'>
		$complete_todos
		<span class='parentportal-view-all-link'><a href="todo/assigned/{$vars['entity']->username}?status=complete">View all complete</a></span>
	</div>
HTML;

$options = array(
	'id' => 'parentportal-module-child-todos',
	'class' => 'parentportal-module',
);

echo elgg_view_module('featured', $title, $body, $options);

