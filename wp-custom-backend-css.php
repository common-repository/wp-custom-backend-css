<?php
/*
Plugin Name: Wordpress Custom Css
Plugin URI: https://wordpress.org/plugins/wp-custom-backend-css/
Description: With this plugin you can add custom style to your wordpress backend. This first release will have the basic (cool!) editor. We'll add themes and utils soon!
Author: xpol555
Version: 1.0
Author URI: https://profiles.wordpress.org/xpol555/
*/



#DEFINITIONS

define('P_NAME', 'WP Custom Backend Css');

define('P_CAPABILITY_LEVEL_PERMITTED','manage_options');

define('P_SLUG', 'wp-css-custom');

#ADD THE CSS

function equeue_style_for_admin() {

	$style=esc_attr( get_option('opt_cbcss_css') );

    echo '<style type="text/css">'.$style.'</style>';

    $script = plugins_url( '/assets/js/codemirror.js',__FILE__);

	echo '<script type="text/javascript" src="'.$script.'"></script>';

	$script_css = plugins_url( '/assets/js/css.js',__FILE__);

	echo '<script type="text/javascript" src="'.$script_css.'"></script>';

	$syntax = plugins_url('/assets/css/syntax.css',__FILE__);

	echo '<link rel="stylesheet" href="'.$syntax.'">';



}

add_action('admin_head', 'equeue_style_for_admin');



#ADD PAGE SETTINGS







function cbcss() {



	//create new top-level menu

	add_options_page( P_NAME, P_NAME, P_CAPABILITY_LEVEL_PERMITTED, P_SLUG, 'custom_backend_css' );

	add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function );

	//add_menu_page(P_NAME, P_NAME, 'administrator', __FILE__, 'custom_backend_css',plugins_url('/assets/img/icon.png', __FILE__));



	//call register settings function

	add_action( 'admin_init', 'register_mysettings' );

}

add_action('admin_menu', 'cbcss');

function register_mysettings() {

	//register our settings

	register_setting( 'settings', 'opt_cbcss_css' );

}



function custom_backend_css() {

?>

<div class="wrap cbcss">

		<div class="head_top">

		<?php 

		echo '<img class="cbcss_logo" src="'.plugins_url('/assets/img/icon-big.png', __FILE__).'" />'

		?>

	<h2 class="cbcss_plugin_name"><?php echo P_NAME; ?></h2>

	<div class="extra">

		<div class="btn utils">

			<span class="dashicons-before dashicons-admin-tools">Utilities</span>

		</div>

		<div class="btn themes">

			<span class="dashicons-before dashicons-admin-appearance">Backend Themes</span>

		</div>

	</div>

</div>

<form method="post" action="options.php" class="cbcss_editor">

    <?php 

    settings_fields( 'settings' ); ?>

    <div style="transition:0.5s ease-in-out" class="loader">Loading css</div>



    <textarea style="display:none;" name="opt_cbcss_css" id="opt_cbcss_css" style="margin: 0px;width: 100%;max-width: 100%;height: 400px;"><?php echo esc_attr( get_option('opt_cbcss_css') ); ?></textarea>

    

    <?php submit_button(); ?>



</form>





<script type="text/javascript">

jQuery(document).ready(function($){

	

      var editor = CodeMirror.fromTextArea(document.getElementById("opt_cbcss_css"), {

        extraKeys: {"Ctrl-Space": "autocomplete"},

      });

    $('.loader').delay(2000).text('done!').addClass('done').delay(1000).slideUp(1000);

    $('btn').click(function(){

    	alert('This function will be available soon!');

    });

});

</script>

<?php }

?>