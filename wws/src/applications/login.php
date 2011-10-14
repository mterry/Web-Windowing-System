<?php
	require_once("/home/terrym/public_html/settings.php");
	require_once("/home/terrym/public_html/wws/src/user.php");
	require_once("/home/terrym/public_html/wws/src/session.php");
	require_once("/home/terrym/public_html/wws/src/application.php");
	require_once("/home/terrym/public_html/wws/src/utils.php");
	require_once("/home/terrym/public_html/wws/src/email_validation.php");

	session_start();

	class Login extends Application
	{
		public function post_response()
		{
			if ($invalid_input = check_array($_POST, "screenname", "password") == null)
			{
				foreach ($invalid_input as $value)
				{
					$_SESSION["invalid_input"][$value] = "Missing value";
				}
			}

			$temp_user = new User();
			$temp_user->screenname = "";
			if (count($results = $temp_user->get_by_screenname($_POST["screenname"])) == 0)
			{
				$_SESSION["invalid_input"]["screenname"] = "Screen name does not exist";
			}
			else
			{
				if($temp_user->password == sha1($_POST["password"]))
				{
					$_SESSION["invalid_input"]["password"] = "Invalid password";
				}
				else
				{
					$temp_user = $results[0];
				}
			}

			if (count($_SESSION["invalid_input"]) == 0)
			{
				$temp_session = new Session();
				$temp_session->user_id = 0;
				$temp_session = $temp_session->get_by_user_id($temp_user->id);
				$_SESSION["session"] = $temp_session->id;
				$_SESSION["status"] = "success";
			}
			else
			{
				$_SESSION["status"] = "error";
			}

			echo json_encode($_SESSION);
		}

		public function get_response()
		{
			$temp_login = new Login();
			$temp_login->name = "";
			$results = $temp_login->get_by_name("Login");
			if (empty($results))
			{
				$this->create("Login", "default.png", true);
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
