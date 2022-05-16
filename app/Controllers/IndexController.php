<?php
namespace App\Controllers;
use App\Models\User;
use App\View;
use App\Database;

class IndexController
{
	public function index():View	{
    $usersQuery = Database::connection()
      ->createQueryBuilder()
      ->select('*')
      ->from('users')
      ->orderBy('id', 'desc')
      ->executeQuery()
      ->fetchAllAssociative();
    $users = [];
    foreach ($usersQuery as $user) {
      $users[] = new User(
        (int)$user['id'],
        (string)$user['user_name'],
        (string) $user['user_email'],
        (string) $user['user_password'],
        (int) $user['user_age'],
        (string) $user['user_created']
      );
    }
    return new View('/index', [
      "users" => $users
    ]);
	}
}