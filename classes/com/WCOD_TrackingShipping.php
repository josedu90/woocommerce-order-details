<?php 
class WCOD_TrackingShipping
{
	function __construct()
	{
		
	}
	function get_order_shipping_info($order_id)
	{
		global $wcod_time_model;
		$order = wc_get_order($order_id);
		$result = array();
		if(!$order)
			return $result;
		
		//Main tracking num 
		$data = $order->get_meta('_wcst_order_trackno');
		if($data)
		{
			$tracking_url = $order->get_meta('_wcst_order_track_http_url');
			$dispatch_date = $order->get_meta('_wcst_order_dispatch_date') ? $wcod_time_model->convert_date_according_current_setting($order->get_meta('_wcst_order_dispatch_date')) : ""; 
				
			$result[] = array(
				'tracking_code' => $data,
				'company_name' => $order->get_meta('_wcst_order_trackname'),
				'tracking_url' => $tracking_url ? $tracking_url : "#",
				'dispatch_date' => $dispatch_date 
			);
		}
		//Additional companies
		$data = $order->get_meta('_wcst_additional_companies');
		if($data)
		{
			foreach($data as $additional_shipping)
			{
				$dispatch_date = $additional_shipping['_wcst_order_dispatch_date'] ? $wcod_time_model->convert_date_according_current_setting($additional_shipping['_wcst_order_dispatch_date']) : ""; 
				$result[] = array(
					'tracking_code' => $additional_shipping['_wcst_order_trackno'],
					'company_name' => $additional_shipping['_wcst_order_trackname'],
					'tracking_url' => $additional_shipping['_wcst_order_track_http_url'] ? $additional_shipping['_wcst_order_track_http_url'] : "#",
					'dispatch_date' => $additional_shipping['_wcst_order_dispatch_date']
				);
			}
		}
		
		return $result;
	}
}
?>