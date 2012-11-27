<?php
/**
 * ParentPortal Admin Question Log
 * 
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */

$options = array(
	'type' => 'object',
	'subtype' => 'pp_question_log',
	'limit' => 15,
	'pagination' => TRUE,
	'full_view' => FALSE,
);

$content = elgg_list_entities($options);

if (!$content) {
	$content = "<strong>No Results</strong>";
}

echo $content;