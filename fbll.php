<?php
/*
Plugin Name: Facebook Like-or-Lock
Plugin URI: http://reizn.com/Facebook-like-or-lock
Description: Hide contents with Facebook like.
Version: 0.13
Author: Ijat
Author URI: http://reizn.com
License: GPL2

Copyright 2013 - Ijat  (email : Ijat@reizn.com)
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/



if ( is_admin() ){
	add_action( 'admin_menu', '_fbll_menu' );
}



function _fbll_menu() {
	add_options_page( 'Facebook Like-or-Lock', 'Facebook Like-or-Lock', 'manage_options', '_fbll', '_fbll_menu_options' );
	add_action( 'admin_init', '_fbl_settings' );
}



function _fbll_menu_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	} ?>

	<form method="post" action="options.php">
		<?php settings_fields( 'fbll-group' ); ?>
	    <table class="form-table">
	        <tr valign="top">
	        <th scope="row">Enabled<br/>This plugin will detect the [FBLL] shortcode in contents before load the like button to lowers the page load and size.</th>
	        <td><input type="checkbox" name="start" value="1" <?php checked( '1', get_option( 'start' ) );?> /></td>
	        </tr>
	         
	        <tr valign="top">
	        <th scope="row">App ID</br/>Create a new Facebook app, this is used to detect whether the user liked the page or not. Ensure that URL in the app is same with this site.</th>
	        <td><input type="text" name="appid" value="<?php echo get_option('appid'); ?>" /></td>
	        </tr>

			<tr valign="top">
	        <th scope="row">Page URL</br/>Any Facebook page to like</th>
	        <td><input type="text" name="url" value="<?php echo get_option('url'); ?>" /></td>
	        </tr>

	        <tr valign="top">
	        <th scope="row">Page ID</br/>Get it at <a>http://graph.facebook.com/page_name</a>. Make sure it is same ID with the page URL.</th>
	        <td><input type="text" name="pageid" value="<?php echo get_option('pageid'); ?>" /></td>
	        </tr>

	        <tr valign="top">
	        <th scope="row">Like this plugin? I'll be grateful if you would like to send a few bucks for a cup of tea. :)</th>
	        <td>
	        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">

<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">

<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form></td></tr>

	        <tr valign="top">
	        <th scope="row">Saved Data:</th>
	        <td>
	    <?php 

	    echo get_option( 'start' ) . ' | ' ;
	    echo get_option( 'appid' ). ' | ' ;
	    echo get_option( 'url' ). ' | ' ;
	    echo get_option( 'pageid' );
	    ?>
	   </td></tr>
	    </table>
	     <?php submit_button('Save','Primary'); ?>
	</form>

<?php }



function _fbl_settings() {
	register_setting( 'fbll-group', 'start' );
	register_setting( 'fbll-group', 'pageid' );
	register_setting( 'fbll-group', 'url' );
	register_setting( 'fbll-group', 'appid' );
}



if (get_option( 'start' )==1) {
	add_action('wp_head', 'buffer_start');
	add_action('wp_footer', 'buffer_end');
	add_filter('uds_shortcode_out_filter', 'uds_clear_autop');
	add_shortcode( 'FBLL', 'fbll_shortcode' );
}


function fbll_shortcode($atts, $content) {
	return '<div id="fbx"><div id="fbx-title"></div><div id="fbCon-Btn"><a href="javascript:FBConnect();" class="myButton">Connect to Facebook</a></div><div id="fb-btn" class="fb-like" data-href="'.get_option( 'url' ).'" data-send="false" data-width="400" data-show-faces="false" data-font="segoe ui"></div></div><span id="flo"><p>' . do_shortcode(uds_clear_autop($content)) . '</p></span>';
}



function uds_clear_autop($content) {
    $content = str_ireplace('<br />', '', $content);
    return $content;
}

function buffer_start() { ob_start("callback"); }
function buffer_end() { ob_end_flush(); }

function callback($buffer) {
	$pos = strpos($buffer, '<div id="fbx">');
	if ($pos === false) {
	    return $buffer;
	} else {
		$scriptvar = '<div id="fb-root"></div><script>var theappid=\''. get_option( 'appid' ) . '\'; var thepageid=\''. get_option( 'pageid' ) .'\'; var thechannelurl=\''.plugins_url().'/Facebook-Like-or-Lock/channel.html\';</script>';
		$script = $scriptvar . '<script src="'.plugins_url().'/Facebook-Like-or-Lock/fbll.js" type="text/javascript"></script>';

		$css = '<link rel="stylesheet" href="' . plugins_url() . '/Facebook-Like-or-Lock/fbll_style.css" type="text/css" media="screen" />';
	return $css . $script . $buffer;
	}
}