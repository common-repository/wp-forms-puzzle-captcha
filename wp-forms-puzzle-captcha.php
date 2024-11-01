<?php
/**
 * Plugin Name: WP Forms Puzzle Captcha
 * Description: This plugin used to add Puzzle Captcha to WordPress login and Register form and comment form and various WordPress Forms Plugins. Currently, it support only Contact Form 7 plugin.
 * Version: 4.1
 * Requires at least: 5.6
 * Requires PHP: 7.0
 * Author: Nitin Rathod
 * Author URI: https://www.nitinrathod.info/
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * Text Domain: wfpc-plugin
 * Domain Path: /languages/
 */

 /**
 * Exit if accessed directly
 */
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Define constants
 */
define('WFPC_FILE', __FILE__);
define('WFPC_DIR', plugin_dir_path(WFPC_FILE));
define('WFPC_URL', plugins_url('/', WFPC_FILE));
define('WFPC_BASENAME', plugin_basename(__FILE__));
define('WFPC_TEXT_DOMAIN', 'wfpc-plugin');

/**
 * Main Plugin's 'WFPC_init' class.
 */
if ( ! class_exists( 'WFPC_init' ) ) {
    class WFPC_init {

        /**
         * 'wfpc-plugin' constructor.
         *
         * The main plugin actions registered for WordPress
         */
        public function __construct() {

            $this->hooks();
            $this->WFPC_include_files();
        }

        /**
         * Initialize
         */
        public function hooks() {
            register_activation_hook( __FILE__, array ( $this, 'WFPC_deafult_options') );
            add_action( 'plugins_loaded', array($this, 'WFPC_load_plugin_actions') );
            add_action( 'admin_enqueue_scripts', array($this, 'WFPC_admin_scripts') );
            add_action( 'login_enqueue_scripts', array($this, 'WFPC_login_scripts') );
			if ( function_exists( 'wpcf7_add_form_tag' ) ) {
				add_action( 'wp_enqueue_scripts', array( $this, 'WFPC_login_scripts' ) );
			}

			$is_captcha_enabled_for_login_form = get_option( "is_captcha_enabled_for_login_form" );
			if( $is_captcha_enabled_for_login_form ){
				add_action( 'login_form', 'wpfc_add_puzzle_to_login_form');
			}

			$is_captcha_enabled_for_lostpassword_form = get_option( "is_captcha_enabled_for_lostpassword_form" );
			if( $is_captcha_enabled_for_lostpassword_form ){
				add_action( 'lostpassword_form', 'wpfc_add_puzzle_to_lost_password_form');
			}
			
			$is_captcha_enabled_for_register_form = get_option( "is_captcha_enabled_for_register_form" );
			$users_can_register                   = get_option( "users_can_register" );
			if ( $is_captcha_enabled_for_register_form && $users_can_register ) {
				add_action( 'register_form', 'wpfc_add_puzzle_to_register_form' );
			}
			
			$is_captcha_enabled_for_comment_form = get_option( "is_captcha_enabled_for_comment_form" );
			if ( $is_captcha_enabled_for_comment_form ) {
				add_filter( "comment_form_fields", 'wpfc_add_puzzle_catcha_to_comment_form', 10, 1 );
			}
        }

        /**
         * Load required files
         */
        public function WFPC_include_files() {
            include_once( WFPC_DIR . 'includes/functions.php' );
            include_once( WFPC_DIR . 'includes/admin/admin.php' );
            
        }

        /**
         * Add default options
         */    
        public function WFPC_deafult_options(){
            update_option( 'WFPC_check_welcome','no' );
        }

        /**
         * Load plugin actions
         */
        public function WFPC_load_plugin_actions() {
			if ( function_exists( 'wpcf7_add_form_tag' ) ) {
				if ( ! session_id() ){
					session_start();
				}
				wpcf7_add_form_tag( 'puzzlecaptcha', array( $this, 'WFPC_puzzle_captcha_handler' ), true );
				add_action( 'admin_init', array( $this, 'WFPC_add_default_options' ), 25 );
				add_action( 'admin_init', array( $this, 'WFPC_add_puzzle_generator' ), 25 );
				add_filter( 'wpcf7_validate_puzzlecaptcha', array( $this, 'WFPC_puzzlecaptcha_validation_filter' ), 20, 2 );
				add_filter( 'wpcf7_messages', array( $this, 'WFPC_puzzle_captcha_error_messages' ) );
			}
        }

        /**
         *
         * Register custom field for contact form 7
         */
        public function WFPC_puzzle_captcha_handler( $tag ) {
			
			ob_start();
			
			$_SESSION["wpfc_cf7_form"] = 'started';
			$wfpc_cf7_form             = get_option('wfpc_cf7_form');
			if ( $wfpc_cf7_form['header_text'] ) {
				$header_text = $wfpc_cf7_form['header_text'];
			} else {
				$header_text = __( "Drag To Verify", 'wfpc-plugin' );
			}
			?>
			<span class="wpfc-slidercaptcha wpfc-card wpcf7-form-control-wrap <?php echo $tag->name; ?>">
				<span class="wpfc-card-header">
					<span><?php echo $header_text; ?></span>
				</span>
				<div class="wpfc-card-body"><div data-heading="<?php echo $wfpc_cf7_form['header_text']; ?>" data-slider="<?php echo $wfpc_cf7_form['slider_text']; ?>" data-tryagain="<?php echo $wfpc_cf7_form['try_again_text']; ?>" data-form="cf7" class="wpfc-captcha"></div></div>
			</span>
			<?php
			$html = ob_get_clean();
			return $html;
		}

        /**
         *
         * Add default texts as options.
         */
        public function WFPC_add_default_options() {

			$wfpc_login_form         = get_option( 'wfpc_login_form' );
			$wfpc_register_form      = get_option( 'wfpc_register_form' );
			$wfpc_cf7_form           = get_option( 'wfpc_cf7_form' );
			$wfpc_lost_password_form = get_option( 'wfpc_lost_password_form' );
			$wfpc_comment_form       = get_option( 'wfpc_comment_form' );
			$default_form_array = array( 
				'header_text'    => 'Drag To Verify', 
				'slider_text'    => 'Drag to solve the Puzzle', 
				'try_again_text' => 'Try It Again' 
			);

			if ( ! $wfpc_login_form ) {
				update_option( 'wfpc_login_form', $default_form_array );
			}

			if ( ! $wfpc_register_form ) {
				update_option( 'wfpc_register_form', $default_form_array );
			}

			if ( ! $wfpc_comment_form ) {
				update_option( 'wfpc_comment_form', $default_form_array );
			}

			if ( ! $wfpc_lost_password_form ) {
				update_option( 'wfpc_lost_password_form', $default_form_array );
			}

			if ( ! function_exists( 'wpcf7_add_tag_generator' ) ) {
				return;
			}

			if ( ! $wfpc_cf7_form ) {
				update_option( 'wfpc_cf7_form', $default_form_array );
			}
		}

        /**
         *
         * Register custom tag for contact form 7
         */
        public function WFPC_add_puzzle_generator() {
			
			if (!function_exists('wpcf7_add_tag_generator')) {
				return;
			}
			$name = 'puzzlecaptcha';
			$title = esc_html( __( 'Puzzle Captcha Field', 'wfpc-plugin' ) );
			$elm_id = 'wpcf7-tg-pane-puzzlecaptcha';
			$callback = array( $this, 'WPFC_puzzlecaptcha_tag_callback' );
			wpcf7_add_tag_generator( $name, $title, $elm_id, $callback );
		}

        /**
         *
         * Create custom tag's html for contact form 7
         */
        public function WPFC_puzzlecaptcha_tag_callback( $form, $args = '' ) {
			$args = wp_parse_args( $args, array() );
			$desc = esc_html__( 'Generate a form-tag for a Puzzle Captcha field.', 'wfpc-plugin' );
			?>
			<div class="control-box">
				<fieldset>
					<legend><?php echo $desc; ?></legend>
					<table class="form-table">
						<tbody>
							<tr>
								<th scope="row">
									<label for="<?php echo esc_attr( $args['content'] . '-name' ); ?>"><?php echo esc_html__( 'Name', 'wfpc-plugin' ); ?>
									</label>
								</th>
								<td>
									<input type="text" name="name" class="tg-name oneline" id="<?php echo esc_attr( $args['content'] . '-name' ); ?>" />
								</td>
							</tr>
						</tbody>
					</table>
				</fieldset>
			</div>
			<div class="insert-box">
				<input type="text" name="puzzlecaptcha" class="tag code" readonly="readonly" onfocus="this.select()" />
				<div class="submitbox">
					<input type="button" class="button button-primary insert-tag" value="<?php echo esc_html__( 'Insert Tag', 'wfpc-plugin' ); ?>" />
				</div>
			</div>
			<?php
		}

        /**
         *
         * Validate puzzle captcha plugin for Contact form 7
         */
        public function WFPC_puzzlecaptcha_validation_filter( $result, $tag ) {

			if ( 'puzzlecaptcha' === $tag->type ) {
				if ( ! session_id() ) {
					session_start();
				}
				if ( isset( $_SESSION["wpfc_cf7_form"] ) ) {
					$result->invalidate( $tag, wpcf7_get_message( 'invalid_puzzle_captcha' ) );
				}
				else{
					
				}
			}

			return $result;
		}

        /**
         *
         * Custom error message for puzzle captcha plugin
         */
        public function WFPC_puzzle_captcha_error_messages( $messages ) {
			return array_merge( $messages, array(
				'invalid_puzzle_captcha' => array(
					'description' => esc_html__( "Puzzle Captcha error message when the sender doesn't solve it.", 'wfpc-plugin' ),
					'default' => esc_html__( 'Please solve the puzzle for form processing.', 'wfpc-plugin' )
				)
			));
		}

        /**
         *
         * Enqueue admin panel required css/js
         */
        public function WFPC_admin_scripts() {
            wp_enqueue_style( 'wfpc-admin-css', WFPC_URL . 'assets/admin/css/admin.css', array() );
            wp_enqueue_script( 'wfpc-admin-js', WFPC_URL . 'assets/admin/js/admin.js', array( 'jquery' ), false );
        }

        /**
         *
         * Enqueue required css/js for login page and frontend
         */
        public function WFPC_login_scripts() {
            wp_enqueue_style( 'wfpc-admin-css', WFPC_URL . 'assets/css/wfpc-puzzle-captcha.css', array() );
            wp_enqueue_script( 'wfpc-admin-js', WFPC_URL . 'assets/js/wfpc-puzzle-captcha.js', array( 'jquery' ), false, true );
            wp_enqueue_script( 'wfpc-login-js', WFPC_URL . 'assets/js/wfpc-custom-script.js', array( 'wfpc-admin-js' ), false, true );

			$wfpc_custom_ajax_data = array(
				'url' => admin_url( 'admin-ajax.php' ),
				'img_url' => WFPC_URL."assets/"
			);
			wp_localize_script( 'wfpc-login-js', 'wfpc_ajax', $wfpc_custom_ajax_data );
        }
    }
}

/*
 * Starts our plugin action!
 */
new WFPC_init();