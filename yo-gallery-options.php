<?php
/*  
 * YO Gallery
 * Version:           1.0.0 - 32132
 * Author:            Yo Gallery Team (YGT)
 * Date:              05/05/2018
 */

if( !defined('WPINC') || !defined("ABSPATH") ){
	die();
}

if ( isset( $_POST['submit'] ) ) {
	  '';
	check_admin_referer( 'yo-gallery-options' );
	$this->options['enable_everywhere'] = ( $_POST['enable_everywhere'] == '1' );
	$this->save_options();
}
?>
<style> .indent {padding-left: 2em} </style>
<div class="wrap">
	<h1><?php _e( 'Yo Gallery', 'yo-gallery'); ?></h1>
	<p>
		<? _e('Here you can configure your photo gallery  tools. Section with all configuration settings of this tool.'); ?>
	</p>
	<form action="" method="post" id="photo-gallery">
		<ul>
			<li>
				<label for="yo_gallery_on">
					<input type="radio" id="yo_gallery_on" name="enable_everywhere" value="0" <?php checked( !$this->options['enable_everywhere'] );?> /> 
					<strong>
						<?php _e( 'Disable'); ?>
					</strong>
				</label>			
			</li>
			<li>
				<label for="yo_gallery_off">
					<input type="radio" id="yo_gallery_off" name="enable_everywhere" value="1" <?php checked( $this->options['enable_everywhere'] );?> /> 
					<strong>
						<?php _e( 'Enable'); ?>
					</strong>
				</label>
			</li>
		</ul>
		<?php wp_nonce_field( 'yo-gallery-options' ); ?>
		<p class="submit">
			<input class="button-primary" type="submit" name="submit" value="<?php _e( 'Save Changes') ?>">
		</p>
	</form>
</div>
