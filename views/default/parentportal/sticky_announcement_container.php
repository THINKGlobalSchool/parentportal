<?php
/**
 * ParentPortal lib
 * 
 * @package ParentPortal
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jeff Tilson
 * @copyright THINK Global School 2010
 * @link http://www.thinkglobalschool.com/
 * 
 */	
// Grab the parent channel id
$parent_channel_id = elgg_get_plugin_setting('parentchannel', 'parentportal');
$sac = get_entity($parent_channel_id);
$content = elgg_view('announcements/announcement_container', array('sac' => $sac));

?>
<div id='pp_sticky_announcement_container'>
<?php echo $content ?>
</div>