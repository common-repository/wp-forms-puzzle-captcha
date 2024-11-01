<?php
/**
*
* add puzzle captcha to login form of WordPress
*/

if( ! function_exists( "wpfc_add_puzzle_to_login_form" ) ) {
	function wpfc_add_puzzle_to_login_form() {
		
		if ( ! session_id() ) {
			session_start();
		}
		
		$_SESSION["wpfc_login_form"] = 'started';
		$wfpc_login_form             = get_option('wfpc_login_form');
		if ( $wfpc_login_form['header_text'] ) {
			$header_text = $wfpc_login_form['header_text'];
		} else {
			$header_text = __( "Drag To Verify", 'wfpc-plugin' );
		}
		if ( $wfpc_login_form['slider_text'] ) {
			$slider_text = $wfpc_login_form['slider_text'];
		} else {
			$slider_text = __( "Drag to solve the Puzzle", 'wfpc-plugin' );
		}
		if ( $wfpc_login_form['try_again_text'] ) {
			$try_again_text = $wfpc_login_form['try_again_text'];
		} else {
			$try_again_text = __( "Try It Again", 'wfpc-plugin' );
		}
		?>
		<div class="wpfc-slidercaptcha wpfc-card">
			<div class="wpfc-card-header">
				<span><?php echo $header_text; ?></span>
			</div>
			<div class="wpfc-card-body"><div data-heading="<?php echo $wfpc_login_form['header_text']; ?>" data-slider="<?php echo $slider_text; ?>" data-tryagain="<?php echo $try_again_text; ?>" data-form="login" class="wpfc-captcha"></div></div>
		</div>
		<?php
	}

}

/**
*
* add puzzle captcha to register form of WordPress
*/

if ( ! function_exists( "wpfc_add_puzzle_to_register_form" ) ) {
	function wpfc_add_puzzle_to_register_form() {
		if ( ! session_id() ) {
			session_start();
		}
		
		$_SESSION["wpfc_register_form"] = 'started';
		$wfpc_register_form                = get_option('wfpc_register_form');
		if ( $wfpc_register_form['header_text'] ) {
			$header_text = $wfpc_register_form['header_text'];
		} else {
			$header_text = __( "Drag To Verify", 'wfpc-plugin' );
		}
		if ( $wfpc_register_form['slider_text'] ) {
			$slider_text = $wfpc_register_form['slider_text'];
		} else {
			$slider_text = __( "Drag to solve the Puzzle", 'wfpc-plugin' );
		}
		if ( $wfpc_register_form['try_again_text'] ) {
			$try_again_text = $wfpc_register_form['try_again_text'];
		} else {
			$try_again_text = __( "Try It Again", 'wfpc-plugin' );
		}
		?>
		<div class="wpfc-slidercaptcha wpfc-card">
			<div class="wpfc-card-header">
				<span><?php echo $header_text; ?></span>
			</div>
			<div class="wpfc-card-body"><div data-heading="<?php echo $wfpc_register_form['header_text']; ?>" data-slider="<?php echo $slider_text; ?>" data-tryagain="<?php echo $try_again_text; ?>" data-form="register" class="wpfc-captcha"></div></div>
		</div>
		<?php
	}
}

/**
*
* add puzzle captcha to comment form of WordPress
*/

if ( ! function_exists( "wpfc_add_puzzle_catcha_to_comment_form" ) ) {
	function wpfc_add_puzzle_catcha_to_comment_form( $fields ) {
		if ( ! session_id() ) {
			session_start();
		}
		
		$_SESSION["wpfc_comment_form"] = 'started';
		$wpfc_comment_form             = get_option('wfpc_comment_form');
		if ( $wpfc_comment_form['header_text'] ) {
			$header_text = $wpfc_comment_form['header_text'];
		} else {
			$header_text = __( "Drag To Verify", 'wfpc-plugin' );
		}
		if ( $wpfc_comment_form['slider_text'] ) {
			$slider_text = $wpfc_comment_form['slider_text'];
		} else {
			$slider_text = __( "Drag to solve the Puzzle", 'wfpc-plugin' );
		}
		if ( $wpfc_comment_form['try_again_text'] ) {
			$try_again_text = $wpfc_comment_form['try_again_text'];
		} else {
			$try_again_text = __( "Try It Again", 'wfpc-plugin' );
		}
		if ( is_user_logged_in() ) {
			$fields['comment'] .= '<div class="wpfc-slidercaptcha wpfc-card">
			<div class="wpfc-card-header">
				<span>' . $header_text . '</span>
			</div>
			<div class="wpfc-card-body"><div data-heading="' . $wpfc_comment_form['header_text'] .'" data-slider="' . $slider_text . '" data-tryagain="' . $try_again_text .'" data-form="comment" class="wpfc-captcha"></div></div>
			</div>';
		} else {
			$fields['cookies'] .= '<div class="wpfc-slidercaptcha wpfc-card">
			<div class="wpfc-card-header">
				<span>' . $header_text . '</span>
			</div>
			<div class="wpfc-card-body"><div data-heading="' . $wpfc_comment_form['header_text'] .'" data-slider="' . $wpfc_comment_form['slider_text'] . '" data-tryagain="' . $wpfc_comment_form['try_again_text'] .'" data-form="comment" class="wpfc-captcha"></div></div>
			</div>';
		}
		return $fields;
	}
}

/**
*
* add puzzle captcha to lost password form of WordPress
*/

if( ! function_exists( "wpfc_add_puzzle_to_lost_password_form" ) ) {
	function wpfc_add_puzzle_to_lost_password_form() {
		
		if ( ! session_id() ) {
			session_start();
		}
		
		$_SESSION["wpfc_lostpassword_form"] = 'started';
		$wfpc_lost_password_form             = get_option('wfpc_lost_password_form');
		if ( $wfpc_lost_password_form['header_text'] ) {
			$header_text = $wfpc_lost_password_form['header_text'];
		} else {
			$header_text = __( "Drag To Verify", 'wfpc-plugin' );
		}
		if ( $wfpc_lost_password_form['slider_text'] ) {
			$slider_text = $wfpc_lost_password_form['slider_text'];
		} else {
			$slider_text = __( "Drag to solve the Puzzle", 'wfpc-plugin' );
		}
		if ( $wfpc_lost_password_form['try_again_text'] ) {
			$try_again_text = $wfpc_lost_password_form['try_again_text'];
		} else {
			$try_again_text = __( "Try It Again", 'wfpc-plugin' );
		}
		?>
		<div class="wpfc-slidercaptcha wpfc-card">
			<div class="wpfc-card-header">
				<span><?php echo $header_text; ?></span>
			</div>
			<div class="wpfc-card-body"><div data-heading="<?php echo $header_text; ?>" data-slider="<?php echo $slider_text; ?>" data-tryagain="<?php echo $try_again_text; ?>" data-form="lostpassword" class="wpfc-captcha"></div></div>
		</div>
		<?php
	}

}

/**
*
* verify puzzle captcha to login and register forms of WordPress
*/

if( ! function_exists( "wfpc_ajax_verify_callback" ) ) {
	
	function wfpc_ajax_verify_callback(){
		
		if( ! session_id() ){
			session_start();
		}
		
		$form = $_POST["form"];
		unset( $_SESSION["wpfc_".$form."_form"] );
		
		echo 'verified';
		die;
	}
	
	add_action( "wp_ajax_wfpc_ajax_verify", "wfpc_ajax_verify_callback" );
	add_action( "wp_ajax_nopriv_wfpc_ajax_verify", "wfpc_ajax_verify_callback" );
}

/**
*
* display error if puzzle captcha not solved for login form of WordPress
*/

add_filter( 'wp_authenticate_user', function ($user) {
	if ( ! is_wp_error( $user ) ) {
		if ( ! session_id() ) {
			session_start();
		}
		if ( isset( $_SESSION["wpfc_login_form"] ) ) {
			remove_action( 'authenticate', 'wp_authenticate_username_password', 20 );
			$user = new WP_Error( 'denied', esc_html__( "<strong>ERROR</strong>: Please solve the puzzle to login.", 'wfpc-plugin' ) );
		}
	}
	return $user;
} );

/**
*
* display error if puzzle captcha not solved for register form of WordPress
*/

add_filter( 'registration_errors', function ($errors) {
	if ( ! session_id() ) {
		session_start();
	}
	if ( isset( $_SESSION["wpfc_register_form"] ) ) {
		remove_action( 'authenticate', 'wp_authenticate_username_password', 20 );
		$errors = new WP_Error( 'denied', esc_html__("<strong>ERROR</strong>: Please solve the puzzle to register.", 'wfpc-plugin' ) );
	}
	return $errors;
} );

/**
*
* display error if puzzle captcha not solved for comment form of WordPress
*/

add_filter( 'preprocess_comment', function ( $commentdata ) {
	if ( ! session_id() ) {
		session_start();
	}
	if ( isset( $_SESSION["wpfc_comment_form"] ) ) {
		wp_die( __( '<strong>ERROR</strong>: Please solve the puzzle to comment.<p><a href="javascript:history.back()">&#171; Back</a></p>', 'wfpc-plugin' ) );
	}
	return $commentdata;
} );

/**
*
* display error if puzzle captcha not solved for lost password form of WordPress
*/

add_filter( 'lostpassword_post', function ( $validation_errors ) {
	if ( ! session_id() ) {
		session_start();
	}
	if ( isset( $_SESSION["wpfc_lostpassword_form"] ) ) {
		$validation_errors->add( 'wpfc_lostpassword_error ', '<strong>ERROR:</strong> Please solve the puzzle to continue.<strong>' );
	}
	return $validation_errors;
} );