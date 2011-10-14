<?php
	require_once("/home/terrym/public_html/settings.php");
	function __autoload($classname)
	{
		global $LOCALAPPLICATIONS, $LOCALPHP;
		
		file_exists($LOCALAPPLICATIONS . strtolower($classname) . ".php") ?
			include $LOCALAPPLICATIONS . strtolower($classname) . ".php" :
			include $LOCALPHP . strtolower($classname) . ".php";
	}
	
	$obj = new ReflectionClass($_REQUEST["class"]);
	if ($obj->isAbstract())
	{
		$response = $_REQUEST["class"]::$_REQUEST["method"]();
		if (!empty($response))
		{
			echo json_encode($response);
		}
	}
	else
	{
		$obj = new $_REQUEST["class"];
		$response = $obj->$_REQUEST["method"]();
		if (!empty($response))
		{
			echo json_encode($response);
		}
	}
?>
