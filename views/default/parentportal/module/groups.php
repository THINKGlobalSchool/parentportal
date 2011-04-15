<?php
/**
 * Parent Portal Child Groups info
 *
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */
?>
<div id='parentportal-module-child-groups'>
	<h3 class="pp" style='margin-bottom: 2px;'><?php echo elgg_echo("parentportal:title:childgroups"); ?></h3>
<?php

	$content = elgg_list_entities_from_relationship_count(array(
		'type' => 'group',
		'relationship' => 'member',
		'relationship_guid' => $vars['entity']->getGUID(),
		'inverse_relationship' => false,
		'full_view' => false,
	));

	echo $content;
?>
</div>