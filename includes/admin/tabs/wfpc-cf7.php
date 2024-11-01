<?php
/**
*
* Shows setting page of Contact form 7 for wp-admin.
*/
?>
<h2><?php echo esc_html__('Contact form 7 Texts Setting', 'wfpc-plugin'); ?></h2>
<?php 
if( isset( $_POST["submit"] ) ){
    $wfpc_cf7_form = array_map( 'sanitize_text_field', wp_unslash( $_POST['wfpc_cf7_form'] ) );
    update_option( "wfpc_cf7_form", $wfpc_cf7_form );
}
$wfpc_cf7_form = get_option( 'wfpc_cf7_form' );
?>
<form method="post">
    <table class="form-table">
        <tr valign="top">
			<th scope="row"><label for="wfpc_cbht"><?php echo esc_html__( 'Captcha Box Header Text', 'wfpc-plugin' ); ?></label></th>
			<td><input class="large-text" value="<?php echo  $wfpc_cf7_form['header_text']; ?>" id="wfpc_cbht" type="text" name="wfpc_cf7_form[header_text]" /></td>
        </tr>
        <tr valign="top">
			<th scope="row"><label for="wfpc_cbst"><?php echo esc_html__( 'Captcha Box Slider Text', 'wfpc-plugin' ); ?></label></th>
			<td><input class="large-text" value="<?php echo  $wfpc_cf7_form['slider_text']; ?>" id="wfpc_cbst" type="text" name="wfpc_cf7_form[slider_text]" /></td>
        </tr>
        <tr valign="top">
			<th scope="row"><label for="wfpc_cbtat"><?php echo esc_html__( 'Captcha Box Try Again Text', 'wfpc-plugin' ); ?></label></th>
			<td><input class="large-text" value="<?php echo  $wfpc_cf7_form['try_again_text']; ?>" id="wfpc_cbtat" type="text" name="wfpc_cf7_form[try_again_text]" /></td>
        </tr>
    </table>
    <?php submit_button(); ?>
</form>

<h2><?php echo esc_html__('Contact form 7 Setting', 'wfpc-plugin'); ?></h2>
<?php if (function_exists('wpcf7_add_form_tag')) { ?>
	<p><?php echo esc_html__('You can Add Puzzle captcha to Contact form 7 from it\'s form builder screen.', 'wfpc-plugin'); ?></p>
	<p><?php echo esc_html__('We have created a custom tag for adding puzzle captcha so you can select it and add it to Contact form 7\'s form same as other tags you entered.', 'wfpc-plugin'); ?></p>
	<p><?php echo esc_html__('We have created a custom tag for adding puzzle captcha so you can select it and add it to Contact form 7\'s form same as other tags you entered.', 'wfpc-plugin'); ?></p>
	<p><?php echo esc_html__('You can add puzzle captcha field in Contact form 7 as shown in image below:', 'wfpc-plugin'); ?></p>
	<p><img src="<?php echo WFPC_URL; ?>/assets/screen-shots/add-puzzle-captcha-to-cf7-1.png" /></p>
	<p><img src="<?php echo WFPC_URL; ?>/assets/screen-shots/add-puzzle-captcha-to-cf7-2.png" /></p>
	<p><?php echo esc_html__('Then click on Insert Tag to add that tag to Contact form.', 'wfpc-plugin'); ?></p>
<?php } else{  ?>
<p><?php echo esc_html__('It seems you do not have installed/activated Contact form 7 plugin.', 'wfpc-plugin'); ?></p>
<?php } ?>