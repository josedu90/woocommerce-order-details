<?php 
class WCOD_OptionsPage
{
	function __construct()
	{
		
	}
	function render_page()
	{
		
		global $wcod_option_model;
		
		//Assets
		wp_enqueue_style( 'wcod-common-page', WCOD_PLUGIN_PATH.'/css/admin/admin-common.css');
		wp_enqueue_style( 'wcod-options-page', WCOD_PLUGIN_PATH.'/css/admin/admin-options-page.css');
		
		//Save
		$api_key_is_not_valid = false;
		if(isset($_POST['wcod_options']))
		{
			$wcod_option_model->save_options($_POST['wcod_options']);
		}
		
		//Load
		$options = $wcod_option_model->get_options();
		
		?>
		<div class="wrap white-box">
			<!-- <form action="options.php" method="post" > -->
				<form action="" method="post" >
				<?php //settings_fields('wcod_options_group'); ?> 
					<h2 class="wcod_section_title wcod_no_margin_top"><?php _e('Display', 'woocommerce-order-datails');?></h3>
						
					<h3><?php _e('Product image preview', 'woocommerce-order-datails');?></h3>
					<p><?php echo sprintf(__("Leave both empty for default size ( default value is the <i>woocommerce_thumbnail</i> size, you can read more <a href='%s' target='_blank'>here</a> ). The <a href='%s' target='_blank'> get_image()</a> method will try (if possible) to resize the image according to its native ratio. It works better with square sizes (Example: 16x16, 24x24, 32x32, 64x64).", 'woocommerce-order-datails'), 'https://docs.woocommerce.com/document/image-sizes-theme-developers/', 'https://docs.woocommerce.com/wc-apidocs/source-class-WC_Product.html#1793-1812');?></p>
					<div class="wcod_checkbox_container">
						<p class="wcod_general_option_description"><?php _e('Width', 'woocommerce-order-datails');?></p>
						<input type="number" min="0" step="1" name="wcod_options[product_preview_width]" value="<?php echo wcod_get_value_if_set($options, 'product_preview_width', ""); ?>"></input>
					</div>
					
					<div class="wcod_checkbox_container">
						<p class="wcod_general_option_description"><?php _e('Height', 'woocommerce-order-datails');?></p>
						<input type="number" min="0" step="1" name="wcod_options[product_preview_height]" value="<?php echo wcod_get_value_if_set($options, 'product_preview_height', ""); ?>"></input>
					</div>
					
					
					
				<p class="submit">
					<input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes', 'woocommerce-order-datails'); ?>" />
				</p>
			</form>			
		</div>
		<?php 
	}
}
?>