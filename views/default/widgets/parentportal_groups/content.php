<?php
/**
 * Parent portal child groups widget
 * 
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010 - 2013
 * @link http://www.thinkglobalschool.com/
 *
 */

$child = get_user(get_input('child_select', $_SESSION['child_select']));

echo elgg_view('parentportal/child_groups', array('child_guid' => $child->guid));