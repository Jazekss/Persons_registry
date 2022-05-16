<?php
require_once 'vendor/autoload.php';

use App\Controllers\AddController;
use App\Controllers\EditController;
use App\Controllers\ErrorsController;
use App\Controllers\IndexController;
use App\Redirect;
use App\View;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

session_start();

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
	/** ** ** Show all persons * * */
	$r->addRoute( 'GET', '/', [IndexController::class, 'index']);
  /** ** ** Add new person * * */
	$r->addRoute( 'GET', '/add', [AddController::class, 'add']);
  $r->addRoute('POST', '/add', [AddController::class, 'store']);
  /** ** ** Edit person * * */
  $r->addRoute( 'GET', '/edit/{id:\d+}', [EditController::class, 'edit']);
  $r->addRoute('POST', '/edit/{id:\d+}', [EditController::class, 'update']);
  /** ** ** Delete person * * */
  $r->addRoute( 'GET', '/delete/{id:\d+}', [EditController::class, 'delete']);
  /** ** ** Error pages * * */ // Won't work correctly
  $r->addRoute( 'GET', '/Errors/404', [ErrorsController::class, 'e404']);
  $r->addRoute( 'GET', '/Errors/405', [ErrorsController::class, 'e405']);
});
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
if (false !== $pos = strpos($uri, '?')) {
	$uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
	case FastRoute\Dispatcher::NOT_FOUND:
    return new View('/Errors/404');
//		var_dump("404 Not Found");
//		break;
	case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
		$allowedMethods = $routeInfo[1];
    return new View('/Errors/405');
//		var_dump("405 Method Not Allowed");
//		break;
	case FastRoute\Dispatcher::FOUND:
		$controller = $routeInfo[1][0];
		$method = $routeInfo[1][1];
		/** @var View $response */
		$response = (new $controller)->$method($routeInfo[2]);
		$twig = new Environment(new FilesystemLoader('app/Views'));
		if($response instanceof View) {
			echo $twig->render($response->getPath() . '.html', $response->getVariables());
		}
		if($response instanceof Redirect){
			header('Location: ' . $response->getLocation());
			exit;
		}
		break;
}
if(isset($_SESSION['status'])){
	unset($_SESSION['status']);
}