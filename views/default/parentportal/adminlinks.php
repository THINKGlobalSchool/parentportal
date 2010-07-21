<?php 
	/**
	 * ParentPortal admin links	
	 * 
	 * @package ParentPortal
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Jeff Tilson
	 * @copyright THINK Global School 2010
	 * @link http://www.thinkglobalschool.com/
	 * 
	 */
	
?>
<a href="<?php echo $vars['url']; ?>pg/parentportal/manageparent/<?php echo $vars['entity']->username; ?>/"><?php echo elgg_echo('parentportal:menu:admin:manageparent'); ?></a>