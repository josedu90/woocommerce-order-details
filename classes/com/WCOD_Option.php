<?php 
class WCOD_Option
{
	//rplc: wcod, WCOD
	public function __construct()
	{
		
	}
	public function save_options($data)
	{
		update_option('wcod_options', $data);
	}
	public function api_key_has_been_entered()
	{
		$api_key = $this->get_options('api_key');
		if(!isset($api_key) || empty($api_key))
			return false;
		
		return true;
	}
	public function get_options($option_name = null, $default_value = null)
	{
		$result = null;
		
		$options = get_option('wcod_options');
		if($option_name != null)
		{
			$result = wcod_get_value_if_set($options, $option_name ,$default_value);
		}
		else 
			$result = $options;
		
		return $result;
	}
	public function get_image_preview()
	{
		$options = $this->get_options();
		
		$width = wcod_get_value_if_set($options, 'product_preview_width', "");
		$height = wcod_get_value_if_set($options, 'product_preview_height', "");
		
		if($width == "" && $height== "")
			return 'woocommerce_gallery_thumbnail';
		
		return array($width,$height);
	}
}
?>