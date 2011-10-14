<?php
	require_once("database_access.php");
	class User extends DBObject
	{
		public function create(
			$screenname, $hashed_password, $full_name, $email, $age
			)
		{
			global $IMAGES;

			$this->screenname = $screenname;
			$this->hashed_password = $hashed_password;
			$this->avatar_path = $IMAGES . "default.jpg";
			$this->full_name = $full_name;
			$this->email = $email;
			$this->age = $age;

			$this->set();

			return $this;
		}

		public function __construct($table = "wws.user")
		{
			parent::__construct($table);
		}
	}
?>
