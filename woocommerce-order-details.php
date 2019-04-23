<?php 
/*
Plugin Name: WooCommerce Order Details
Description: Enhances the My Acounts -> Orders page.
Author: Lagudi Domenico
Version: 1.8
*/


/* Const */
//Domain: woocommerce-order-datails
define('WCOD_PLUGIN_PATH', rtrim(plugin_dir_url(__FILE__), "/") ) ;
define('WCOD_PLUGIN_ABS_PATH', dirname( __FILE__ ) ); ///ex.: "woocommerce/wp-content/plugins/woocommerce-order-datails"
define('WCOD_PLUGIN_LANG_PATH', basename( dirname( __FILE__ ) ) . '/languages' ) ;


if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ||
     (is_multisite() && array_key_exists( 'woocommerce/woocommerce.php', get_site_option('active_sitewide_plugins') ))	
	)
{
	$wcod_id = 22720424;
	$wcod_name = "WooCommerce Order Details";
	$wcod_activator_slug = "wcod-activator";
	
	include_once("classes/com/WCOD_Globals.php"); 
	require_once("classes/admin/WCOD_ActivationPage.php");
	
	add_action('init', 'wcod_global_init');
	add_action('admin_menu', 'wcod_init_act');
	if(defined('DOING_AJAX') && DOING_AJAX)
		wcod_init_act();
	//add_action('admin_menu', 'wcod_init_act');
	add_action('admin_notices', 'wcod_admin_notices' );

}
function wcod_admin_notices()
{
	global $wcod_notice, $wcod_name, $wcod_activator_slug;
	if($wcod_notice && (!isset($_GET['page']) || $_GET['page'] != $wcod_activator_slug))
	{
		 ?>
		<div class="notice notice-success">
			<p><?php echo sprintf(__( 'To complete the <span style="color:#96588a; font-weight:bold;">%s</span> plugin activation, you must verify your purchase license. Click <a href="%s">here</a> to verify it.', 'woocommerce-order-datails' ), $wcod_name, get_admin_url()."admin.php?page=".$wcod_activator_slug); ?></p>
		</div>
		<?php
	}
}
function wcod_setup()
{
	global $wcod_tracking_shipping_model, $wcod_time_model, $wcod_html_model, $wcod_option_model;
	
	//com	
	if(!class_exists('WCOD_TrackingShipping'))
	{
		require_once('classes/com/WCOD_TrackingShipping.php');
		$wcod_tracking_shipping_model = new WCOD_TrackingShipping();
	} 
	if(!class_exists('WCOD_Time'))
	{
		require_once('classes/com/WCOD_Time.php');
		$wcod_time_model = new WCOD_Time();
	} 
	if(!class_exists('WCOD_Html'))
	{
		require_once('classes/com/WCOD_Html.php');
		$wcod_html_model = new WCOD_Html();
	} 
	if(!class_exists('WCOD_Option'))
	{
		require_once('classes/com/WCOD_Option.php');
		$wcod_option_model = new WCOD_Option();
	} 
	if(!class_exists('WCOD_Shortcode'))
	{
		require_once('classes/com/WCOD_Shortcode.php');
		new WCOD_Shortcode();
	} 
	
	//admin
	if(!class_exists('WCOD_OptionsPage'))
		require_once('classes/admin/WCOD_OptionsPage.php');
		
	//frontend
	if(!class_exists('WCOD_OrdersPage'))
	{
		require_once('classes/frontend/WCOD_OrdersPage.php');
		new WCOD_OrdersPage();
	} 
	
	//actions 
	//add_action('admin_init', 'wcod_admin_init');
	add_action('admin_menu', 'wcod_init_admin_panel');
}
function wcod_global_init()
{
	// Languages 
	load_plugin_textdomain('woocommerce-order-datails', false, basename( dirname( __FILE__ ) ) . '/languages' );
	/* if(is_admin())
		wcod_init_act();  */
}
function wcod_init_act()
{
	global $wcod_activator_slug, $wcod_name, $wcod_id;
	new WCOD_ActivationPage($wcod_activator_slug, $wcod_name, 'woocommerce-order-datails', $wcod_id, WCOD_PLUGIN_PATH);
}
function wcod_admin_init()
{
	//$remove = remove_submenu_page( 'woocommerce-role-by-amount-spent', 'woocommerce-order-datails');
}	
function wcod_init_admin_panel()
{ 
	$place = wcod_get_free_menu_position(60 , .1);
	$cap = 'manage_woocommerce';

	//add_menu_page( 'WooCommerce Order Details', __('WooCommerce Order Details', 'woocommerce-order-datails'), $cap, 'woocommerce-order-datails', null,  'dashicons-cart' , (string)$place);
	add_submenu_page( 'woocommerce', __('WooCommerce Order Details - Settings', 'woocommerce-order-datails'),  __('WooCommerce Order Details', 'woocommerce-order-datails'), $cap, 'woocommerce-order-datails-options', 'wcod_render_options_page' );
}
function wcod_render_options_page()
{
	if(!isset($_REQUEST['page']))
		return;
	switch($_REQUEST['page'])
	{
		case 'woocommerce-order-datails-options':
		$page = new WCOD_OptionsPage();
		$page->render_page();
		break;
		
	}
}
function wcod_get_free_menu_position($start, $increment = 0.1)
{
	foreach ($GLOBALS['menu'] as $key => $menu) {
		$menus_positions[] = $key;
	}
	
	if (!in_array($start, $menus_positions)) return $start;

	/* the position is already reserved find the closet one */
	while (in_array($start, $menus_positions)) 
	{
		$start += $increment;
	}
	return (string)$start;
}

function wcod_var_dump($var)
{
	echo "<pre>";
	var_dump($var);
	echo "</pre>";
}
?>