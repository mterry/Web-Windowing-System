<?php
	require_once("/home/terrym/public_html/settings.php");
	//	create_dbo() will either create a new PDO connection with the
	//	connection information specified in settings.php and return it,
	//	or it will return NULL
	function create_dbo($dbname, $user, $password)
	{
		try
		{
			$dbo = new PDO("pgsql:dbname=$dbname;host=localhost", $user, $password);
		}
		catch(PDOException $e)
		{
			return null;
		}
		return $dbo;
	}

	//	close_dbo() will close the DBO connection by setting it to NULL
	function close_dbo()
	{
		$dbo = null;
	}

	class DBObject
	{
		public $fields;
		public $table;
		public $id_field;
		public static $dbo = null;

		public function __get($field)
		{
			return $this->fields[$field];
		}

		public function __set($field, $value)
		{
			$this->fields[$field] = $value;
		}

		public function __construct($table, $id_field="id")
		{
			if (!isset($table) || $table == "")
			{
				return null;
			}
			global $USER, $DBNAME, $PASSWORD;
			$this->table = $table;
			$this->id_field = $id_field;
			if (self::$dbo == null)
			{
				self::$dbo = create_dbo($DBNAME, $USER, $PASSWORD);
			}
		}

		public function __call($method, $params)
		{
			/// public function get_by_[field_name](fieldname)
			if (preg_match("/^get_by_(?P<field>\w+)$/", $method, $matches))
			{
				$matchfield = $matches["field"];
				$statement = self::$dbo->prepare(
					"SELECT * FROM {$this->table} WHERE $matchfield = :param",
					array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY)
				);
				$statement->execute(array($params[0]));
				$result = $statement->fetchAll(PDO::FETCH_ASSOC);
				$objects = array();
				foreach ($result as $row)
				{
					$obj = new DBObject($this->table, $this->id_field);
					foreach ($row as $key => $value)
					{
						$obj->fields[$key] = $value;
					}
					$objects []= $obj;
				}
				return $objects;
			}
		}

		public function set()
		{
			if (!isset($this->fields[$this->id_field]))
			{
				$columns = array();
				$binds = array();
				$values = array();
				foreach ($this->fields as $key => $value)
				{
					$columns []= $key;
					$binds []= ":$key";
					$values []= $value;
				}
				$columns = implode(", ", $columns);
				$binds = implode(", ", $binds);

				try
				{
					self::$dbo->beginTransaction();
					$statement = self::$dbo->prepare(
						"INSERT INTO {$this->table} ($columns) VALUES ($binds)",
						array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY)
					);
					$statement->execute($values);
					$sequence_name = "'{$this->table}_{$this->id_field}_seq'";
					$statement = self::$dbo->prepare(
						"SELECT currval($sequence_name)",
						array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY)
					);
					$statement->execute();
					self::$dbo->commit();
					$this->fields[$this->id_field] = $statement->fetchColumn();
				}
				catch (Exception $e)
				{
					self::$dbo->rollback();
					print "Failed to commit transaction\n";
				}
			}
			else
			{
				$keybinds = array();
				$values = array();
				foreach ($this->fields as $key => $value)
				{
					$keybinds []= "$key = :$key";
					$values []= $value;
				}
				$keybinds = implode(", ", $keybinds);

				$statement = self::$dbo->prepare(
					"UPDATE {$this->table} SET $keybinds WHERE {$this->id_field} = :{$this->id_field}",
					array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY)
				);
				$statement->execute($values);
			}
		}

		public function get($id)
		{
			$method = "get_by_{$this->id_field}";
			if ($results = $this->$method($id))
			{
				return $results[0];
			}
			
			return null;
		}
	}
?>
