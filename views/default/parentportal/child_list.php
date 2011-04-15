<?php
/**
 * ParentPortal child listing	
 * 
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */

$children = $vars['children'];

foreach ($children as $child) {
	$icon = $child->getIcon('tiny');
	$content .= "<li>";
	$content .= "<img class=\"livesearch_icon\" src=\"$icon\" />";
	$content .= $child->name . ' - ' . $child->username;
	$content .= "</li>";
}
?>
<div>
	<ul class="childlisting">
		<?php echo $content; ?>
	</ul>
</div>
