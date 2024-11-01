<?php
/**
*
* Shows setting page of login page for wp-admin.
*/
?>

<h2><?php echo esc_html__('Login Form Setting', 'wfpc-plugin'); ?></h2>
<p><?php echo esc_html__('You can Enable/Disable Puzzle captcha for admin login form below.', 'wfpc-plugin'); ?></p>
<?php 
if ( isset( $_POST["submit"] ) ){
	$iceflf          = sanitize_text_field( $_POST["is_captcha_enabled_for_login_form"] );
    $wfpc_login_form = array_map( 'sanitize_text_field', wp_unslash( $_POST['wfpc_login_form'] ) );
	update_option( "is_captcha_enabled_for_login_form", $iceflf );
    update_option( "wfpc_login_form", $wfpc_login_form );
}
$wfpc_login_form = get_option('wfpc_login_form');
?>
<form method="post">
    <table class="form-table">
        <tr valign="top">
			<th scope="row"><?php echo esc_html__( 'Is enable?', 'wfpc-plugin' ); ?></th>
			<td><label for="iceflf"><input <?php echo  get_option( 'is_captcha_enabled_for_login_form' ) ? "checked=checked" : ""; ?> id="iceflf" type="checkbox" name="is_captcha_enabled_for_login_form" value="1" /> <?php echo esc_html__( 'Select this for enable Puzzle captcha for Login form.', 'wfpc-plugin' ); ?></label></td>
        </tr>
        <tr valign="top">
			<th scope="row"><label for="wfpc_cbht"><?php echo esc_html__( 'Captcha Box Header Text', 'wfpc-plugin' ); ?></label></th>
			<td><input class="large-text" value="<?php echo  $wfpc_login_form['header_text']; ?>" id="wfpc_cbht" type="text" name="wfpc_login_form[header_text]" /></td>
        </tr>
        <tr valign="top">
			<th scope="row"><label for="wfpc_cbst"><?php echo esc_html__( 'Captcha Box Slider Text', 'wfpc-plugin' ); ?></label></th>
			<td><input class="large-text" value="<?php echo  $wfpc_login_form['slider_text']; ?>" id="wfpc_cbst" type="text" name="wfpc_login_form[slider_text]" /></td>
        </tr>
        <tr valign="top">
			<th scope="row"><label for="wfpc_cbtat"><?php echo esc_html__( 'Captcha Box Try Again Text', 'wfpc-plugin' ); ?></label></th>
			<td><input class="large-text" value="<?php echo  $wfpc_login_form['try_again_text']; ?>" id="wfpc_cbtat" type="text" name="wfpc_login_form[try_again_text]" /></td>
        </tr>
    </table>
    <?php submit_button(); ?>
</form>
