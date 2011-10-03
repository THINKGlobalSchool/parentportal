<?php
/**
 * Parent Portal Child Todo Container
 * 
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */

$title = elgg_echo('parentportal:title:childtodos');

$todo_nav .= elgg_view_menu('parentportal-todo-nav', array(
	'sort_by' => 'priority',
	// recycle the menu filter css
	'class' => 'elgg-menu-hz elgg-menu-filter elgg-menu-filter-default'
));

$incomplete_todos = elgg_view('modules/genericmodule', array(
	'view' => 'parentportal/module/todos',
	'module_id' => 'pp-todo-incomplete-module',
	'module_class' => 'pp-todo-incomplete-module',
	'view_vars' => array(
		'guid' => $vars['entity']->guid,
		'view_filter' => 'incomplete',
	), 
));

$past_due_todos = elgg_view('modules/genericmodule', array(
	'view' => 'parentportal/module/todos',
	'module_id' => 'pp-todo-pastdue-module',
	'module_class' => 'pp-todo-pastdue-module',
	'view_vars' => array(
		'guid' => $vars['entity']->guid,
		'view_filter' => 'past_due',
	), 
));

$complete_todos = elgg_view('modules/genericmodule', array(
	'view' => 'parentportal/module/todos',
	'module_id' => 'pp-todo-complete-module',
	'module_class' => 'pp-todo-complete-module',
	'view_vars' => array(
		'guid' => $vars['entity']->guid,
		'view_filter' => 'complete',
	), 
));

$body = <<<HTML
	$todo_nav
	<div class='parentportal-todos-content' id='parentportal-todos-incomplete'>
		$incomplete_todos
	</div>
	<div class='parentportal-todos-content' id='parentportal-todos-pastdue'>
		$past_due_todos
	</div>
	<div class='parentportal-todos-content' id='parentportal-todos-complete'>
		$complete_todos
	</div>
HTML;

$options = array(
	'id' => 'parentportal-module-child-todos',
	'class' => 'parentportal-module',
);

echo elgg_view_module('featured', $title, $body, $options);

