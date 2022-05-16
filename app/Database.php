<?php
namespace App;
use Doctrine\DBAL\DriverManager;

class Database
{
	private static $connection = null;
  public static function connection(): ?\Doctrine\DBAL\Connection
  {
		if(self::$connection === null) {
			$connectionParams = [
				'dbname' => 'crudApp',
				'user' => 'root',
				'pass' => '',
				'host' => 'localhost',
				'driver' => 'pdo_mysql'
			];
			self::$connection = DriverManager::getConnection($connectionParams);
		}
		return self::$connection;
	}
}