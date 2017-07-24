# preetender/routing

Inscreva rotas de forma simples..

  - Verbos GET, POST, PUT, PATCH e DELETE
  - Formatação Automática
  - Resposta Personalizada

# Começando!
Para iniciar o roteador basta instanciar a classe 'Preetender\Routing\Router', siga o exemplo abaixo;
 ```sh
 use Preetender\Routing\Router;
 $router = new Router();
 ```

Como informado acima, o roteador responde aos verbos citados acima GET, POST, PUT, PATCH e DELETE.
Para rotear uma chamada é importante informar o `$path` e o `$callback`, o `$path` é o caminho que será mapeado e o `$callback` nada mais é que a regra s ser executada na chamada.
```sh
 $router->get('/', function(){ return 'hello word'; });
 ```
 Nosso simples roteador entende que seu retorno é do tipo `string` e assim a classe `"TextPlainRenderer"` é acionada; você é livre para edita-lá da maneira que lhe convier.
 
 Quando a responsta é do tipo `array` nosso mecanismo formata e retorna como `json`.
 ```sh
 $router->get('/', function(){ return ['data' => 'hello word'] });
 ```
 
 Obteremos a seguinte resposta: 
 ```sh
 {
    "data": "hello world"
 }
 ```
 
 Caso possua um Controlador em sua aplicação, informe-a com seu `namespace` no parametro `$callable` desta forma:
 ```sh
 $router->get('/', 'App\\Controllers\\MeuControlador@index'});
 ```
 Separando o método acionado com o simbolo '@'.
 
 Caso necessite informar parametros no seu roteador, basta acrescentá-lo na `$path` com o Prefixo `":"` desta forma:
 
 ```sh
 $router->get('users/:id', function($id){ return compact('id') });
 ```
 
 E para que tudo aconteça basta acionar o método `run`
 
 ```sh
  $router->run();
  ```
 
 
 Viu como é simples?! para os demais verbos siga os mesmos passos...
