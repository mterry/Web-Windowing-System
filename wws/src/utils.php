<?php
	function getElementById($dom, $id)
	{
		$xpath = new DOMXPath($dom);
		return $xpath->query("//*[@id='$id']")->item(0);
	}

	function check_array($array)
	{
		$invalid_args = array();
		$args = func_get_args();
		unset($args[0]);
		foreach($args as $arg)
		{
			if (!array_key_exists($arg, $array) || $args[$arg] == "")
			{
				$invalid_args []= $arg;
			}
		}
		return ((count($invalid_args) == 0) ? null : $invalid_args);
	}
?>
