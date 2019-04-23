jQuery(document).ready(function()
{
	jQuery(document).on('click', '.wcod_load_order_details_button', wcod_load_order_details);
});
function wcod_load_order_details(event)
{
	event.preventDefault();
	const id = jQuery(event.currentTarget).data('id');
	const value = jQuery("#wcod_order_id_"+id).val();
	const target = "#wcod_order_details_conainer_"+id;
	
	if(value == "")
	{
		jQuery("#wcod_order_id_"+id).html(wcod_data.no_valid_order_id_msg); 
		return false;
	}
	
	//UI
	jQuery(target).html(wcod_data.loading_msg);
	
	var formData = new FormData();
	formData.append('action', 'wcod_load_order_details');	
	formData.append('id', value); 			
	jQuery.ajax({
			url: wcod_data.ajaxurl,
			type: 'POST',
			data: formData,
			async: true,
			success: function (data) 
			{
				//UI
				jQuery(target).html(data);
			},
			error: function (data) 
			{
				//console.log(data);
				//alert("Error: "+data);
			},
			cache: false,
			contentType: false,
			processData: false
		}); 	
	
	return false;
}