<?php

/**
 * bringing the Request and Response classes into our script
 * so we don’t have to refer to them by their long-winded names.
 * PSR-7
 */
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/**
 * Startin SLim App with our configs
 */
$app = new Slim\App(['settings' => $config]);

/**
 * Dependencies Container
 */
$container = $app->getContainer();

/**
 * Loading Dependencies
 */
require_once('di.php');

/**
 * Loading Helpers
 */
 foreach (glob('system/helpers/*.php') as $filename) {
 	require_once($filename);
 }

/**
 * Check Options Method
 * Return Status 204
 */
 $app->add(new \Middlewares\OptionsMethodCheck);


/**
 * The / Route (root)
 */
$user_app = $app->group('', function() use ($app) {
	foreach (glob('system/routes/app/v1/my_*.php') as $filename) {
		require_once($filename);
	}
});

/**
 * V1 API
 */
$v1 = $app->group('/v1', function() use ($app){
	$app->get('/', '\Controllers\v1\MyHome');
	/**
	 * Loading all the routes of v1 api
	 */
	foreach (glob('system/routes/v1/my_*.php') as $filename) {
		require_once($filename);
	}
});



/**
 * Add Auth Middleware
 */
$v1->add(new \Middlewares\AuthMiddleware($container));
//$user_app->add(new \Middlewares\AppMiddleware($container));

/**
 * Add Session Middleware
 */

if (!empty($config['session']['name']))
{
	$sName = $config['session']['name'];
	$sAutoRefresh = $config['session']['autorefresh'];
	if (empty($sAutoRefresh))
	{
		$sAutoRefresh = false;
	}
	$sLifeTime = $config['session']['lifetime'];
	if (empty($sLifeTime))
	{
		$sLifeTime = '1 hour';
	}
	$v1->add(new \Slim\Middleware\Session([
		'name' => $sName,
		'autorefresh' => $sAutoRefresh,
		'lifetime' => $sLifeTime
	]));
	$user_app->add(new \Slim\Middleware\Session([
		'name' => $sName,
		'autorefresh' => $sAutoRefresh,
		'lifetime' => $sLifeTime
	]));
}


/**
 * Running The App
 */
$app->run();

?>
