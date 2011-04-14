<?php
/**
 * Elgg user account settings.
 *
 * @package Elgg
 * @subpackage Core
 * @author Curverider Ltd
 * @link http://elgg.org/
 */

// Make sure only valid admin users can see this
gatekeeper();

// Make sure we don't open a security hole ...
if ((!page_owner_entity()) || (!page_owner_entity()->canEdit())) {
	set_page_owner(elgg_get_logged_in_user_guid());
}

$content = elgg_view_title(elgg_echo('usersettings:user'));
$content .= elgg_view("usersettings/form");

echo "<div id='pp_settings'>" . $content . "</div>";

