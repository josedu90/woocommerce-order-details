<?php 
class WCOD_Html
{
	function __construct()
	{
		add_action('wp_ajax_wcod_load_order_details', array($this, 'ajax_render_order_table'));
		add_action('wp_ajax_nopriv_wcod_load_order_details', array($this, 'ajax_render_order_table'));
	}
	
	function ajax_render_order_table()
	{
		$id = wcod_get_value_if_set($_POST, 'id', null);
		if(!isset($id))
			_e('Please insert a valid order id!', 'woocommerce-order-datails');
		else
		{
			$order = wc_get_order($id);
			if(!is_a($order, 'WC_Order'))
				_e('Please insert a valid order id!', 'woocommerce-order-datails');
			else
				$this->render_order_table($order, true);
		}
		wp_die();
	}
	function render_order_table($order, $is_ajax = false)
	{
		global $wcod_tracking_shipping_model, $wcst_my_account_page, $wcod_option_model;
		
		wp_enqueue_style("wcod-frontend-orders-page", WCOD_PLUGIN_PATH."/css/frontend/orders-page.css");
		wp_enqueue_script("wcod-frontend-orders-page", WCOD_PLUGIN_PATH."/js/frontend/orders-page.js", array('jquery'));
		wp_enqueue_script("wcod-frontend-svg", WCOD_PLUGIN_PATH."/js/vendor/svg/jquery.svgInject.js", array('jquery'));
		
		$order_id = $order->get_id();
		$order_items  = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
		$counter = 1;
		$unique_id = md5($order->get_id());
		$order_statuses = wc_get_order_statuses();
		$current_status_name = wcod_get_value_if_set( $order_statuses, "wc-".$order->get_status(), $order->get_status());
		$wc_price_args = array('currency' => $order->get_currency());
		/* wc_get_template("templates/frontend/orders-table.php",
			array(
				'order' => $order,
				'order_id' => $order_id,
				'order_items' => $order_items,
				'counter' => $counter
			),
			WCOD_PLUGIN_ABS_PATH."/"
		); */
		include WCOD_PLUGIN_ABS_PATH.'/templates/frontend/orders-table.php';
	}
}
?>