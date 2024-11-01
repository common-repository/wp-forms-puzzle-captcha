<?php
/**
 * Fired when the plugin is uninstalled.
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

/**
 * If it's a multisite, loop over all the blogs where the plugin is activated and delete the options from the DB.
 */
if ( is_multisite() ) {
	global $wpdb;
	$c4wp_blogs = $wpdb->get_results( "SELECT blog_id FROM {$wpdb->blogs}", ARRAY_A );

	if ( ! empty( $c4wp_blogs ) ) {
		foreach ( $c4wp_blogs as $c4wp_blog ) {
			switch_to_blog( $c4wp_blog['blog_id'] );
			delete_option( 'WFPC_check_welcome' );
			delete_option( 'wfpc_login_form' );
			delete_option( 'wfpc_register_form' );
			delete_option( 'wfpc_comment_form' );
			delete_option( 'wfpc_lost_password_form' );
			delete_option( 'wfpc_cf7_form' );
			delete_option( 'is_captcha_enabled_for_comment_form' );
			delete_option( 'is_captcha_enabled_for_login_form' );
			delete_option( 'is_captcha_enabled_for_lostpassword_form' );
			delete_option( 'is_captcha_enabled_for_register_form' );
		}
	}
} else {
	delete_option( 'WFPC_check_welcome' );
	delete_option( 'wfpc_login_form' );
	delete_option( 'wfpc_register_form' );
	delete_option( 'wfpc_comment_form' );
	delete_option( 'wfpc_lost_password_form' );
	delete_option( 'wfpc_cf7_form' );
	delete_option( 'is_captcha_enabled_for_comment_form' );
	delete_option( 'is_captcha_enabled_for_login_form' );
	delete_option( 'is_captcha_enabled_for_lostpassword_form' );
	delete_option( 'is_captcha_enabled_for_register_form' );
}
