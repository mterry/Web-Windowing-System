<?php
	require_once("/home/terrym/public_html/settings.php");
	require_once("/home/terrym/public_html/wws/src/user.php");
	require_once("/home/terrym/public_html/wws/src/session.php");
	require_once("/home/terrym/public_html/wws/src/utils.php");
	require_once("/home/terrym/public_html/wws/src/email_validation.php");

	session_start();

	class Create_Account extends Application
	{
		public function post_response()
		{
			if ((check_array($_SESSION, "invalid_input")) != null)
			{
				$_SESSION["invalid_input"] = array();
			}
			else
			{
				foreach ($_SESSION["invalid_input"] as $key => $value)
				{
					unset($key);
				}
			}

			// validation of form input
			if (($invalid_input = check_array($_POST, "screenname", "password", "full_name", "email", "age")) != null)
			{
				foreach($invalid_input as $value)
				{
					$_SESSION["invalid_input"][$value] = "Missing value";
				}
			}
			else
			{
				$temp_user = new User();
				$temp_user->screenname = "";
				if (count($temp_user->get_by_screenname($_POST["screenname"])) != 0)
				{
					$_SESSION["invalid_input"]["screenname"] = "Screen name already exists";
				}
				$temp_user = null;
				if (!is_valid_email_address($_POST["email"]))
				{
					$_SESSION["invalid_input"]["email"] = "Invalid email address";
				}
				if (intval($_POST["age"]) < 13)
				{
					$_SESSION["invalid_input"]["age"] = "You are not 13 or older";
				}
			}
			if (count($_SESSION["invalid_input"]) == 0)
			{
				$user = new User();
				$session = new Session();

				$user->create($_POST["screenname"], sha1($_POST["password"]), $_POST["full_name"], $_POST["email"], $_POST["age"]);
				$session->create($user->id);

				$_SESSION["session"] = $session->id;
			}
		}

		public function get_response()
		{
			$temp_create_account = new Create_Account();
			$temp_create_account->name = "";
			$results = $temp_create_account->get_by_name("Create_Account");
			if (empty($results))
			{
				$this->create("Create_Account", "default.png", true);
			}
			else
			{
				$this->id = $results[0]->id;
				$this->name = $results[0]->name;
				$this->icon_path = $results[0]->icon_path;
				$this->public = $results[0]->public;
			}

			parent::get_response();
		}
	}
?>
