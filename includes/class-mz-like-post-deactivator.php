<?php
//includes/class-toptal-save-activator.php
/**
 * Fired during plugin deactivation
 *
 * @link       https://rs.linkedin.com/in/milos-zivic-2586a174
 * @since      1.0.0
 *
 * @package    Mz_Like_Post
 * @subpackage Mz_Like_Post/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Mz_Like_Post
 * @subpackage Mz_Like_Post/includes
 * @author     Milos Zivic <milosh.zivic@gmail.com>
 */
class Mz_Like_Post_Deactivator {

	/**
	 *
	 * On plugin deactivation delete created Liked page and
	 * delte it's ID from database
	 * 
	 * @since    1.0.0
	 */
	public static function deactivate() {

		// Get page ID
		$liked_page_id = get_option('mz_like_post_page_id');

		//Check if page with that ID exist
		if($liked_page_id){
			// Delete saved page
			wp_delete_post($liked_page_id, true);
			//Delete page Id from database
			delete_option('mz_like_post_page_id');
		}

	}

}
