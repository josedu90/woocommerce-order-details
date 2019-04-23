<?php 
class WCOD_OrdersPage
{
	function __construct()
	{
		add_action('woocommerce_my_account_my_orders_column_order-number', array(&$this, 'on_order_id_column_rendering'), 99);
	}
	function on_order_id_column_rendering($order)
	{
		global $wcod_html_model;
		
		$wcod_html_model->render_order_table($order);
	}
}
?>