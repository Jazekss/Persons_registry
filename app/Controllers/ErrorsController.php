<?php

namespace App\Controllers;
use App\View;

class ErrorsController
{
  public function e404():View	{
    return new View('Errors/404', [
    ]);
  }
  public function e405():View	{
    return new View('Errors/405', [
    ]);
  }
}