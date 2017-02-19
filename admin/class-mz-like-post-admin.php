<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://rs.linkedin.com/in/milos-zivic-2586a174
 * @since      1.0.0
 *
 * @package    Mz_Like_Post
 * @subpackage Mz_Like_Post/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mz_Like_Post
 * @subpackage Mz_Like_Post/admin
 * @author     Milos Zivic <milosh.zivic@gmail.com>
 */
class Mz_Like_Post_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		// wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mz-like-post-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		// wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/mz-like-post-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function register_settings_page(){

		//Submenu args
		add_submenu_page(
			'tools.php',							//parent_slug
			__("MZ Like Post", "mz-like-post"),		//page_title	
			__("MZ Like Post", "mz-like-post"),		//menu_title
			'manage_options',						//capability
			'mz-like-post',							//menu_slug
			array($this, 'display_settings_page')	//callable function
			);
	}

	public function display_settings_page(){

		require_once plugin_dir_path(dirname(__FILE__)).'admin/partials/mz-like-post-admin-display.php';

	}

	/**
	 * Register settings 
	 */
	public function register_settings(){

		// Settings registration
		register_setting(
			$this->plugin_name.'-settings',
			$this->plugin_name.'-settings',
			array($this, 'sandbox_register_setting')
		);

		//Adds settings section
		add_settings_section(
			$this->plugin_name.'-settings-section',
			__('MZ Like Post Settings', 'mz-like-post'),
			array($this, 'sandbox_add_settings_section'),
			$this->plugin_name.'-settings'
		);

		//Adds fields to settings page
		add_settings_field(
			'post-types',
			__('Post Types', 'mz-like-post'),
			array($this, "sandbox_add_settings_field_multiple_checkbox"),
			$this->plugin_name.'-settings',
			$this->plugin_name.'-settings-section',
			array(
				'label_for'		=>	'post-types',
				'description'	=>	__('Like button will be added only to the selected post types', 'mz-like-post')
			)
		);

		add_settings_field(
			'toggle-content-override',
			__("Add Like Button", "mz-like-post"),
			array($this, 'sandbox_add_settings_field_single_checkbox'),
			$this->plugin_name.'-settings',
			$this->plugin_name.'-settings-section',
			array(
				'label_for'		=>	'toggle-content-override',
				'description'	=>	__('Adds Like button to the content, if checked', 'mz-like-post')
			)
		);

		add_settings_field(
			'like-text',
			__('Text for Like button', 'mz-like-post'),
			array($this, 'sandbox_add_settings_field_input_text'),
			$this->plugin_name . '-settings',
			$this->plugin_name . '-settings-section',
			array(
				'label_for'		=>	'like-text',
				'default'	=>	__('Like', 'mz-like-post')
				)
		);

		add_settings_field(
			'liked-text',
			__('Text for Liked button', 'mz-like-post'),
			array($this, 'sandbox_add_settings_field_input_text'),
			$this->plugin_name . '-settings',
			$this->plugin_name . '-settings-section',
			array(
				'label_for'		=>	'liked-text',
				'default'	=>	__('Liked', 'mz-like-post')
				)
		);

		add_settings_field(
			'liked-msg',
			__('Text for liked post link', 'mz-like-post'),
			array($this, 'sandbox_add_settings_field_input_text'),
			$this->plugin_name . '-settings',
			$this->plugin_name . '-settings-section',
			array(
				'label_for'		=>	'liked-msg',
				'default'	=>	__('Liked. Click to see all liked posts', 'mz-like-post')
				)
		);

		add_settings_field(
			'no-liked-msg',
			__('Text when no posts are liked', 'mz-like-post'),
			array($this, 'sandbox_add_settings_field_input_text'),
			$this->plugin_name . '-settings',
			$this->plugin_name . '-settings-section',
			array(
				'label_for'		=>	'no-liked-msg',
				'default'	=>	__('There are no liked post(s)', 'mz-like-post')
				)
		);
		add_settings_field(
			'not-logged-msg',
			__('Text when user is not logged in', 'mz-like-post'),
			array($this, 'sandbox_add_settings_field_input_text'),
			$this->plugin_name . '-settings',
			$this->plugin_name . '-settings-section',
			array(
				'label_for'		=>	'not-logged-msg',
				'default'	=>	__('You must be logged in to like this post. Please Logg in!', 'mz-like-post')
				)
		);

	}

	/**
	 * Settings and sandbox
	 */
	public function sandbox_register_setting($input){
		$new_input = array();
		if(isset($input)){
			//loop trough each input and sanitize value
			foreach($input as $key => $value){
				if($key == 'post-types'){
					$new_input[$key] = $value;
				} else {
					$new_input[$key] = sanitize_text_field($value);
				}
			}
		}
		return $new_input;
	}

	/**
	 * Sandbox section for settings
	 */
	public function sandbox_add_settings_section(){
		return;
	}

	/**
	 * Sandbox settings for single checkbox
	 */
	public function sandbox_add_settings_field_single_checkbox($args){
		$field_id = $args['label_for'];
		$field_description = $args['description'];

		$options = get_option($this->plugin_name.'-settings');
		$option = 0;

		if(!empty($options[$field_id])){
			$option = $options[$field_id];
		}
		?>
		<label for='<?php echo $this->plugin_name."-settings[".$field_id."]"; ?>'>
			<input type="checkbox" name='<?php echo $this->plugin_name."-settings[".$field_id."]"; ?>' id='<?php echo $this->plugin_name."-settings[".$field_id."]"; ?>' <?php checked($option, true, 1);?> value='1'>
			<span class="description"><?php echo esc_html($field_description);?></span>
		</label>

		<?php
	}
	/**
 * Sandbox our multiple checkboxes
 *
 * @since    1.0.0
 */
public function sandbox_add_settings_field_multiple_checkbox( $args ) {
	$field_id = $args['label_for'];
	$field_description = $args['description'];
	$options = get_option( $this->plugin_name . '-settings' );
	$option = array();
	if ( ! empty( $options[ $field_id ] ) ) {
		$option = $options[ $field_id ];
	}
	if ( $field_id == 'post-types' ) {
		$args = array(
			'public' => true
		);
		$post_types = get_post_types( $args, 'objects' );
		foreach ( $post_types as $post_type ) {
			if ( $post_type->name != 'attachment' ) {
				if ( in_array( $post_type->name, $option ) ) {
					$checked = 'checked="checked"';
				} else {
					$checked = '';
				}
				?>

					<fieldset>
						<label for="<?php echo $this->plugin_name . '-settings[' . $field_id . '][' . $post_type->name . ']'; ?>">
							<input type="checkbox" name="<?php echo $this->plugin_name . '-settings[' . $field_id . '][]'; ?>" id="<?php echo $this->plugin_name . '-settings[' . $field_id . '][' . $post_type->name . ']'; ?>" value="<?php echo esc_attr( $post_type->name ); ?>" <?php echo $checked; ?> />
							<span class="description"><?php echo esc_html( $post_type->label ); ?></span>
						</label>
					</fieldset>

				<?php
			}
		}
	} else {
		$field_args = $args['options'];
		foreach ( $field_args as $field_arg_key => $field_arg_value ) {
			if ( in_array( $field_arg_key, $option ) ) {
				$checked = 'checked="checked"';
			} else {
				$checked = '';
			}
			?>

				<fieldset>
					<label for="<?php echo $this->plugin_name . '-settings[' . $field_id . '][' . $field_arg_key . ']'; ?>">
						<input type="checkbox" name="<?php echo $this->plugin_name . '-settings[' . $field_id . '][]'; ?>" id="<?php echo $this->plugin_name . '-settings[' . $field_id . '][' . $field_arg_key . ']'; ?>" value="<?php echo esc_attr( $field_arg_key ); ?>" <?php echo $checked; ?> />
						<span class="description"><?php echo esc_html( $field_arg_value ); ?></span>
					</label>
				</fieldset>

			<?php
		}
	}
	?>

		<p class="description"><?php echo esc_html( $field_description ); ?></p>

	<?php
}
	/**
	 * Sandbox our inputs with text
	 *
	 * @since    1.0.0
	 */
	public function sandbox_add_settings_field_input_text( $args ) {
		$field_id = $args['label_for'];
		$field_default = $args['default'];
		$options = get_option( $this->plugin_name . '-settings' );
		$option = $field_default;
		if ( ! empty( $options[ $field_id ] ) ) {
			$option = $options[ $field_id ];
		}
		?>
		
			<input type="text" name="<?php echo $this->plugin_name . '-settings[' . $field_id . ']'; ?>" id="<?php echo $this->plugin_name . '-settings[' . $field_id . ']'; ?>" value="<?php echo esc_attr( $option ); ?>" class="regular-text" />

		<?php
	}

}
