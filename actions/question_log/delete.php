<?php
/**
 * ParentPortal Delete Question Log Entity Action
 * 
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */

$guid = get_input('guid');
$entity = get_entity($guid);

if (($entity) && ($entity->canEdit())) {
	if ($entity->delete()) {
		system_message(elgg_echo('entity:delete:success', array($guid)));
	} else {
		register_error(elgg_echo('entity:delete:fail', array($guid)));
	}
} else {
	register_error(elgg_echo('entity:delete:fail', array($guid)));
}

forward(REFERER);