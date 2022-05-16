<?php
namespace App\Controllers;
use App\View;
use App\Database;
use App\Redirect;

class AddController
{
  public function add():View {
    return new View('/add');
  }
  public function store():Redirect {
    Database::connection()
      ->insert('users', [
        'user_name' => $_POST['name'],
        'user_email' => $_POST['email'],
        'user_password' => $_POST['password'],
        'user_age' => $_POST['age'],
      ]);
    session_start();
    $_SESSION['status'] = 'Person added successfully';
    return new Redirect('/', [
    ]);
  }
}