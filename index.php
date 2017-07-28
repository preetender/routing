<?php
/**
 * Created by PhpStorm.
 * User: cesinha
 * Date: 28/07/17
 * Time: 10:57
 */

require __DIR__ . '/vendor/autoload.php';

$request = new \Symfony\Component\HttpFoundation\Request();


$router = new \Preetender\Routing\Router( $request );

$router->get('/', function() {
    return 'hello get';
});

//$router->get('/:id', function($id) {
//    return 'hello get  '. $id;
//});

$router->get('/test', 'App\\TestController@index');

$router->post('/', function(\Symfony\Component\HttpFoundation\Request $request) {

    return $request->request->all();

});

$router->run();