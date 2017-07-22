# routing

Sistema de Rotas simples...

$router = new \Preetender\Routing\Router();

$router->get('/', function (){ echo 'esse é um get'; });

`Para utilizar parametros informe-o com o prefixo ':' seguido do nome. `

$router->get('/:id', function ($id){ echo 'esse é um test ' . $id; });

`Para utilizar um controlador separe a Clase e o Metodo utilizado '@', a classe deve conter todo seu 'namespace' como no exemplo abaixo. `

$router->get('/hello/:name', 'App\\Controllers\\HomeController@index');

$router->post('/', function (){
    print_r( filter_input_array(INPUT_POST) );
});

$router->run();
