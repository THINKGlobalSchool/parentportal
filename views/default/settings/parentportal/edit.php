<?php
/**
 * ParentPortal settings form
 * 
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */
?>
<br />
<div>
    <label><?php echo elgg_echo('parentportal:label:urltoggle'); ?></label><br />
    <?php 
	echo elgg_view('input/dropdown', array(
										'name' => 'params[urltoggle]', 
										'value' => $vars['entity']->urltoggle, 
										'options_values' => array(0 => elgg_echo('parentportal:label:blacklist'), 1 => elgg_echo('parentportal:label:whitelist')))
										);
	?>
</div>
<div>
    <label><?php echo elgg_echo('parentportal:label:urllist'); ?></label><br />
    <?php 
	echo elgg_view('input/plaintext', array(
										'name' => 'params[urllist]', 
										'value' => $vars['entity']->urllist)
										); 
	?>
</div>
<div>
	<label><?php echo elgg_echo('parentportal:label:parentgroup'); ?></label><br />
	<?php 
	
	$groups = elgg_get_entities(array(
		'type' => 'group',
		'limit' => 0,
	));
							

	$groups_array = array();

	foreach ($groups as $group) {
		$groups_array[$group->getGUID()] = $group->name;
	}
		
	echo elgg_view('input/dropdown', array(
										'name' => 'params[parentgroup]', 
										'value' => $vars['entity']->parentgroup, 
										'options_values' => $groups_array
										));
	?>
</div>
<div>
    <label><?php echo elgg_echo('parentportal:label:parenttag'); ?></label><br />
    <?php 
	echo elgg_view('input/text', array(
										'name' => 'params[parenttag]', 
										'value' => $vars['entity']->parenttag)
										); 
	?>
</div>
<div>
	<label><?php echo elgg_echo('parentportal:label:parentcontacts'); ?></label><br />
	<?php 
	echo elgg_view('input/plaintext', array(
										'name' => 'params[parentcontacts]', 
										'value' => $vars['entity']->parentcontacts)
										); 
	?>
</div>