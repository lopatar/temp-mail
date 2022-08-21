<?php
declare(strict_types=1);

namespace app\database;

use Exception;
use mysqli;
use mysqli_result;

final class mysqli_wrapper
{
	private mysqli $connection;

	public function __construct(string $host, string $username, string $password, string $db_name) {
		$this->connection = new mysqli($host, $username, $password, $db_name); //create mysqli object
	}

	public function __destruct() {
		$this->connection->close(); //close connection on destructor
	}

	/**
	 * @throws Exception
	 */
	public function query(string $query, array $args = [], string $types = null): mysqli_result|false {
		if ($types === null && $args !== []) { //if we have arguments and no types are specified we act as if they were all strings
			$types = str_repeat('s', count($args));
		}

		$stmt = $this->connection->prepare($query); //prepare the query

		if (!$stmt) {
			throw new Exception('Error preparing query');
		}

		if (str_contains($query, '?')) {
			$stmt->bind_param($types, ...$args); //bind our parameters to the query
		}

		$stmt->execute(); //execute our query

		$result = $stmt->get_result(); //get query result

		$stmt->close(); //close db handle

		return $result; //return result
	}

	public function get_connection(): mysqli {
		return $this->connection;
	}
}