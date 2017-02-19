<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://rs.linkedin.com/in/milos-zivic-2586a174
 * @since      1.0.0
 *
 * @package    Mz_Like_Post
 * @subpackage Mz_Like_Post/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mz_Like_Post
 * @subpackage Mz_Like_Post/public
 * @author     Milos Zivic <milosh.zivic@gmail.com>
 */
class Mz_Like_Post_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 *
	 * @param      string $plugin_name The name of the plugin.
	 * @param      string $version The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mz_Like_Post_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mz_Like_Post_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mz-like-post-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mz_Like_Post_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mz_Like_Post_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/mz-like-post-public.js', array( 'jquery' ), $this->version, false );

		$options = get_option( $this->plugin_name . '-settings' );

		//Text
		$like_text      = $options['like-text'];
		$liked_text     = $options['liked-text'];
		$liked_msg      = $options['liked-msg'];
		$no_liked_msg   = $options['no-liked-msg'];
		$not_logged_msg = $options['not-logged-msg'];

		$liked_page_id  = get_option( 'mz_like_post_liked_page_id' );
		$liked_page_url = get_permalink( $liked_page_id );

		wp_localize_script(
			$this->plugin_name,
			'mz_like_post_ajax',
			array(
				'ajax_url'       => admin_url( 'admin-ajax.php' ),
				'like_text'      => $like_text,
				'liked_text'     => $liked_text,
				'liked_msg'      => $liked_msg,
				'no_liked_msg'   => $no_liked_msg,
				'not_logged_msg' => $not_logged_msg,
				'liked_page_url' => $liked_page_url
			)
		);

	}


	/**
	 * Show Like button
	 */
	public function show_like_button( $item_id = 0 ) {

		//Get item ID
		if ( empty( $item_id ) ) {
			$item_id = get_queried_object_id();
		}

		//Text for button
		$options        = get_option( $this->plugin_name . '-settings' );
		$like_text      = $options['like-text'];
		$liked_text     = $options['liked-text'];
		$not_logged_msg = $options['not-logged-msg'];
		$liked_msg      = $options['liked-msg'];
		$liked_page_id  = get_option( 'mz_like_post_liked_page_id' );
		$liked_page_url = get_permalink( $liked_page_id );

		//Check if the user is logged in
		if ( is_user_logged_in() ) {
			$liked_items = get_user_meta( get_current_user_id(), 'mz_like_post_liked_items', false );

			$is_liked = false;

			foreach( $liked_items as $liked_item ) {
				//Checks if post is already liked
				if ( in_array( $item_id, $liked_item ) ) {
					$is_liked = true;
				}
			}

			if( $is_liked  === true ) {
				
				$likePost = '<a href="#" class="mzlp-btn liked" data-nonce="' . wp_create_nonce( 'mz_like_post_nonce' ) . '" 
							data-item-id="' . esc_attr( $item_id ) . '">';
				$likePost .='<span class="mzlp-text">' . esc_html( $liked_text ) . '</span></a><br/>';
				$likePost .='<div class="notification">';
				$likePost .='<a class="notification-link" href="'.$liked_page_url.'">'.$liked_msg.'</a></div>';
				return $likePost;

			} else {
				
				$likePost = '<a href="#" class="mzlp-btn like" data-nonce="' . wp_create_nonce( 'mz_like_post_nonce' ) . '" 
							data-item-id="' . esc_attr( $item_id ) . '">';
				$likePost .='<span class="mzlp-text">' . esc_html( $like_text ) . '</span></a><br/>';
				$likePost .='<div class="notification">';
				$likePost .='<a class="notification-link" href="'.$liked_page_url.'" style="display:none;">'.$liked_msg.'</a></div>';
				return $likePost;

			}

		} else {
			return esc_html( $not_logged_msg );
		}
	}

	/**
	 * Append the button
	 */
	public function append_the_button( $content ) {

		$item_id = get_queried_object_id();

		//get current post type
		$current_post_type = get_post_type( $item_id );

		//get liked page id
		$liked_page_id = get_option( 'mz_like_post_liked_page_id' );

		//default values
		$post_types = array();
		$override   = 0;

		//get options
		$options = get_option( $this->plugin_name . '-settings' );
		if ( ! empty( $options['post-types'] ) ) {
			$post_types = $options['post-types'];
		}
		if ( ! empty( $options['toggle-content-override'] ) ) {
			$override = $options['toggle-content-override'];
		}

		if ( $override == 1 && ! empty( $post_types ) && ! is_page( $liked_page_id ) && in_array( $current_post_type, $post_types ) && is_singular() ) {
			//Add button
			$likeBtn = "";
			ob_start();
			echo $this->show_like_button();
			$likeBtn .= ob_get_contents();
			ob_end_clean();
			$content = $content . $likeBtn;
		}

		return $content;
	}

	/**
	 * Like/Liked post
	 */
	public function like_post() {

		//Checks nonce
		if ( ! wp_verify_nonce( $_REQUEST['nonce'], 'mz_like_post_nonce' ) ) {
			die;
		}

		//Getting ID from the AJAX
		if ( isset( $_POST['item_id'] ) ) {

			$item_id = intval( $_POST['item_id'] );

		} else {

			$item_id = 0;
			wp_die();

		}

		$is_liked = false;

		//Checks if user is logged in
		if ( is_user_logged_in() ) {

			$liked_items = array();
			$liked_items = get_user_meta( get_current_user_id(), 'mz_like_post_liked_items', true );

			//Checks if post is liked or not
			if ( in_array( $item_id, $liked_items ) ) {
				$is_liked = true;
			} else {
				$is_liked = true;
				$liked_items[] =  $item_id;
				update_user_meta( get_current_user_id(), 'mz_like_post_liked_items', $liked_items );
			}
		} else {
			return "<p>" . esc_html( $not_logged_msg ) . "</p>";
		}
		// Create an array of data that we will return back to our AJAX
		$return = array(
			'is_liked' => $is_liked
		);

		// Return the data
		return wp_send_json( $return );

	}

	/**
	 * Unlike post
	 */
	public function unlike_post() {

		//Checks nonce
		if ( ! wp_verify_nonce( $_REQUEST['nonce'], 'mz_like_post_nonce' ) ) {
			die;
		}

		//Getting ID from the AJAX
		if ( isset( $_POST['item_id'] ) ) {

			$item_id = intval( $_POST['item_id'] );

		} else {

			$item_id = 0;
			wp_die();

		}

		$is_liked = true;

		//Checks if user is logged in
		if ( is_user_logged_in() ) {

			$liked_items = array();
			$liked_items = get_user_meta( get_current_user_id(), 'mz_like_post_liked_items', true );

			//Checks if post is liked or not
			if ( in_array( $item_id, $liked_items ) ) {
				$position = array_search( $item_id, $liked_items );
				unset($liked_items[$position]);
				update_user_meta( get_current_user_id(), 'mz_like_post_liked_items', $liked_items );
				$is_liked = false;
			} else {
				// $is_liked = true;
				$is_liked = false;

			}
		} else {
			return "<p>" . esc_html( $not_logged_msg ) . "</p>";
		}
		// Create an array of data that we will return back to our AJAX
		$return = array(
			'is_liked' => $is_liked
		);

		// Return the data
		return wp_send_json( $return );

	}

	public function register_mz_like_post_shortcode() {
		$liked_items = get_user_meta( get_current_user_id(), 'mz_like_post_liked_items', false );

		ob_start();

		?>
		<div class='liked-posts'>
		<ul>
		<?php

		foreach( $liked_items as $liked_item ) {

			foreach ( $liked_item as $item ) {

				?>

				<li>
					<a href="<?php print get_permalink( $item ) ?>">
						<?php print get_the_title( $item ); ?>
					</a>
				</li>

				<?php

			}

		}

		?>
		</ul>
		</div>
		<?php

	}

	public function register_shortcodes() {
		add_shortcode( 'mz-like-post', array( $this, 'register_mz_like_post_shortcode') );
	}

}

