<?php 
class WCOD_Time
{
	function __construct()
	{
		
	}
	function convert_date_according_current_setting($date)
	{
		$date_format = get_option('date_format');
		$date_obj = date_create($date);
		return date_format($date_obj, $date_format);
	}
}
?>