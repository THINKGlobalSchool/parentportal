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

$params = array(
	'subject_guid' => $vars['guid'],
	'limit' => 5,
);

echo elgg_list_river($params);

