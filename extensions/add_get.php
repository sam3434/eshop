<?php 
	function add_get($url, $param, $pvalue = '') 
	{
    	$res = $url;
    	if (($p = strpos($res, '?')) !== false) 
    	{
	    	$paramsstr = substr($res, $p + 1);
		    $params = explode('&', $paramsstr);
		    $paramsarr = array();
		    foreach ($params as $value) 
		    {
	    		$tmp = explode('=', $value);
	    		$paramsarr[$tmp[0]] = (string) $tmp[1];
	    	}
	    	$paramsarr[$param] = $pvalue;
	    	$res = substr($res, 0, $p + 1);
	    	foreach ($paramsarr as $key => $value) 
	    	{
	    		$str = $key;
	    		if ($value !== '') 
	    		{
	    			$str .= '=' . $value;
	    		}
	    		$res .= $str . '&';
	    	}
	    	$res = substr($res, 0, -1);
    	} 
    	else 
    	{
    		$str = $param;
    		if ($pvalue) 
    		{
    			$str .= '=' . $pvalue;
    		}
    		$res .= '?' . $str;
    	}
    	return $res;
    }
 ?>