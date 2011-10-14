<?php
	require_once("database_access.php");
	require_once("/home/terrym/public_html/settings.php");
	abstract class Application extends DBObject
	{
		public function create($name, $icon_path, $public)
		{
			global $WEBIMGAPP;
			
			$this->name = $name;
			$this->icon_path = $WEBIMGAPP . $icon_path;
			$this->public = $public;

			$this->set();

			return $this;
		}

		public function __construct($table = "wws.application")
		{
			parent::__construct($table);
		}

		public abstract function post_response();

		public function get_response()
		{
			global $LOCALXMLAPP, $LOCALXSLAPP, $WEBSCRIPTAPP;

			$xml = new DOMDocument;
			$xsl = new DOMDocument;
			$xml->load($LOCALXMLAPP . $this->name . ".xml");
			$xsl->load($LOCALXSLAPP . "application.xsl");

			$xslt = new XSLTProcessor();
			$xslt->importStylesheet($xsl);
			$xslt->setParameter(NULL, "scriptapp", $WEBSCRIPTAPP);
			$xslt->setParameter(NULL, "scriptappname", $this->name . ".js");
			$output = $xslt->transformToXML($xml);

			$response["xml"] = $output;
			
			header("Content-Type: application/xml");
			echo $response["xml"];
		}

		public static function json_get_app_list()
		{
			$dbo = new DBObject("wws.application");
			$dbo->public = false;

			if (empty($_SESSION["session"]) || $_SESSION["session"] == "0")
			{
				$objs = $dbo->get_by_public(true);
				
				return $objs;
			}
			else
			{
				$publicobjs = $dbo->get_by_public(true);
				$privateobjs = $dbo->get_by_public(false);

				$response = array();
				foreach ($publicobjs as $obj)
				{
					if (!($obj->name == "login" || $obj->name == "create_account"))
					{
						$response []= $obj;
					}
				}
				foreach ($privateobjs as $obj)
				{
					$response []= $obj;
				}
				return $response;
			}
		}
	}
?>
