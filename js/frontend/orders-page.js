jQuery(document).ready(function()
{
	wcod_setup_rows();
	wcod_setup_svg();

	jQuery(document).on('click', '.wcod_expand_icon', wcod_on_expand);
});
function wcod_setup_rows()
{
	jQuery(".wcod_order_data").each(function(index,elem)
	{
		let parent_row = jQuery(elem).closest('tr');
		//console.log(elem);
		let elem_to_move = jQuery(elem).remove();
		let elem_to_string = elem_to_move.prop('outerHTML');
		
		//elem_to_string = elem_to_string.replace(new RegExp(search, 'g'), replacement);
		let new_elem = jQuery("<tr class='wcod_row_order_details'>").append(elem_to_string);
		//jQuery(parent_row).after("<tr class='wcod_row_order_details'>"+elem_to_string+"</tr>");
		jQuery(parent_row).after(new_elem);
	});
}
function wcod_setup_svg()
{
	//Arrow icon are moved as first element of the row. This is forced due to WCST could inject its order <a> element
	jQuery('.wcod_icon_container').each(function(index, elem) 
	{
		let parent = jQuery(elem).closest('td');
		parent.prepend(jQuery(elem));
	});
	jQuery('.wcod_svg').svgInject();
	
	setTimeout(function()
	{
		let color = jQuery("a").css('color') != 'rgb(255, 255, 255)'  ? jQuery("a").css('color') : jQuery(".woocommerce-button").css('color');
		color = color != 'rgb(255, 255, 255)'  ? color : "#333";
		//jQuery('svg.wcod_svg').css({'fill':jQuery("a").css('color')});
		jQuery('svg.wcod_svg').css({'fill':color});
		jQuery('.wcod_svg').fadeIn();
	}, 500);
}
function wcod_on_expand(event)
{
	event.preventDefault();
	let current_elem = jQuery(event.currentTarget);
	let id = current_elem.data('id');
	if(current_elem.hasClass('wcod_collapse_icon')) //collapse
	{
		current_elem.removeClass('wcod_collapse_icon');
		jQuery(event.currentTarget).css({'transform': 'rotate(0deg)'});
		jQuery('#wcod_order_data_'+id).fadeOut(800);
	}
	else //expand
	{
		current_elem.addClass('wcod_collapse_icon');
		jQuery(event.currentTarget).css({'transform': 'rotate(180deg)'});
		jQuery('#wcod_order_data_'+id).fadeIn(800);
	}
	return false;
}