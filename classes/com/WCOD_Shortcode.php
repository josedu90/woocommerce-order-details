<?php 
class WCOD_Shortcode
{
	public function __construct()
	{
		add_shortcode( 'wcod_order_details', array(&$this, 'render_order_details' ));
	}
	public function render_order_details($atts)
	{
		/* $parameters = shortcode_atts( array(
        'id' => null,
			), $atts );
			
		if(!isset($parameters['id']))
			return ""; */
		$my_unique_id = rand(1111, 999999);
		wp_register_script("wcod-shortcode-load-order", WCOD_PLUGIN_PATH."/js/frontend/shortcode-load-order.js", array('jquery'));
		wp_localize_script( 'wcod-shortcode-load-order', 'wcod_data', array(
																'no_valid_order_id_msg' => __( 'Please insert a valid order id!', 'woocommerce-order-datails' ),	
																'loading_msg' => __( 'Loading, please wait...', 'woocommerce-order-datails' ),	
																'ajaxurl' => admin_url( 'admin-ajax.php' )
																) );
		wp_enqueue_script( 'wcod-shortcode-load-order' );
		wp_enqueue_style("wcod-shortcode-load-order", WCOD_PLUGIN_PATH."/css/frontend/shortcode-load-order.css");
		
		//needed to make table work
		wp_enqueue_script("wcod-frontend-orders-page", WCOD_PLUGIN_PATH."/js/frontend/orders-page.js", array('jquery'));
		wp_enqueue_script("wcod-frontend-svg", WCOD_PLUGIN_PATH."/js/vendor/svg/jquery.svgInject.js", array('jquery'));
		wp_enqueue_style("wcod-frontend-orders-page", WCOD_PLUGIN_PATH."/css/frontend/orders-page.css");
		ob_start();
		?>
		<div class="wcod_loader_controllers_conainer" id="wcod_loader_controllers_conainer_<?php echo $my_unique_id; ?>">
			<input type="text" value="" class="wcod_load_order_details_input" id="wcod_order_id_<?php echo $my_unique_id; ?>"></input>
			<button class="button wcod_load_order_details_button" data-id="<?php echo $my_unique_id; ?>"><?php _e('View', 'woocommerce-order-datails') ?></button>
		</div>
		<div class="wcod_order_details_conainer" id="wcod_order_details_conainer_<?php echo $my_unique_id; ?>">
		</div>
		<?php

		return ob_get_clean();		
	}
}
?>