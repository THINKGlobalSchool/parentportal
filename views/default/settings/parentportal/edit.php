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
<p>
    <label><?php echo elgg_echo('parentportal:label:urltoggle'); ?></label><br />
    <?php 
	echo elgg_view('input/pulldown', array(
										'internalname' => 'params[urltoggle]', 
										'value' => $vars['entity']->urltoggle, 
										'options_values' => array(0 => elgg_echo('parentportal:label:blacklist'), 1 => elgg_echo('parentportal:label:whitelist')))
										);
	?>
</p>
<p>
    <label><?php echo elgg_echo('parentportal:label:urllist'); ?></label><br />
    <?php 
	echo elgg_view('input/plaintext', array(
										'internalname' => 'params[urllist]', 
										'value' => $vars['entity']->urllist)
										); 
	?>
</p>
