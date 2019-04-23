<?php //Default column data 
if(!$is_ajax): ?>
	<a href="#" class="wcod_icon_container">
		<!-- <img class="wcod_expand_icon " src="<?php echo WCOD_PLUGIN_PATH."/img/expand.png" ?>"></img> -->
		<img class="wcod_expand_icon wcod_svg" src="<?php echo WCOD_PLUGIN_PATH."/img/expand.svg" ?>" data-id="<?php echo $unique_id; ?>" />
	</a>
	<?php if(!$wcst_my_account_page): ?>
	<a href="<?php echo esc_url( $order->get_view_order_url() ); ?>">
		<?php echo _x( '#', 'hash before order number', 'woocommerce' ) . $order->get_order_number(); ?>
	</a>
	<?php endif; 
endif; //is_ajax ?>

<?php if($is_ajax): ?>
<table>
<tr>
<?php endif; ?>

<td class="wcod_order_data" id="wcod_order_data_<?php echo $unique_id; ?>" colspan="5">
	<div class="wcod_order_data_container">
		<!-- Header -->
		<div class="wcod_order_data_header"><span class="wcod_strong"><?php _e( 'Status: ', 'woocommerce-order-datails' );?></span><?php echo $current_status_name; ?>
			<?php
				//WooCommerce Shipping Tracking data
				$wcst_shipping_tracking_data = $wcod_tracking_shipping_model->get_order_shipping_info($order_id);
				foreach($wcst_shipping_tracking_data as $tracking_data): ?>
				| <img class="wcod_tracking_shipping_icon" src="<?php echo WCOD_PLUGIN_PATH."/img/shipping.png" ?>" data-id="<?php echo $unique_id; ?>" /> 
				  <?php echo $tracking_data['company_name']  ?>: <a href="<?php echo $tracking_data['tracking_url'] ?>" target="_blank"><?php echo $tracking_data['tracking_code']  ?></a>
				  <?php if($tracking_data['dispatch_date']): 
					echo __( 'On: ', 'woocommerce-order-datails' ).$tracking_data['dispatch_date'];
				 endif; 
				endforeach;
			?>
		</div>
		<?php
		//Product data
		$product_total = 0;
		$product_taxes_total = 0;
		$total_products = count($order_items );
		foreach ( $order_items as $item_id => $item ) 
		{
			$product = $item->get_product();
			$css_elem_index = ($counter++) % 2 == 0 ? " wcod_last_element " : " wcod_first_element ";
			$css_last_product = $total_products+1 == $counter ? " wcod_last_product " : "";
			$product_total +=  $item['subtotal'];
			$product_taxes_total += $item['subtotal_tax'];
			echo '<div class="wcod_single_product_data '.$css_elem_index.$css_last_product.'">';
				//templates\orders\order-details.php 
				$is_visible        = $product && $product->is_visible();
				$product_permalink = apply_filters( 'woocommerce_order_item_permalink', $is_visible ? $product->get_permalink( $item ) : '', $item, $order );
				
				//img
				echo $product->get_image($wcod_option_model->get_image_preview() /* 'woocommerce_gallery_thumbnail' */, array('class' => 'wcod_single_product_image')); //https://docs.woocommerce.com/document/image-sizes-theme-developers/
				//name
					?>
				<div class="wcod_product_data_container">
					<div class="wcod_product_name_cotaniner">
					<?php 
						echo apply_filters( 'woocommerce_order_item_name', $product_permalink ? sprintf( '<a href="%s">%s</a>', $product_permalink, $item->get_name() ) : $item->get_name(), $item, $is_visible );
						//quantity
						echo apply_filters( 'woocommerce_order_item_quantity_html', ' <strong class="product-quantity">' . sprintf( '&times; %s', $item->get_quantity() ) . '</strong>', $item );
					?>
					</div>
					<div class="wcod_price_container">
						<span class="wcod_detail_row"><span class="wcod_strong"><?php echo __( 'Subtotal: ', 'woocommerce-order-datails' ); ?></span><?php echo wc_price($item['subtotal']+$item['subtotal_tax'], $wc_price_args)?></span>
						<span class="wcod_detail_row"><span class="wcod_strong"><?php _e( 'Taxes: ', 'woocommerce-order-datails' );?></span><?php echo wc_price($order->get_shipping_tax(), $wc_price_args);?> </span>
						<span class="wcod_detail_row"><span class="wcod_strong"><?php echo __( 'Total: ', 'woocommerce-order-datails' ); ?></span><?php echo wc_price($item['subtotal']+$item['subtotal_tax'], $wc_price_args)?></span>
					</div>
				</div>
				<!-- metadata -->
				<div class="wcod_meta_container">
				<?php
					do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order, false );
					wc_display_item_meta( $item );
					do_action( 'woocommerce_order_item_meta_end', $item_id, $item, $order, false );
				?>
				</div>
			</div>
		<?php
		}
		
		//Shippings  & totals
		/* $css_elem_index = ($counter++) % 2 == 0 ? " wcod_last_element " : " wcod_first_element "; */
		?>
		<div class="wcod_single_product_data <?php //echo $css_elem_index; ?>' wcod_no_padding">
			
			<!-- Shippings -->
			<div class="wcod_shipping_header">
				<?php echo __( 'Shippings', 'woocommerce-order-datails' ); ?></span>
			</div>
			<span class="wcod_detail_row"><span class="wcod_strong"><?php echo __( 'Shipping method: ', 'woocommerce-order-datails' ); ?></span><?php echo $order->get_shipping_method(); ?></span> 
			<span class="wcod_detail_row"><span class="wcod_strong"><?php _e( 'Subtotal: ', 'woocommerce-order-datails' );?></span> <?php echo wc_price($order->get_shipping_total(), $wc_price_args); ?></span>
			<span class="wcod_detail_row"><span class="wcod_strong"><?php _e( 'Taxes: ', 'woocommerce-order-datails' );?></span> <?php echo wc_price($order->get_shipping_tax(), $wc_price_args); ?></span>
			<span class="wcod_detail_row"><span class="wcod_strong"><?php _e( 'Total: ', 'woocommerce-order-datails' );?></span> <?php echo wc_price($order->get_shipping_total()+$order->get_shipping_tax(), $wc_price_args); ?></span>
			
			<!-- Products -->
			<div class="wcod_totals_header">
				<?php echo __( 'Products', 'woocommerce-order-datails' ); ?></span>
			</div>			
			<span class="wcod_detail_row"><span class="wcod_strong"><?php _e( 'Subtotal: ', 'woocommerce-order-datails' );?></span> <?php echo wc_price($product_total, $wc_price_args);?></span>
			<span class="wcod_detail_row"><span class="wcod_strong"><?php _e( 'Taxes: ', 'woocommerce-order-datails' );?></span> <?php echo wc_price($product_taxes_total, $wc_price_args); ?></span>
			<span class="wcod_detail_row"><span class="wcod_strong"><?php _e( 'Total: ', 'woocommerce-order-datails' );?></span> <?php echo wc_price($product_total+$product_taxes_total, $wc_price_args); ?></span>
			
			<!-- Fees -->
			<?php $fees =  $order->get_fees();
				if(count($fees) > 0 ): ?>
			<div class="wcod_totals_header">
				<?php echo __( 'Fees', 'woocommerce-order-datails' ); ?></span>
			</div>		
			<?php endif;
				 foreach($fees as $fee): ?>
				<span class="wcod_detail_row"><span class="wcod_strong"><?php echo $fee->get_name();?>:</span> <?php echo wc_price($fee->get_total(), $wc_price_args); ?></span>
			<?php endforeach; ?>
			
			<!-- Refunds -->
			<?php $refunds =  $order->get_refunds();
				if(count($refunds) > 0 ): ?>
			<div class="wcod_totals_header">
				<?php echo __( 'Refunds', 'woocommerce-order-datails' ); ?></span>
			</div>		
			<?php endif;
				 foreach($refunds as $refund):
				$name = $refund->get_reason() ? $refund->get_reason() : __( 'Refund', 'woocommerce-order-datails' ); ?>
				<span class="wcod_detail_row"><span class="wcod_strong"><?php echo $name;?>:</span> <?php echo wc_price($refund->get_total(), $wc_price_args); ?></span>
			<?php endforeach; ?>
			
			<!-- Totals -->
			<div class="wcod_totals_header">
				<?php echo __( 'Totals', 'woocommerce-order-datails' ); ?></span>
			</div>		
			<span class="wcod_detail_row"><span class="wcod_strong"><?php _e( 'Subtotal: ', 'woocommerce-order-datails' );?></span> <?php echo wc_price($order->get_total()-$order->get_total_tax(), $wc_price_args); ?></span>
			<span class="wcod_detail_row"><span class="wcod_strong"><?php _e( 'Taxes: ', 'woocommerce-order-datails' );?></span> <?php echo wc_price($order->get_total_tax(), $wc_price_args); ?></span>
			<?php if($order->get_total_discount(false) != 0): ?>
				<span class="wcod_detail_row"><span class="wcod_strong"><?php _e( 'Discount: ', 'woocommerce-order-datails' );?></span> <?php echo wc_price($order->get_total_discount(false), $wc_price_args); ?></span>
			<?php endif;?>
			<span class="wcod_detail_row"><span class="wcod_strong"><?php _e( 'Total: ', 'woocommerce-order-datails' );?></span> <?php echo $order->get_formatted_order_total();?> 
		</div>
		<!-- <div class="wcod_order_data_footer"></div>-->
	</div>
</td>
<?php if($is_ajax): ?>
</tr>
</table>
<?php endif; ?>