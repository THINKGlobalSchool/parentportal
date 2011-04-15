<?php
/**
 * ParentPortal announcement container
 * 
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */

$owner = $vars['entity']->getOwnerEntity();

$owner_link = elgg_view('output/url', array(
	'href' => "profile/$owner->username",
	'text' => $owner->name,
));
$author_text = elgg_echo('byline', array($owner_link));

$date = elgg_view_friendly_time($vars['entity']->time_created);

$subtext =  "$author_text $date";

switch ($vars['entity']->getSubtype()) {
	case 'blog':
		$content = $vars['entity']->excerpt;
		$subtitle = $subtext;
		break;
	case 'thewire':
		// Strip out hashtags and parse urls
		$desc = parse_urls($vars['entity']->description);
		$desc = (preg_replace('/#([A-Aa-z0-9_-]+)/is', '', $desc));
		$content = "<strong>$desc</strong>";
		$content .= "<br /><div class=\"elgg-subtext\">$subtext</div>";
		break;
}

$params = array(
	'entity' => $vars['entity'],
	'content' => $content,
	'tags' => FALSE,
	'subtitle' => $subtitle,
	
);

$body = elgg_view('page/components/summary', $params);
echo elgg_view_image_block('', $body);
