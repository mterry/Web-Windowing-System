<?php
	require_once("database_access.php");
	class Session extends DBObject
	{
		public function create(
			$sessionid, $appstatusid, $appid
			)
		{
			$this->appid = $appid;
			$this->appstatusid = $appstatusid;
			$this->sessionid = $sessionid;

			$this->set();

			return $this;
		}

		public function __construct($table = "wws.openapps")
		{
			parent::__construct($table);
		}

		public function has_openapps($sessionid)
		{
			return ((this->get_by_sessionid($sessionid)) ? true : false);
		}
	}
?>
