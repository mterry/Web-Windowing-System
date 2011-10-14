<?php
	require_once("database_access.php");
	class AppStatus extends DBObject
	{
		public function create($size,	$position)
		{

			$this->size = $size;
			$this->position = $position;

			$this->set();

			return $this;
		}

		public function __construct($table = "wws.appstatus")
		{
			parent::__construct($table);
		}
	}
?>
