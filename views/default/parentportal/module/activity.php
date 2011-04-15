<?php
/**
 * Parent Portal Child latest activity
 *
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */
?>
<div id='parentportal-module-child-activity'>
	<h3 class="pp"><?php echo elgg_echo("parentportal:title:childactivity"); ?></h3>
<?php
	$params = array(
		'subject_guid' => $vars['entity']->getGUID(),
		'limit' => 5,
	);
	
	$activity = elgg_list_river($params);
	
	echo $activity;
?>
</div>