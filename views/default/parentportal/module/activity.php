<?php
/**
 * Parent Portal activity module
 *
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */

$title = elgg_echo("parentportal:title:childactivity");

$params = array(
	'subject_guid' => $vars['entity']->getGUID(),
	'limit' => 5,
);

$body = elgg_list_river($params);

$options = array(
	'id' => 'parentportal-module-child-activity',
	'class' => 'parentportal-module',
);

echo elgg_view_module('featured', $title, $body, $options);
