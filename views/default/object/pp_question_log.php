<?php
/**
 * ParentPortal Question Log Object view
 * 
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */

$question_log = (isset($vars['entity'])) ? $vars['entity'] : FALSE;

if (!$question_log) {
	return '';
}

$metadata = elgg_view_menu('entity', array(
       'entity' => $question_log,
       'handler' => 'question_log',
       'sort_by' => 'priority',
       'class' => 'elgg-menu-hz',
));

$owner_icon = elgg_view_entity_icon($question_log->getOwnerEntity(), 'tiny');
$owner_link = elgg_view('output/url', array(
	'href' => $question_log->getOwnerEntity()->getURL(),
	'text' => $question_log->getOwnerEntity()->name,
	'is_trusted' => true,
));
$author_text = elgg_echo('byline', array($owner_link));
$date = elgg_view_friendly_time($question_log->time_created);

$subtitle = "$author_text $date";

$view_content_link .= elgg_view('output/url', array(
	'text' => elgg_echo('parentportal:label:viewmessagebody'),
	'href' => '#pp-question-message-body-' . $question_log->guid,
	'rel' => 'toggle',
));

$description = elgg_view('output/longtext', array('value' => $question_log->description));

$to_label = elgg_echo('parentportal:label:questionto');
$status_label = elgg_echo('parentportal:label:question_status');
$status_text_label = elgg_echo('parentportal:label:question_status_text');

$content = <<<HTML
	<table>
		<tr>
			<td><strong>$to_label</strong></td>
			<td style='padding-left: 12px;'>$question_log->to_email</td>
		</tr>
		<tr>
			<td><strong>$status_label:</strong></td>
			<td style='padding-left: 12px;'>$question_log->status</td>
		</tr>
		<tr>
			<td><strong>$status_text_label:</strong></td>
			<td style='padding-left: 12px;'>$question_log->status_message</td>
		</tr>
	</table>
	<span class='elgg-subtext'>$view_content_link</span><br /><br />
	<div class='hidden' id='pp-question-message-body-$question_log->guid'>
	$description 
	</div>
HTML;

// brief view
$params = array(
	'title' => $question_log->title,
	'entity' => $question_log,
	'metadata' => $metadata,
	'subtitle' => $subtitle,
	'content' => $content,
);

$list_body = elgg_view('object/elements/summary', $params);

echo elgg_view_image_block($owner_icon, $list_body);