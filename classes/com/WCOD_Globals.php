<?php 
function wcod_url_exists($url) 
{
    $headers = @get_headers($url);
	if(strpos($headers[0],'200')===false) return false;
	
	return true;
}
function wcod_get_value_if_set($data, $nested_indexes, $default = false)
{
	if(!isset($data))
		return $default;
	
	$nested_indexes = is_array($nested_indexes) ? $nested_indexes : array($nested_indexes);
	//$current_value = null;
	foreach($nested_indexes as $index)
	{
		if(!isset($data[$index]))
			return $default;
		
		$data = $data[$index];
		//$current_value = $data[$index];
	}
	
	return $data;
}
$wcod_result = get_option("_".$wcod_id);
//$wcod_notice = !$wcod_result || $wcod_result != md5($_SERVER['SERVER_NAME']);
$wcod_notice = false;
/* if($wcod_notice)
	remove_action( 'plugins_loaded', 'wcod_setup'); */
if(!$wcod_notice)
	wcod_setup();
function wcod_write_log ( $log )  
{
  if ( is_array( $log ) || is_object( $log ) ) {
	 error_log( print_r( $log, true ) );
  } else {
	 error_log( $log );
  }
}
function wcod_start_with($haystack, $needle)
{
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}
?>