<?php
	require_once("database_access.php");
	class Session extends DBObject
	{
		public function create($user_id)
		{

			$this->user_id = $user_id;

			$this->set();

			return $this;
		}

		public function __construct($table = "wws.session")
		{
			parent::__construct($table);
		}

		public function has_session($user_id)
		{
			return ((self::$get_by_user_id($user_id)) ? true : false);
		}
	}
?>
