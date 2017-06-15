<?php
$routes = require 'configs/routes.php';
$defaultRoute = $routes['default'];
$routeParts = explode( '/', $defaultRoute );

$method = $_SERVER['REQUEST_METHOD'];
$r = $_REQUEST['r'] ?? $routeParts[1];
$a = $_REQUEST['a'] ?? $routeParts[2];
$route = strtoupper( $method ) . '/' . $r . '/' . $a;

if ( !in_array( $route, $routes ) ) {
    //die ( json_encode( [ 'error' => 'La route utilisée n\'est pas permise', 'route' => $route ], JSON_UNESCAPED_UNICODE ) );
    die( 'La route utilisée n\'est pas permise' );

    // Gérer API vs layout pour cette erreur aussi
}

$controllerName = 'Controllers\\' . ucfirst($r);
$controller =  new $controllerName();

$data = call_user_func( [$controller, $a] );

//echo json_encode( $data, JSON_UNESCAPED_UNICODE );
