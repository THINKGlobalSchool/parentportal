<?php
/**
 * Ajaxmodule Custom Module
 *
 * @package Ajaxmodule
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 *
 * @uses $vars['container_guid'] 	Container guid for content
 * @uses $vars['tag']				Tag to match
 * @uses $vars['subtypes'] 			Subtypes
 * @uses $vars['title'] 			Module title
 * @uses $vars['limit] 				Limit
 */

if ($vars['listing_type']) {
	$listing_type_input = elgg_view('input/hidden', array(
		'internalname' => "listing_type",
		'internalid' => "listing_type",
		'value' => $vars['listing_type'],
	));
}

$id = uniqid();

$container_input = elgg_view('input/hidden', array(
	'internalname' => "container_guid",
	'internalid' => "container_guid",
	'value' => $vars['container_guid'],
));

$tag_input = elgg_view('input/hidden', array(
	'internalname' => "tag",
	'internalid' => "tag",
	'value' => $vars['tag']
));

$subtypes_input = elgg_view('input/hidden', array(
	'internalname' => "subtypes",
	'internalid' => "subtypes",
	'value' => json_encode($vars['subtypes']),
));

$limit_input = elgg_view('input/hidden', array(
	'internalname' => "limit",
	'internalid' => "limit",
	'value' => $vars['limit'],
));

$spinner = elgg_get_site_url() . "_graphics/ajax_loader_bw.gif";

echo <<<HTML
	<div style='margin-bottom: 10px;'>
		<h3 class="pp">{$vars['title']}</h3>
		<div id="$id" class="ajaxmodule-content-container">
			<div class='options'>
				$listing_type_input
				$container_input
				$tag_input
				$subtypes_input
				$limit_input
			</div>
			<div class='content'>
				<div style='margin: 10px; text-align: center;'><img src="{$spinner}" /></div>
			</div>
		</div>
	</div>
HTML;

?>
