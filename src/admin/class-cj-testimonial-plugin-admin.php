<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       cjwsstrm.com
 * @since      1.0.0
 *
 * @package    Cj_Testimonial_Plugin
 * @subpackage Cj_Testimonial_Plugin/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Cj_Testimonial_Plugin
 * @subpackage Cj_Testimonial_Plugin/admin
 * @author     CJ Wesstrom <cjwesstrom@gmail.com>
 */
class Cj_Testimonial_Plugin_Admin {

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
		 * defined in Cj_Testimonial_Plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cj_Testimonial_Plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cj-testimonial-plugin-admin.min.css', array(), $this->version, 'all' );

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
		 * defined in Cj_Testimonial_Plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cj_Testimonial_Plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cj-testimonial-plugin-admin.min.js', array( 'jquery' ), $this->version, true );

	}

	function testimonial_post_type() {
 
		// Set UI labels for Custom Post Type
			$labels = array(
				'name'                => _x( 'Testimonials', 'Post Type General Name', 'cjwsstrm' ),
				'singular_name'       => _x( 'Testimonial', 'Post Type Singular Name', 'cjwsstrm' ),
				'menu_name'           => __( 'Testimonials', 'cjwsstrm' ),
				'parent_item_colon'   => __( 'Parent Testimonial', 'cjwsstrm' ),
				'all_items'           => __( 'All Testimonials', 'cjwsstrm' ),
				'view_item'           => __( 'View Testimonial', 'cjwsstrm' ),
				'add_new_item'        => __( 'Add New Testimonial', 'cjwsstrm' ),
				'add_new'             => __( 'Add New', 'cjwsstrm' ),
				'edit_item'           => __( 'Edit Testimonial', 'cjwsstrm' ),
				'update_item'         => __( 'Update Testimonial', 'cjwsstrm' ),
				'search_items'        => __( 'Search Testimonial', 'cjwsstrm' ),
				'not_found'           => __( 'Not Found', 'cjwsstrm' ),
				'not_found_in_trash'  => __( 'Not found in Trash', 'cjwsstrm' ),
			);
			 
		// Set other options for Custom Post Type
			 
			$args = array(
				'label'               => __( 'Testimonials', 'cjwsstrm' ),
				'description'         => __( 'Testimonial news and reviews', 'cjwsstrm' ),
				'labels'              => $labels,
				// Features this CPT supports in Post Editor
				'supports'            => array( 'title', 'revisions' ),
				/* A hierarchical CPT is like Pages and can have
				* Parent and child items. A non-hierarchical CPT
				* is like Posts.
				*/ 
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_nav_menus'   => true,
				'show_in_admin_bar'   => true,
				'menu_position'       => 5,
				'can_export'          => true,
				'has_archive'         => true,
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'capability_type'     => 'post',
			);
			 
			// Registering your Custom Post Type
			register_post_type( 'testimonials', $args );
		 
		}

		public function testimonials_meta_boxes() {
			add_meta_box(
				'testimonials_meta_box', // $id
				'Testimonial Content', // $title
				array( $this, 'testimonials_content_meta_fields_callback' ), // $callback
				'testimonials', // $screen
				'normal', // $context
				'high' // $priority
			);
		}

		public function testimonials_content_meta_fields_callback() {
			global $post;  
			$meta = get_post_meta( $post->ID, 'testimonial_content', true ); ?>
		
			<input type="hidden" name="testimonials_meta_box_nonce" value="<?php echo wp_create_nonce( basename(__FILE__) ); ?>">
		
			<p>
				<label for="testimonial_content[textarea]">Customer Quote</label>
				<br>
				<textarea name="testimonial_content[textarea]" id="testimonial_content[textarea]" rows="5" cols="30" style="width:500px"><?php  if (is_array($meta) && isset($meta['textarea'])){ echo $meta['textarea']; } ?></textarea>
			</p>
			<p>
				<label for="testimonials[background]">Background Image</label><br>
				<input type="text" name="testimonials[background]" id="testimonials[background]" class="meta-image regular-text" value="<?php  if (is_array($meta) && isset($meta['background'])){ echo $meta['background']; } ?>">
				<input type="button" class="button image-upload" value="Browse">
			</p>
			<div class="background-preview">
				<img src="<?php  if (is_array($meta) && isset($meta['background'])){ echo $meta['background']; } ?>" style="max-width: 250px;">
			</div>
			<p>
				<label for="testimonials[logo]">logo Image</label><br>
				<input type="text" name="testimonials[logo]" id="testimonials[logo]" class="meta-image regular-text" value="<?php  if (is_array($meta) && isset($meta['logo'])){ echo $meta['logo']; } ?>">
				<input type="button" class="button image-upload" value="Browse">
			</p>
			<div class="logo-preview">
				<img src="<?php  if (is_array($meta) && isset($meta['logo'])){ echo $meta['logo']; } ?>" style="max-width: 250px;">
			</div>
		
			<?php 
		}

		function save_testimonial_meta_fields( $post_id ) {   
			// verify nonce
			if ( !wp_verify_nonce( $_POST['testimonials_meta_box_nonce'], basename(__FILE__) ) ) {
				return $post_id; 
			}
			// check autosave
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return $post_id;
			}
			// check permissions
			if ( 'page' === $_POST['post_type'] ) {
				if ( !current_user_can( 'edit_page', $post_id ) ) {
					return $post_id;
				} elseif ( !current_user_can( 'edit_post', $post_id ) ) {
					return $post_id;
				}  
			}
			
			$old = get_post_meta( $post_id, 'testimonial_content', true );
			$new = $_POST['testimonial_content'];
		
			if ( $new && $new !== $old ) {
				update_post_meta( $post_id, 'testimonial_content', $new );
			} elseif ( '' === $new && $old ) {
				delete_post_meta( $post_id, 'testimonial_content', $old );
			}
		}

}
