<?php
/**
*
* Shows setting page of login page for wp-admin.
*/
?>

<h2><?php echo esc_html__('Register Form Setting', 'wfpc-plugin'); ?></h2>
<?php 
if( isset( $_POST["submit"] ) ){
	$icefrf          = sanitize_text_field( $_POST["is_captcha_enabled_for_register_form"] );
    $wfpc_register_form = array_map( 'sanitize_text_field', wp_unslash( $_POST['wfpc_register_form'] ) );
	update_option( "is_captcha_enabled_for_register_form", $icefrf );
    update_option( "wfpc_register_form", $wfpc_register_form );
}
$wfpc_register_form = get_option( 'wfpc_register_form' );
$users_can_register = get_option("users_can_register");
?>
<?php if ( $users_can_register ) { ?>
<p><?php echo esc_html__( 'You can Enable/Disable Puzzle captcha for admin Register form below.', 'wfpc-plugin' ); ?></p>
<form method="post">
    <table class="form-table">
        <tr valign="top">
			<th scope="row"><?php echo esc_html__( 'Is enable?', 'wfpc-plugin' ); ?></th>
			<td><label for="icefrf"><input <?php echo get_option( 'is_captcha_enabled_for_register_form' ) ? "checked=checked" : ''; ?> id="icefrf" type="checkbox" name="is_captcha_enabled_for_register_form" value="1" /> <?php echo esc_html__( 'Select this for enable Puzzle captcha for Register form.', 'wfpc-plugin' ); ?></label></td>
        </tr>
        <tr valign="top">
			<th scope="row"><label for="wfpc_cbht"><?php echo esc_html__( 'Captcha Box Header Text', 'wfpc-plugin' ); ?></label></th>
			<td><input class="large-text" value="<?php echo  $wfpc_register_form['header_text']; ?>" id="wfpc_cbht" type="text" name="wfpc_register_form[header_text]" /></td>
        </tr>
        <tr valign="top">
			<th scope="row"><label for="wfpc_cbst"><?php echo esc_html__( 'Captcha Box Slider Text', 'wfpc-plugin' ); ?></label></th>
			<td><input class="large-text" value="<?php echo  $wfpc_register_form['slider_text']; ?>" id="wfpc_cbst" type="text" name="wfpc_register_form[slider_text]" /></td>
        </tr>
        <tr valign="top">
			<th scope="row"><label for="wfpc_cbtat"><?php echo esc_html__( 'Captcha Box Try Again Text', 'wfpc-plugin' ); ?></label></th>
			<td><input class="large-text" value="<?php echo  $wfpc_register_form['try_again_text']; ?>" id="wfpc_cbtat" type="text" name="wfpc_register_form[try_again_text]" /></td>
        </tr>
    </table>
    <?php submit_button(); ?>
</form>
<?php } else { ?>
<p><?php echo esc_html__( 'You must enable the register option from setting.', 'wfpc-plugin' ); ?></p>
<p><?php echo esc_html__( 'To enable register setting, please', 'wfpc-plugin' ); ?> <a href="options-general.php#users_can_register"><?php echo esc_html__( 'Click here', 'wfpc-plugin' ); ?></a></p>
<?php } ?>
