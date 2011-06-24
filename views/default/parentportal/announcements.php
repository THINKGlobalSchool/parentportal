<?php
/**
 * ParentPortal announcements view
 * 
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */

echo elgg_view('announcements/announcement_list', array('container_guid' => elgg_get_plugin_setting('parentgroup','parentportal')));