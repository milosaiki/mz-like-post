<?php
// includes/class-toptal-save-activator.php
/**
 * Fired during plugin activation
 *
 * @link       https://rs.linkedin.com/in/milos-zivic-2586a174
 * @since      1.0.0
 *
 * @package    Mz_Like_Post
 * @subpackage Mz_Like_Post/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Mz_Like_Post
 * @subpackage Mz_Like_Post/includes
 * @author     Milos Zivic <milosh.zivic@gmail.com>
 */
class Mz_Like_Post_Activator {

	/**
	*
	 * On plugin activation creates a Liked page with shortcode in it
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		//Creates args for Liked page
		$liked_page_args=array(
			'post_title'	=> __('Liked','mz-like-post'),
			'post_content'	=> '[mz-like-post]',
			'post_status'	=>	'publish',
			'post_type'		=>	'page'
			);

		//Inserts page and gets the page ID
		$liked_page_id = wp_insert_post($liked_page_args);

		//Saves page ID to database
		add_option('mz_like_post_liked_page_id', $liked_page_id);
	}

}
