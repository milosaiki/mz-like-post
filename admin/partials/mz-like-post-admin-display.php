<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://rs.linkedin.com/in/milos-zivic-2586a174
 * @since      1.0.0
 *
 * @package    Mz_Like_Post
 * @subpackage Mz_Like_Post/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div id="wrap">
	<form method="post" action="options.php">
		<?php
			settings_fields( 'mz-like-post-settings' );
			do_settings_sections( 'mz-like-post-settings' );
			submit_button();
		?>
	</form>
</div>