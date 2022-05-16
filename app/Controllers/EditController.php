<?php
namespace App\Controllers;
use App\Models\User;
use App\View;
use App\Database;
use App\Redirect;

class EditController
{
  public function edit(array $vars):View
  {
    $usersQuery = Database::connection()
      ->createQueryBuilder()
      ->select('*')
      ->from('users')
      ->where("id = ?")
      ->setParameter(0, (int)$vars['id'])
      ->fetchAllAssociative();
    $user = new User(
      (int)$usersQuery[0]['id'],
      (string)$usersQuery[0]['user_name'],
      (string)$usersQuery[0]['user_email'],
      (string)$usersQuery[0]['user_password'],
      (int)$usersQuery[0]['user_age'],
      (string)$usersQuery[0]['user_created']
    );
    return new View('/edit', [
      "user" => $user
    ]);
  }
  public function update(array $vars):Redirect	{
    Database::connection()
      ->update("users", [
        'user_name' => $_POST['name'],
        'user_email' => $_POST['email'],
        'user_password' => $_POST['password'],
        'user_age' => $_POST['age'],
    ], ['id' => (int)$vars['id']]);
    session_start();
    $_SESSION['status'] = 'Person updated successfully';
    return new Redirect("/");
  }

  public function delete(array $vars):Redirect {
    Database::connection()
      ->delete('users', [
        'id' => (int)$vars['id']
      ]);
    session_start();
    $_SESSION['status'] = 'Person deleted successfully';
    return new Redirect('/');
  }
}